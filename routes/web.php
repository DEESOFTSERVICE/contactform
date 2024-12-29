<?php

use Deepak\Contactform\Http\Controllers\ContactFormController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest', 'web'])->group(function () {
    Route::get('/contacts/', [ContactFormController::class, 'create']);
    Route::post('/contacts/submit', [ContactFormController::class, 'save']);
});
