<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function cancel(Request $request)
    {
        $user = auth()->user();

        try {
            if ($user && $user->subscribed()) {
                $user->subscription()->cancel();

                return redirect()->back()->with('success', 'Abonnement annulé avec succès');
            }

            return redirect()->back()->with('error', 'Aucun abonnement actif trouvé');

        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'annulation: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de l\'annulation');
        }
    }
}
