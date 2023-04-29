<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Invitation;
use App\Models\History;
use Illuminate\Support\Facades\Validator;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return response()->json(['employees' => $employees]);
    }

    public function store(Request $request)
    {
        $employee = Employee::create($request->all());
        return response()->json(['employee' => $employee]);
    }

    public function show(Request $request)
    {
        $id = auth()->user()->id;
        $employee = Employee::find($id);
        return response()->json(['employee' => $employee]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'address' => 'string|max:255',
            'phone_number' => 'string|max:20',
            'date_of_birth' => 'date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $id = auth()->user()->id;
        $employee = Employee::findOrFail($id);

        $validatedData = $validator->validated();

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $employee->update($validatedData);

        return response()->json(['employee' => $employee], 200);
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);
        $employee->delete();
        return response()->json(['message' => 'Employee deleted successfully']);
    }

    public function validateProfile(Request $request, $token)
    {

        try {

            // decoding token in invitation url and getting the user id

            // $token = '';

            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
            $employeeId = $decoded->employee_id;
            $company_id = $decoded->company_id;
            $invitation_id = $decoded->invitation_id;

            

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'phone_number' => 'required|string|max:20',
                'date_of_birth' => 'required|date',
                'password' => 'required|string|min:8',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $employee = Employee::findOrFail($employeeId);

            if (!$employee) {
                return response()->json(['error' => 'Employee not found'], 404);
            }
    
            if ($employee->completed) {
                return response()->json(['message' => 'Employee already verified']);
            }

            $validatedData = $validator->validated();

  
            $validatedData['password'] = Hash::make($validatedData['password']);
            $validatedData['company_id'] = $company_id;
            $validatedData['completed'] = true;


            $employee->update($validatedData);

            $invitation = Invitation::findOrFail($invitation_id);
            $invitation->status = 'Confirmé';
            $invitation->save();

            $token = $employee->createToken('Employee Token')->plainTextToken;

            $action = array(
                "action" => '"'.$employee->name.'" à validé l\'invitation'
            );

            $history = History::create($action);

            $action = array(
                "action" => '"'.$employee->name.'" à confirmé son profile'
            );

            $history = History::create($action);

    
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);

            // Do something with the user
        } catch (Exception $e) {
            // Invalid token
            response()->json($e->getMessage());
        }
    }
}