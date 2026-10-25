<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DropdownOptionController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SidebarMenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Real Estate Website (Profile & Offers)
|--------------------------------------------------------------------------
*/
Route::get('/', [WebsiteController::class, 'home'])->name('website.home');
Route::get('/offers', [WebsiteController::class, 'offers'])->name('website.offers');
Route::get('/offers/{slug}', [WebsiteController::class, 'offerShow'])->name('website.offers.show');
Route::get('/contact', [WebsiteController::class, 'contact'])->name('website.contact');
Route::post('/inquiry', [WebsiteController::class, 'storeInquiry'])->name('website.inquiry.store');

Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['ar', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/locale/{locale}', function (string $locale) {
    if (in_array($locale, ['ar', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('locale.switch');

/*
|--------------------------------------------------------------------------
| Authentication (No public registration - Only Admin adds staff)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// OTP Login & Password Recovery
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('password.email');
Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('auth.otp.verify');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('auth.otp.verify.post');
Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('auth.otp.resend');

/*
|--------------------------------------------------------------------------
| Protected CRM Portal
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Dashboard & Profile
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.view');
    Route::get('/profile', [UserController::class, 'profile'])->name('admin.profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('admin.profile.update');

    // Property Offers (Marketing Team & Admin)
    Route::middleware(['permission:offers.view'])->group(function () {
        Route::get('/offers', [OfferController::class, 'index'])->name('admin.offers.index');
        Route::get('/offers/create', [OfferController::class, 'create'])->name('admin.offers.create')->middleware('permission:offers.create');
        Route::post('/offers', [OfferController::class, 'store'])->name('admin.offers.store')->middleware('permission:offers.create');
        Route::get('/offers/{offer}', [OfferController::class, 'show'])->name('admin.offers.show');
        Route::get('/offers/{offer}/edit', [OfferController::class, 'edit'])->name('admin.offers.edit')->middleware('permission:offers.edit');
        Route::put('/offers/{offer}', [OfferController::class, 'update'])->name('admin.offers.update')->middleware('permission:offers.edit');
        Route::delete('/offers/{offer}', [OfferController::class, 'destroy'])->name('admin.offers.destroy')->middleware('permission:offers.delete');
    });

    // Customer Service & Leads (Customer Service & Admin)
    Route::middleware(['permission:leads.view'])->group(function () {
        Route::get('/leads', [LeadController::class, 'index'])->name('admin.leads.index');
        Route::get('/leads/buyers', fn() => redirect()->route('admin.leads.index', ['type' => 'buyer']))->name('admin.leads.buyers');
        Route::get('/leads/owners', fn() => redirect()->route('admin.leads.index', ['type' => 'owner']))->name('admin.leads.owners');
        Route::put('/leads/{lead}/status', [LeadController::class, 'updateStatus'])->name('admin.leads.update-status')->middleware('permission:leads.update_status');
        Route::delete('/leads/{lead}', [LeadController::class, 'destroy'])->name('admin.leads.destroy')->middleware('permission:leads.update_status');
    });

    // Staff & Users Management (Admin)
    Route::middleware(['permission:users.view'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create')->middleware('permission:users.create');
        Route::post('/users', [UserController::class, 'store'])->name('admin.users.store')->middleware('permission:users.create');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit')->middleware('permission:users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update')->middleware('permission:users.edit');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy')->middleware('permission:users.delete');
    });

    // Roles & Permissions (Admin)
    Route::middleware(['permission:roles.view'])->group(function () {
        Route::get('/roles', [RoleController::class, 'index'])->name('admin.roles.index');
        Route::get('/roles/create', [RoleController::class, 'create'])->name('admin.roles.create')->middleware('permission:roles.create');
        Route::post('/roles', [RoleController::class, 'store'])->name('admin.roles.store')->middleware('permission:roles.create');
        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('admin.roles.edit')->middleware('permission:roles.edit');
        Route::put('/roles/{role}', [RoleController::class, 'update'])->name('admin.roles.update')->middleware('permission:roles.edit');
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('admin.roles.destroy')->middleware('permission:roles.delete');
    });

    // Dynamic Navigation Menus & System Settings
    Route::middleware(['permission:sidebar.manage'])->group(function () {
        Route::get('/menus', [SidebarMenuController::class, 'index'])->name('admin.menus.index');
        Route::post('/menus/{menu}/toggle', [SidebarMenuController::class, 'toggleMenu'])->name('admin.menus.toggle');
        Route::post('/submenus/{subMenu}/toggle', [SidebarMenuController::class, 'toggleSubMenu'])->name('admin.submenus.toggle');
        Route::post('/menus/order', [SidebarMenuController::class, 'updateMenuOrder'])->name('admin.menus.order');

        // Dynamic Dropdown Options Management
        Route::get('/dropdown-options', [DropdownOptionController::class, 'index'])->name('admin.dropdown-options.index');
        Route::post('/dropdown-options', [DropdownOptionController::class, 'store'])->name('admin.dropdown-options.store');
        Route::put('/dropdown-options/{dropdownOption}', [DropdownOptionController::class, 'update'])->name('admin.dropdown-options.update');
        Route::post('/dropdown-options/{dropdownOption}/toggle', [DropdownOptionController::class, 'toggle'])->name('admin.dropdown-options.toggle');
        Route::delete('/dropdown-options/{dropdownOption}', [DropdownOptionController::class, 'destroy'])->name('admin.dropdown-options.destroy');
    });
});
