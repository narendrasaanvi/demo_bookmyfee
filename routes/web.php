<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminPlayerController;
use App\Http\Controllers\Admin\AdminTournamentController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Admin\ContactFromController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PlayerController;
use App\Http\Controllers\Frontend\TournamentListController;
use App\Http\Controllers\Frontend\BookingTournamentController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminSubscriberController;
use App\Http\Controllers\Admin\AdminPaymentHistoryController;
use App\Http\Controllers\Admin\AdminTypeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\SendOTPController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentReceiptController;
use App\Http\Controllers\InvoiceController;



// Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/', [TournamentListController::class, 'index'])->name('home');
Route::get('/about-us', [HomeController::class, 'about'])->name('frontend.about');
Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.form'); // To display the form
Route::post('/contact', [ContactController::class, 'submitForm'])->name('contact.submit'); // To handle form submission
Route::view('/return-policy', 'frontend.static_pages.refund_policy');
Route::view('/privacy-policy', 'frontend.static_pages.privacy_policy');
Route::view('/term-condition', 'frontend.static_pages.term_condition');

Route::post('/send-otp', [SendOTPController::class, 'sendOtp']);
Route::post('/verify-otp', [SendOTPController::class, 'verifyOtp']);
// tournaments
Route::get('/tournaments', [TournamentListController::class, 'index'])->name('tournament.list');
Route::get('/tournament/{slug}', [TournamentListController::class, 'showTournamentDetails'])->name('tournament.details');




// Profile
Route::middleware(['auth', 'verified'])->group(function () {
Route::get('/tournament-create', [TournamentListController::class, 'createTournament'])->name('tournament.organizer.submit');
Route::post('/tournament-create', [TournamentListController::class, 'storeTournament'])->name('tournament.organizer.store');
Route::get('/tournament-view', [TournamentListController::class, 'viewTournament'])->name('tournament.organizer.view');
Route::get('players-list/{tournament_id}', [TournamentListController::class, 'PlayersList'])->name('players.list');
Route::get('/player-registration', [PlayerController::class, 'index'])->name('player.registration.index');
Route::post('/player-registration', [PlayerController::class, 'store'])->name('player.registration.store');
Route::get('/player-registration/view', [PlayerController::class, 'view'])->name('player.registration.view');
Route::get('/player-registration/destroy/{id}', [PlayerController::class, 'destroy'])->name('player.registration.destroy');
Route::get('/player-registration/edit/{id}', [PlayerController::class, 'edit'])->name('player.registration.edit');
Route::post('/player-registration/edit/{id}', [PlayerController::class, 'update'])->name('player.registration.update');
Route::get('booking-tournament/{slug}', [BookingTournamentController::class, 'index'])->name('book.index');
Route::post('/tournament/register', [BookingTournamentController::class, 'registerPlayers'])->name('save.tournament.registration');
Route::get('thanks/{orderId}', [BookingTournamentController::class, 'thanks'])->name('thanks');
Route::get('/payment-now/{orderId}', [PaymentController::class, 'index'])->name('payment.index');
Route::post('/payment-now', [PaymentController::class, 'store'])->name('payment-store');

Route::get('/payment-receipt/{orderId}', [PaymentReceiptController::class, 'index'])->name('payment.receipt');

Route::get('/invoice', [InvoiceController::class, 'index'])->name('payment.receipt');
Route::post('/invoice/{orderId}', [InvoiceController::class, 'view'])->name('payment.receipt');


});

Route::middleware(['auth', 'verified'])->prefix('/user')->group(function () {
    Route::get('profile', [UserProfileController::class, 'showProfile'])->name('dashboard');
    Route::get('profile', [UserProfileController::class, 'showProfile'])->name('profile.show');
    Route::post('profile.update', [UserProfileController::class, 'updateProfile'])->name('user.profile.update');
    Route::post('profile.change-password', [UserProfileController::class, 'changePassword'])->name('user.profile.change-password');
});


//ADMIN PANEL
Route::middleware(['Admin', 'auth', 'verified'])->prefix('/admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.index');
    Route::get('change-password', [ChangePasswordController::class, 'index'])->name('admin.change-password');
    Route::get('profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('tournament', AdminTournamentController::class);
    Route::resource('category', AdminCategoryController::class);
    Route::resource('type', AdminTypeController::class);
    Route::resource('enquiry-list', ContactFromController::class);
    Route::resource('users', AdminUserController::class);
    Route::resource('subscriber', AdminSubscriberController::class);
    Route::get('register-players-list/{tournament_id}', [AdminTournamentController::class, 'registerPlayersList'])->name('register.players.player.list');
    Route::get('export-player-list/{id}', [ExportController::class, 'export'])->name('export-player-list');
    Route::get('players', [AdminPlayerController::class, 'index'])->name('admin.player.list');
    Route::get('payment-history', [AdminPaymentHistoryController::class, 'index'])->name('admin.payment.list');

});




// Route to clear route cache
Route::get('/clear-routes', function () {
    Artisan::call('route:clear');
    return response()->json(['message' => 'Route cache cleared successfully']);
});

// Route to clear cookies
Route::get('/clear-config', function () {
    Artisan::call('config:clear');
    return response()->json(['message' => 'Configuration cache cleared successfully']);
});

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return response()->json(['message' => 'Application cache cleared successfully']);
});

Route::get('/clear-view', function () {
    Artisan::call('view:clear');
    return response()->json(['message' => 'View cache cleared successfully']);
});

Route::get('/clear-route', function () {
    Artisan::call('route:clear');
    return response()->json(['message' => 'Route cache cleared successfully']);
});

Route::get('/clear-cache',function(){
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return response()->json(['message' => 'Route cache cleared successfully']);
});

require __DIR__ . '/auth.php';
