<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Cashier\Http\Controllers\WebhookController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/policy', function () {
    return Inertia::render('Policy');
})->name('policy');

#Route::post('/stripe/webhook', [WebhookController::class, 'handleWebhook'])->name('cashier.webhook');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Profile/Show');
    })->name('dashboard');
    Route::get('/profile', function () {
        return Inertia::render('Profile/Show');
    })->name('profile');
    Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
    Route::get('checkout/{plan?}', CheckoutController::class)
        ->middleware(['auth', 'verified'])
        ->name('checkout');
    Route::get('/success', function () {
        return Inertia::render('Success');
    })->name('success');
    Route::controller(FileController::class)->group(function () {
        Route::get('/my-files/{folder?}', 'myFiles')
            ->where('folder', '(.*)')
            ->name('myFiles');
        Route::get('/trash', 'trash')->name('trash');
        Route::post('/folder/create', 'createFolder')->name('folder.create');
        Route::post('/file', 'store')->name('file.store');
        Route::delete('/file', 'destroy')->name('file.delete');
        Route::post('/file/restore', 'restore')->name('file.restore');
        Route::delete('/file/delete-forever', 'deleteForever')->name('file.deleteForever');
        Route::post('/file/share', 'share')->name('file.share');
        Route::get('/shared-with-me', 'sharedWithMe')->name('file.sharedWithMe');
        Route::get('/shared-by-me', 'sharedByMe')->name('file.sharedByMe');
        Route::get('/file/download', 'download')->name('file.download');
        Route::get('/file/download-shared-with-me', 'downloadSharedWithMe')->name('file.downloadSharedWithMe');
        Route::get('/file/download-shared-by-me', 'downloadSharedByMe')->name('file.downloadSharedByMe');

        Route::post('/files/verify-integrity', [FileController::class, 'verifyIntegrity'])
            ->name('files.verifyIntegrity');

        Route::post('/files/generate-missing-hashes', [FileController::class, 'generateMissingHashes'])
            ->name('files.generateMissingHashes');
    });
});
