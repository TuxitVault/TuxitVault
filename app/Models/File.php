<?php

namespace App\Models;

use App\Traits\HasCreatorAndUpdater;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Kalnoy\Nestedset\NodeTrait;

class File extends Model
{
    use HasFactory, HasCreatorAndUpdater, NodeTrait, SoftDeletes;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(File::class, 'parent_id');
    }

    public function starred()
    {
        return $this->hasOne(StarredFile::class, 'file_id', 'id')
            ->where('user_id', Auth::id());
    }

    public function owner(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                return $attributes['created_by'] == Auth::id() ? 'me' : $this->user->name;
            }
        );
    }

    public function isOwnedBy($userId): bool
    {
        return $this->created_by == $userId;
    }

    public function isRoot()
    {
        return $this->parent_id === null;
    }

    public function get_file_size()
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $power = $this->size > 0 ? floor(log($this->size, 1024)) : 0;

        return number_format($this->size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->parent) {
                return;
            }
            $model->path = ( !$model->parent->isRoot() ? $model->parent->path . '/' : '' ) . Str::slug($model->name);
        });

//        static::deleted(function(File $model) {
//            if (!$model->is_folder) {
//                Storage::delete($model->storage_path);
//            }
//        });
    }

    public function moveToTrash()
    {
        $this->deleted_at = Carbon::now();

        return $this->save();
    }

    public function deleteForever()
    {
        $this->deleteFilesFromStorage([$this]);
        $this->forceDelete();
    }

    public function deleteFilesFromStorage($files)
    {
        foreach ($files as $file) {
            if ($file->is_folder) {
                $this->deleteFilesFromStorage($file->children);
            } else {
                Storage::delete($file->storage_path);
            }
        }
    }

    public static function getSharedWithMe()
    {
        return File::query()
            ->select('files.*')
            ->join('file_shares', 'file_shares.file_id', 'files.id')
            ->where('file_shares.user_id', Auth::id())
            ->orderBy('file_shares.created_at', 'desc')
            ->orderBy('files.id', 'desc');
    }

    public static function getSharedByMe()
    {
        return File::query()
            ->select('files.*')
            ->join('file_shares', 'file_shares.file_id', 'files.id')
            ->where('files.created_by', Auth::id())
            ->orderBy('file_shares.created_at', 'desc')
            ->orderBy('files.id', 'desc')
            ;
    }

    /**
     * Générer et enregistrer le hash SHA256 du fichier
     */
    public function generateHash(): void
    {
        if (!$this->is_folder && $this->storage_path) {
            $filePath = Storage::disk('local')->path($this->storage_path);

            if (file_exists($filePath)) {
                $this->hash = hash_file('sha256', $filePath);
                // Désactiver les timestamps automatiques pour éviter l'erreur updated_by
                $this->timestamps = false;
                $this->save();
                $this->timestamps = true;
            }
        }
    }

    /**
     * Vérifier l'intégrité du fichier
     */
    public function verifyIntegrity(): bool
    {
        if (!$this->is_folder && $this->storage_path && $this->hash) {
            $filePath = Storage::disk('local')->path($this->storage_path);

            if (file_exists($filePath)) {
                $currentHash = hash_file('sha256', $filePath);
                $isIntact = ($currentHash === $this->hash);

                $this->integrity_verified = $isIntact;
                $this->timestamps = false;
                $this->save();
                $this->timestamps = true;

                return $isIntact;
            }
        }

        return false;
    }

    /**
     * Vérifier si le fichier a été modifié
     */
    public function isModified(): bool
    {
        if (!$this->is_folder && $this->storage_path && $this->hash) {
            $filePath = Storage::disk('local')->path($this->storage_path);

            if (file_exists($filePath)) {
                $currentHash = hash_file('sha256', $filePath);
                return ($currentHash !== $this->hash);
            }
        }

        return false;
    }

    /**
     * Calculer l'espace de stockage utilisé par un utilisateur
     */
    public static function calculateUserStorageUsage($userId): int
    {
        return self::where('created_by', $userId)
            ->where('is_folder', false)
            ->whereNull('deleted_at')
            ->sum('size') ?? 0;
    }

    /**
     * Obtenir les statistiques de stockage pour un utilisateur
     */
    public static function getStorageStats($userId): array
    {
        $totalFiles = self::where('created_by', $userId)
            ->where('is_folder', false)
            ->whereNull('deleted_at')
            ->count();

        $totalFolders = self::where('created_by', $userId)
            ->where('is_folder', true)
            ->whereNull('deleted_at')
            ->count();

        $usedSpace = self::calculateUserStorageUsage($userId);

        $trashedFiles = self::onlyTrashed()
            ->where('created_by', $userId)
            ->where('is_folder', false)
            ->count();

        $trashedSpace = self::onlyTrashed()
            ->where('created_by', $userId)
            ->where('is_folder', false)
            ->sum('size') ?? 0;

        return [
            'total_files' => $totalFiles,
            'total_folders' => $totalFolders,
            'used_space' => $usedSpace,
            'trashed_files' => $trashedFiles,
            'trashed_space' => $trashedSpace,
        ];
    }
}
