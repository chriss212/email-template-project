<?php

use App\Http\Controllers\EmailPreviewController;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Route;

Route::get('api/v1/email/preview', EmailPreviewController::class);

