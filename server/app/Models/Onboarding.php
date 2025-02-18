<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Onboarding extends Model
{
  use HasFactory;

  protected $fillable = [
    'email',
    'address',
    'phone',
    'is_emergency',
    'property_type',
    'time',
  ];

  protected $casts = [
    'is_emergency' => 'boolean',
  ];
}
