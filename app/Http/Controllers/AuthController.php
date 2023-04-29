<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Admin;
use App\Models\Employee;

class AuthController extends Controller
{
    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        $admin = Admin::where('email', $request->email)->first();

    
        if ($admin && Hash::check($request->password, $admin->password)) {
            
            $token = $admin->createToken('Admin Token')->plainTextToken;
    
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);

        } else {
           return response()->json([
             'message' => 'The provided credentials are incorrect.'
           ],422);
        }
    
    }

    public function employeeLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $employee = Employee::where('email', $request->email)->first();
    
        if ($employee && Hash::check($request->password, $employee->password)) {
            
            $token = $employee->createToken('Admin Token')->plainTextToken;
    
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);

        } else {
           return response()->json([
             'message' => 'The provided credentials are incorrect.'
           ],422);
        }
    }
}
