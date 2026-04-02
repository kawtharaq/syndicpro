<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImmeubleController;
use App\Http\Controllers\AppartementController;
use App\Http\Controllers\OccupantController;
use App\Http\Controllers\ChargeController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\AnalytiqueController;
use App\Http\Controllers\SuiviPaiementController;

Route::get('/', fn() => redirect()->route('login'));

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('immeubles', ImmeubleController::class);
    Route::resource('appartements', AppartementController::class);
    Route::resource('occupants', OccupantController::class);
    Route::resource('charges', ChargeController::class);
    Route::post('charges/generer', [ChargeController::class, 'generer'])->name('charges.generer');
    Route::resource('paiements', PaiementController::class);
    Route::resource('depenses', DepenseController::class);
    Route::get('/rapports', [RapportController::class, 'index'])->name('rapports.index');
    Route::get('/rapports/pdf', [RapportController::class, 'exportPdf'])->name('rapports.pdf');
    Route::get('/analytique', [AnalytiqueController::class, 'index'])->name('analytique.index');
    Route::get('/analytique', [AnalytiqueController::class, 'index'])->name('analytique.index');
    Route::get('/suivi-paiements', [SuiviPaiementController::class, 'index'])->name('suivi.index');
    Route::post('/suivi-paiements/{charge}/payer', [SuiviPaiementController::class, 'payer'])->name('suivi.payer');
});

require __DIR__.'/auth.php';