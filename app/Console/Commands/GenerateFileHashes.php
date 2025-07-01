<?php

namespace App\Console\Commands;

use App\Models\File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateFileHashes extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'files:generate-hashes {--user-id= : ID de l\'utilisateur spécifique}';

    /**
     * The console command description.
     */
    protected $description = 'Génère les hash SHA256 pour tous les fichiers sans hash';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->option('user-id');

        $query = File::where('is_folder', false)
            ->where(function($q) {
                $q->whereNull('hash')
                    ->orWhere('hash', '');
            });

        if ($userId) {
            $query->where('created_by', $userId);
        }

        $files = $query->get();

        $this->info("Traitement de {$files->count()} fichiers...");

        $bar = $this->output->createProgressBar($files->count());
        $bar->start();

        $processed = 0;
        $errors = 0;

        foreach ($files as $file) {
            try {
                if ($file->storage_path && Storage::disk('local')->exists($file->storage_path)) {
                    $filePath = Storage::disk('local')->path($file->storage_path);
                    $hash = hash_file('sha256', $filePath);

                    // Mise à jour directe en base sans déclencher les events
                    \DB::table('files')
                        ->where('id', $file->id)
                        ->update(['hash' => $hash]);

                    $processed++;
                } else {
                    $this->warn("\nFichier introuvable: {$file->storage_path}");
                    $errors++;
                }
            } catch (\Exception $e) {
                $this->error("\nErreur pour le fichier {$file->id}: " . $e->getMessage());
                $errors++;
            }

            $bar->advance();
        }

        $bar->finish();

        $this->newLine();
        $this->info("✅ {$processed} fichiers traités avec succès");

        if ($errors > 0) {
            $this->warn("⚠️ {$errors} erreurs rencontrées");
        }

        return Command::SUCCESS;
    }
}
