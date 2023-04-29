<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Company;


class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return response()->json(['companies' => $companies]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'capital' => 'required|numeric',
            'address' => 'required|string|max:255|unique:companies',
            'legal_status' => 'required|string|in:SARL,SA,SAS,GIE',
            'email' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        $company = Company::create($request->all());
        return response()->json(['company' => $company]);
    }

    public function show($id)
    {
        $company = Company::find($id);
        return response()->json(['company' => $company]);
    }

    public function update(Request $request, $id)
    {
        $company = Company::find($id);
        $company->update($request->all());
        return response()->json(['company' => $company]);
    }

    public function destroy($id)
    {
        $company = Company::find($id);
        $company->delete();
        return response()->json(['message' => 'Company deleted successfully']);
    }
    
    public function showByUser()
    {
        $company = Company::find(Auth::guard('employee')->user()->company_id);
        
        if(!$company) {
            return response()->json(['message' => 'No company of the user'], 400);
        }

        return response()->json(['company' => $company]);
    }

}
