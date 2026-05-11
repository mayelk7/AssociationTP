<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssociationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DomaineController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Routes protégées (auth)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', \App\Http\Middleware\LocaleMiddleware::class])->group(function () {

    // HOME
    Route::get('/', function () { return view('home'); })->name('welcome');
    Route::get('/home', function () { return view('home'); })->name('home');

    // DASHBOARD
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->name('dashboard');
    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CONTACT
    Route::get('/contact', [ContactController::class, 'showForm'])->name('contact');
    Route::post('/contact', [ContactController::class, 'sendMail'])->name('contact.send');

    // API EXPLORER
    Route::get('/api-explorer', function () { return view('api_explorer'); })->name('api.explorer');

    // ASSOCIATION — lecture (tous les utilisateurs connectés)
    Route::get('/association', [AssociationController::class, 'listAsso'])->name('association');
    Route::get('/association/{id}', [AssociationController::class, 'detail'])->name('association.detail');

    // ASSOCIATION & DOMAINE — écriture (admin uniquement)
    Route::middleware(\App\Http\Middleware\IsAdmin::class)->group(function () {
        Route::get('/domaine', [DomaineController::class, 'index'])->name('domaine.index');
        Route::get('/domaine/create', [DomaineController::class, 'create'])->name('domaine.create');
        Route::post('/domaine', [DomaineController::class, 'store'])->name('domaine.store');
        Route::delete('/domaine/{id}', [DomaineController::class, 'destroy'])->name('domaine.destroy');

        Route::get('/association/create', [AssociationController::class, 'create'])->name('association.create');
        Route::post('/association', [AssociationController::class, 'store'])->name('association.store');
        Route::get('/association/{id}/edit', [AssociationController::class, 'edit'])->name('association.edit');
        Route::put('/association/{id}', [AssociationController::class, 'update'])->name('association.update');
        Route::delete('/association/{id}', [AssociationController::class, 'destroy'])->name('association.destroy');
    });

    // LANGUE
    Route::get('lang/{locale}', function ($locale) {
        if (in_array($locale, ['fr', 'en'])) {
            session(['locale' => $locale]);
        }
        return redirect()->back();
    })->name('change.lang');

});

/*
|--------------------------------------------------------------------------
| Auth (PUBLIC)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
