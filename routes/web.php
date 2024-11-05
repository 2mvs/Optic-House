<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\category\CategoryConctroller;
use App\Http\Controllers\opticient\OpticienController;
use App\Http\Controllers\prescription\PrescriptionController;
use App\Http\Controllers\produit\ProduitConctroller;
use App\Http\Controllers\vente\VenteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\client\ClientController;
use App\Http\Controllers\fournisseur\FournisseurController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('app');
// });


// Route::resource('client', ClientController::class);
// Route::resource('fournisseur', FournisseurController::class);
// Route::resource('category', CategoryConctroller::class);
// Route::resource('product', ProduitConctroller::class);
//Route::resource('opticien', OpticienController::class);

Route::get('opticien', [OpticienController::class, 'index'])->name('opticien.index');
Route::post('opticien', [OpticienController::class, 'store'])->name('opticien.store');
Route::delete('opticien{{opticien}', [OpticienController::class, 'destroy'])->name('opticien.destroy');
//Route::get('opticien', [OpticienController::class])->name('');



Route::resource('vente', VenteController::class);
Route::get('/get-produit-prix/{id}', [VenteController::class, 'getProduitPrix']);

Route::get('login', [OpticienController::class, 'loginForm'])->name('opticien.login');
Route::get('register/opticien', [OpticienController::class, 'registerForm'])->name('opticien.register');
Route::post('login', [OpticienController::class, 'authOpticien'])->name('auth.opticien');
Route::post('logout/opticien', [OpticienController::class, 'logoutOpticient'])->name('opticien.logout');

Route::middleware('auth:opticien')->group(function () {
    Route::get('/dashboard/opticien', [OpticienController::class, 'dashboardOpticien'])->name('opticien.dashboard');
    Route::get('opticien/{opticien}/edit', [OpticienController::class, 'edit'])->name('opticien.edit');
    Route::put('opticien/{opticien}', [OpticienController::class, 'update'])->name('opticien.update');
    Route::resource('prescription', PrescriptionController::class);
    Route::get('/prescription/{id}/download', [PrescriptionController::class, 'downloadPDF'])->name('prescription.download');
    Route::get('compte/opticien', [OpticienController::class, 'accountOpticien'])->name('compte.opticien');
});

Route::get('/redirect', function () {
    return view('500');
})->name('default');

/**Authenticate Admin */

Route::get('/', [AdminController::class, 'adminLogin'])->name('admin.login');
Route::post('admin/login', [AdminController::class, 'authAdmin'])->name('auth.admin');
Route::get('admin/register', [AdminController::class, 'adminRegister'])->name('admin.register');
Route::post('admin/register', [AdminController::class, 'store'])->name('admin.store');
Route::post('admin/logout', [AdminController::class, 'logoutAdmin'])->name('admin.logout');


Route::middleware('auth:admin')->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('client', ClientController::class);
    Route::resource('fournisseur', FournisseurController::class);
    Route::resource('category', CategoryConctroller::class);
    Route::resource('product', ProduitConctroller::class);
    //route de l'opticien pour l'admin
    Route::get('opticien', [OpticienController::class, 'index'])->name('opticien.index');
    Route::get('vente/{id}/facture', [VenteController::class, 'facture'])->name('vente.facture');

    Route::get('/opticiens/download-pdf', [OpticienController::class, 'downloadPdf'])->name('opticien.downloadPdf');


});



