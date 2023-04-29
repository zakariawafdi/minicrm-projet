<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use App\Models\Campany;

class Invitation extends Model
{
    use HasFactory;
    // protected $with  = ['employee', 'company'];
    protected $fillable = ['employee_id', 'company_id', 'status'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

}
