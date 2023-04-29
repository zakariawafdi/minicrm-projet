<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class History extends Model
{
    use HasFactory;
    protected $fillable = ['action'];
}
