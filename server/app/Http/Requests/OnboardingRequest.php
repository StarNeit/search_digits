<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OnboardingRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'email' => ['required', 'string', 'email', 'max:255'],
      'address' => ['required', 'string', 'max:255'],
      'phone' => ['nullable', 'string', 'max:20'],
      'is_emergency' => ['boolean'],
      'property_type' => ['required', 'string', Rule::in(['residential_house', 'commercial_shop', 'office_building', 'industrial_warehouse'])],
      'time' => ['required', 'string', Rule::in(['morning', 'afternoon', 'evening', 'anytime'])],
    ];
  }

  public function messages(): array
  {
    return [
      'email.required' => 'The email field is required.',
      'email.email' => 'The email must be a valid email address.',
      'address.required' => 'The address field is required.',
      'address.max' => 'The address must not exceed 255 characters.',
      'phone.max' => 'The phone number must not exceed 20 characters.',
      'is_emergency.boolean' => 'The is_emergency field must be true or false.',
      'property_type.required' => 'The property type field is required.',
      'property_type.in' => 'The selected property type is invalid. Please choose from: residential house, commercial shop, office building, or industrial warehouse.',
      'time.required' => 'The time field is required.',
      'time.in' => 'The selected time is invalid. Please choose from: morning, afternoon, evening, or anytime.',
    ];
  }
}

