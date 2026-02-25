<?php

use App\Livewire\Admin\ApartmentGrid;
use App\Livewire\Guest\BookingForm;
use App\Models\Apartment;
use Illuminate\Support\Facades\Route;



Route::middleware([
    'auth',
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('guest.apartments');
    })->name('dashboard');
});

use App\Http\Middleware\AdminMiddleware;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;

// Auth Routes
Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Public Routes
Route::get('/', function () {
    return redirect()->route('guest.apartments');
});

Route::get('/apartments', function () {
    return view('guest.catalog', ['apartments' => Apartment::all()]);
})->name('guest.apartments');

// Admin Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', \App\Livewire\Admin\DashboardStats::class)->name('dashboard')->middleware(AdminMiddleware::class);
    Route::get('/apartments', \App\Livewire\Admin\ApartmentGrid::class)->name('apartments')->middleware(AdminMiddleware::class);
    Route::get('/guests', \App\Livewire\Admin\GuestList::class)->name('guests')->middleware(AdminMiddleware::class);
    Route::get('/checkin', \App\Livewire\Admin\CheckIn::class)->name('checkin')->middleware(AdminMiddleware::class);
    Route::get('/checkout', \App\Livewire\Admin\CheckOut::class)->name('checkout')->middleware(AdminMiddleware::class);
});

// Protected Guest Routes
Route::middleware(['auth'])->prefix('guest')->name('guest.')->group(function () {
    Route::get('/book/{apartment}', BookingForm::class)->name('book');
});

// Apartment Details (Public)
Route::get('/apartments/{apartment}', \App\Livewire\Guest\ApartmentShow::class)->name('guest.apartments.show');

// Temporary route to setup database
Route::get('/setup-db', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
        return 'Database migrated and seeded successfully! <a href="/apartments">Go to Catalog</a><br><pre>' . \Illuminate\Support\Facades\Artisan::output() . '</pre>';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage() . '<br><pre>' . $e->getTraceAsString() . '</pre>';
    }
});

// Temporary route to view logs
Route::get('/debug-logs', function () {
    $logPath = storage_path('logs/laravel.log');
    if (!file_exists($logPath)) return "No logs found.";
    
    // Read last 50 lines of log
    $lines = file($logPath);
    $lastLines = array_slice($lines, -50);
    return '<pre>' . implode("", $lastLines) . '</pre>';
});

Route::get('/secret-admin-seed', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'GuestDataSeeder', '--force' => true]);
    return 'Готово! База данных успешно заполнена тестовыми гостями. Вы можете закрыть эту страницу и обновить админку.';
});

