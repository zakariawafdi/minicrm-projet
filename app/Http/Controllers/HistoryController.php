<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\History;


class HistoryController extends Controller
{
    public function index()
    {
        $histories = History::all();
        return response()->json(['histories' => $histories]);
    }
}
