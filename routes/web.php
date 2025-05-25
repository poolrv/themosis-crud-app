<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonaController;

Route::prefix('admin')->group(function () {
    Route::get('/personas', [PersonaController::class, 'index'])->name('personas.index');
    Route::get('/personas/crear', [PersonaController::class, 'create'])->name('personas.create');
    Route::post('/personas', [PersonaController::class, 'store'])->name('personas.store');
    Route::get('/personas/{id}/editar', [PersonaController::class, 'edit'])->name('personas.edit');
    Route::put('/personas/{id}', [PersonaController::class, 'update'])->name('personas.update');
    Route::delete('/personas/{id}', [PersonaController::class, 'destroy'])->name('personas.destroy');
});
