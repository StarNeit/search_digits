<?php

namespace App\Http\Controllers;

use App\Models\Onboarding;
use Illuminate\Http\Request;
use App\Http\Requests\OnboardingRequest;
use Exception;

class OnboardingController extends Controller
{
  public function store(OnboardingRequest $request)
  {
    try {
      $validated = $request->validated();

      $onboarding = Onboarding::updateOrCreate(
        ['email' => $validated['email']],
        $validated
      );

      return response()->json([
        'message' => 'Onboarding data saved successfully',
        'data' => $onboarding
      ], 201);
    } catch (Exception $e) {
      return response()->json([
        'message' => 'An error occurred while processing your request',
        'error' => $e->getMessage()
      ], 500);
    }
  }
}