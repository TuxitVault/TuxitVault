<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $plan = 'price_1RTITKGgofiP5UMmJMUfET5h')
    {
        return $request->user()
            ->newSubscription('default', $plan)
            ->checkout([
                'success_url' => route('success'),
                'cancel_url' => route('myFiles'),
            ]);
    }
}
