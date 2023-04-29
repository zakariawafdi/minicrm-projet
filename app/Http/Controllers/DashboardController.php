<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Admin;
use App\Models\Invitation;

class DashboardController extends Controller
{

    public function index()
    {
        $dashboard['companies'] = Company::count();
        $dashboard['invitations'] = Invitation::count();
        $dashboard['employees'] = Employee::count();
        $dashboard['admins'] = Admin::count();
        return response()->json($dashboard);
    }

    
}
