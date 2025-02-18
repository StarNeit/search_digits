<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OnboardingController;

Route::middleware('api')->group(function () {
  Route::post('/onboarding', [OnboardingController::class, 'store']);
});