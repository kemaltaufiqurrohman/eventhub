<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PanitiaController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard default Breeze
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Profile (semua role)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');

    Route::patch('/admin/events/{event}/status', [EventController::class, 'updateStatus'])
        ->name('admin.events.updateStatus');

    Route::get('/admin/events/{event}', [EventController::class, 'adminShow'])
        ->name('admin.events.show');

    Route::post('/admin/set-status', [AdminController::class, 'setStatus'])
        ->name('admin.event.setStatus');

    Route::get('/admin/events', [EventController::class, 'adminIndex'])
        ->name('admin.events.index');
});

/*
|--------------------------------------------------------------------------
| PANITIA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:panitia'])->group(function () {

    Route::get('/panitia/dashboard', [PanitiaController::class, 'index'])
        ->name('panitia.dashboard');

    // Event CRUD
    Route::get('/panitia/events', [EventController::class, 'index'])->name('panitia.events.index');
    Route::get('/panitia/events/create', [EventController::class, 'create'])->name('panitia.events.create');
    Route::post('/panitia/events', [EventController::class, 'store'])->name('panitia.events.store');
    Route::get('/panitia/events/{event}', [EventController::class, 'show'])->name('panitia.events.show');
    Route::get('/panitia/events/{event}/edit', [EventController::class, 'edit'])->name('panitia.events.edit');
    Route::put('/panitia/events/{event}', [EventController::class, 'update'])->name('panitia.events.update');
    Route::delete('/panitia/events/{event}', [EventController::class, 'destroy'])->name('panitia.events.destroy');

    // QR Absensi
    Route::get('/panitia/events/{event}/qr', [EventController::class, 'qrPage'])->name('panitia.events.qr');

    // Sertifikat
    Route::get('/panitia/events/{event}/manage-template', [EventController::class, 'manageTemplate'])->name('panitia.events.manageTemplate');
    Route::post('/panitia/events/{event}/generate-certificates', [EventController::class, 'generateCertificates'])->name('panitia.events.generateCertificates');
    Route::get('/panitia/events/{event}/preview-certificate', [EventController::class, 'previewCertificate'])->name('panitia.events.previewCertificate');
    Route::post('/panitia/events/{event}/upload-template', [EventController::class, 'uploadCertificateTemplate'])->name('panitia.events.uploadTemplate');
    Route::post('/panitia/events/{event}/save-template-settings', [EventController::class, 'saveTemplateSettings'])->name('panitia.events.saveTemplateSettings');
    Route::post('/panitia/events/{event}/save-text-settings', [EventController::class, 'saveTextSettings'])->name('panitia.events.saveTextSettings');

    //participant
    Route::get('/panitia/events/{event}/participants', [EventController::class, 'participants'])
        ->name('panitia.events.participants');

    Route::post('/panitia/absen/{reg}', [EventController::class, 'markAttendance'])
        ->name('panitia.absen.manual');

});


/*
|--------------------------------------------------------------------------
| MAHASISWA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {

    Route::get('/mahasiswa/dashboard', [MahasiswaController::class, 'index'])
        ->name('mahasiswa.dashboard');

    // Event list
    Route::get('/mahasiswa/events', [MahasiswaController::class, 'events'])
        ->name('mahasiswa.events.index');

    // Detail event mahasiswa
    Route::get('/mahasiswa/events/{id}', [MahasiswaController::class, 'show'])
        ->name('mahasiswa.events.show');

    // Mendaftar event
    Route::post('/events/{event}/register', [EventController::class, 'register'])
        ->name('events.register');

    // Halaman kamera scan QR
    Route::get('/mahasiswa/scan-qr', [MahasiswaController::class, 'scanQr'])
        ->name('mahasiswa.qr.scan');

    Route::post('/mahasiswa/scan-qr/submit', [MahasiswaController::class, 'submitScan'])
        ->name('mahasiswa.qr.direct');


    Route::get('/events/{id}/certificate', [EventController::class, 'downloadCertificate'])
        ->name('events.downloadCertificate');


    
    
});

require __DIR__.'/auth.php';
