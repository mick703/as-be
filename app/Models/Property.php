<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUUID;

class Property extends Model
{
    use HasFactory, HasUUID;

    protected $uuidFieldName = 'guid';

}
