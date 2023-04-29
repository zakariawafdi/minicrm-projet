<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Invitation;
use App\Models\Employee;
use App\Models\Company;
use App\Models\History;

class InvitationController extends Controller
{
    public function index(Request $request)
    {

        $invitations = Invitation::join('companies', 'companies.id', 'invitations.company_id')
        ->join('employees', 'employees.id', 'invitations.employee_id')
        ->when($request->has('sortBy') && $request->has('sortBy'), function ($q) use ($request) {
            $field = '';
            if($request->input('sortBy') === 'company_name') {
                $field = 'companies.name';
            } else {
                $field= 'employees.name';
            }

            return $q->orderBy($field, $request->input('sortOrder'));
          })

          ->select('invitations.id as id', 'employees.name as employee', 'companies.name as company', 'invitations.status as status')
    
        ->get();
        
        return response()->json(['invitations' => $invitations]);
    }

    public function show($id)
    {
        $invitation = Invitation::find($id);
        return response()->json(['invitation' => $invitation]);
    }

    public function update(Request $request, $id)
    {
        $invitation = Invitation::find($id);
        $invitation->update($request->all());
        return response()->json(['invitation' => $invitation]);
    }

    public function destroy($id)
    {
        $invitation = Invitation::find($id);
        $employee = Employee::find($invitation->employee_id);
        $history = new History();
        $history->action = 'Admin "' .Auth::guard('admin')->user()->name.'" a annulé l\'invitation de  "'. $employee->name;
        $history->save();
        $invitation->delete();
        $employee->delete();
        return response()->json(['message' => 'Invitation deleted successfully']);
    }

    public function checkInvitation($token)
    {
        $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        $employeeId = $decoded->employee_id;
        $company_id = $decoded->company_id;
        $invitation_id = $decoded->invitation_id;

        $invitation = Invitation::findOrFail($invitation_id);

        if (!$invitation || $invitation->status === 'Confirmé') {
            return response()->json(['message' => 'Invitation non valide']);
        }
        
        $employee = Employee::find($employeeId);
        $company = Company::find($company_id);

        return response()
        ->json([
            'employee' => $employee->name,
            'company' => $company->name
        ]);

    }

}
