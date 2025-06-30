<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PricingController extends Controller
{
    /**
     * Affiche la page de tarifs avec gestion des abonnements
     */
    public function index()
    {
        $user = auth()->user();
        $subscription = null;

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
                    'cancel_at_period_end' => $stripeData->cancel_at_period_end, // AJOUT
                    'start_date' => $stripeSubscription->created_at->format('d/m/Y'),
                    'next_billing_date' => $stripeData->current_period_end
                        ? date('d/m/Y', $stripeData->current_period_end)
                        : 'Non défini',
                ];
            }
        }

        return Inertia::render('Pricing', [
            'subscription' => $subscription
        ]);
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
