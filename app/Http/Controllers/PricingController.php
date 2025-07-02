<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class PricingController extends Controller
{
    /**
     * Affiche la page de tarifs avec gestion des abonnements
     */
    public function index()
    {
        $user = auth()->user();
        $subscription = null;
        $storageInfo = null;

        if ($user && $user->subscribed()) {
            $stripeSubscription = $user->subscription();

            if ($stripeSubscription) {
                // Récupérer les données Stripe directement
                $stripeData = $stripeSubscription->asStripeSubscription();

                $subscription = [
                    'plan_id' => $stripeSubscription->stripe_price,
                    'plan_name' => $this->getPlanName($stripeSubscription->stripe_price),
                    'amount' => $this->getPlanAmount($stripeSubscription->stripe_price),
                    'interval' => 'mois',
                    'status' => $stripeSubscription->stripe_status,
                    'cancel_at_period_end' => $stripeData->cancel_at_period_end,
                    'start_date' => $stripeSubscription->created_at->format('d/m/Y'),
                    'next_billing_date' => $stripeData->current_period_end
                        ? date('d/m/Y', $stripeData->current_period_end)
                        : 'Non défini',
                ];

                // Calculer les informations de stockage
                $storageInfo = $this->calculateStorageInfo($user, $stripeSubscription->stripe_price);
            }
        }

        return Inertia::render('Pricing', [
            'subscription' => $subscription,
            'storageInfo' => $storageInfo
        ]);
    }

    /**
     * Calcule les informations de stockage pour l'utilisateur
     */
    private function calculateStorageInfo($user, $priceId)
    {
        // Calculer l'espace utilisé (en bytes)
        $usedSpace = File::where('created_by', $user->id)
            ->where('is_folder', false)
            ->whereNull('deleted_at')
            ->sum('size') ?? 0;

        // Obtenir la limite selon le plan
        $storageLimit = $this->getStorageLimit($priceId);

        // Calculer le pourcentage d'utilisation
        $usagePercentage = $storageLimit > 0 ? ($usedSpace / $storageLimit) * 100 : 0;

        return [
            'used' => $usedSpace,
            'used_formatted' => $this->formatBytes($usedSpace),
            'limit' => $storageLimit,
            'limit_formatted' => $this->formatBytes($storageLimit),
            'usage_percentage' => min(100, round($usagePercentage, 1)),
            'remaining' => max(0, $storageLimit - $usedSpace),
            'remaining_formatted' => $this->formatBytes(max(0, $storageLimit - $usedSpace)),
        ];
    }

    /**
     * Retourne la limite de stockage selon le plan (en bytes)
     */
    private function getStorageLimit($priceId)
    {
        return match($priceId) {
            'price_1RTIkqGgofiP5UMmYOAcDqfb' => 100 * 1024 * 1024 * 1024, // 100 GB
            'price_1RTITKGgofiP5UMmJMUfET5h' => 1024 * 1024 * 1024 * 1024, // 1 TB
            default => 0
        };
    }

    /**
     * Formate les bytes en format lisible
     */
    private function formatBytes($bytes, $precision = 2)
    {
        if ($bytes === 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
        $power = min($power, count($units) - 1);

        return number_format($bytes / pow(1024, $power), $precision) . ' ' . $units[$power];
    }

    private function getPlanName($priceId)
    {
        return match($priceId) {
            'price_1RTIkqGgofiP5UMmYOAcDqfb' => 'Basic Monthly',
            'price_1RTITKGgofiP5UMmJMUfET5h' => 'Pro Monthly',
            default => 'Plan inconnu'
        };
    }

    private function getPlanAmount($priceId)
    {
        return match($priceId) {
            'price_1RTIkqGgofiP5UMmYOAcDqfb' => '9.99',
            'price_1RTITKGgofiP5UMmJMUfET5h' => '19.99',
            default => '0.00'
        };
    }
}
