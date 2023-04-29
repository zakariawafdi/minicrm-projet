<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Employee;
use App\Models\Invitation;
use App\Models\Company;
use App\Models\History;
use Firebase\JWT\JWT;
use App\Services\EmailService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        return response()->json(['admins' => $admins]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $admin = new Admin();
        $admin->name = $validator->validated()['name'];
        $admin->email = $validator->validated()['email'];
        $admin->password = Hash::make($validator->validated()['password']);
        $admin->save();

        return response()->json(['admin' => $admin]);
    }

    public function show($id)
    {
        $admin = Admin::find($id);
        return response()->json(['admin' => $admin]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $admin = Admin::find($id);
        $admin->name = $validator->validated()['name'];
        $admin->email = $validator->validated()['email'];
        if(isset($validator->validated()['password'])) $admin->password = Hash::make($validator->validated()['password']);
        
        $admin->save();
        return response()->json(['admin' => $admin]);
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);
        $admin->delete();
        return response()->json(['message' => 'Admin deleted successfully']);
    }

    public function inviteEmployee(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:employees',
            'company_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $employee = new Employee();

        $employee->name = $validator->validated()['name'];
        $employee->email = $validator->validated()['email'];
        $employee->save();

        $invitation = new Invitation();

        $invitation->employee_id = $employee->id;
        $invitation->company_id = $validator->validated()['company_id'];
        $invitation->save();


        $payload = [
            'employee_id' => $employee->id,
            'company_id' => $validator->validated()['company_id'],
            'invitation_id' => $invitation->id,
            "exp" => time() + (7 * 24 * 60 * 60)
        ];

        $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');
           
        $url = url('/employee/validate/' . $token);
        error_log("invite url".$url);

        $company = Company::find($validator->validated()['company_id']);

        $history = new History();
        
        $history->action = 'Admin "' .Auth::guard('admin')->user()->name.'" a invite l\'employé "'. $employee->name.'" à joindre la société "'. $company->name .'"';

        $history->save();

        EmailService::sendValidateProfileEmail($employee, $url);

        return response()->json(['message' => 'Employee invited successfully']);
    }
}