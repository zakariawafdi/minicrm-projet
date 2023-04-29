<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class Company extends Model
{
    use HasFactory;
    protected $appends = ['employee_count'];
    protected $with = ['employees'];
    protected $fillable = ['name', 'legal_status', 'address', 'capital', 'phone_number', 'email'];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function getEmployeeCountAttribute()
    {
        return $this->employees()->count();
    }
}
