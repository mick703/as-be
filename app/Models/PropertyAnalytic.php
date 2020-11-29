<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyAnalytic extends Model
{
    use HasFactory;

    protected $fillable = ['analytic_type_id', 'property_id', 'value'];
}
