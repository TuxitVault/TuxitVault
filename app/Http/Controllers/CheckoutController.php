<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $plan = 'price_1RTITKGgofiP5UMmJMUfET5h')
    {
        return $request->user()
            ->newSubscription('prod_SO4caoQ76eld7d', $plan)
            ->checkout([
                'success_url' => route('success'),
                'cancel_url' => route('myFiles'),
            ]);
    }
}
