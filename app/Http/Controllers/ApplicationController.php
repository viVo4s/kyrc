<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Applications;
use App\Models\Answers;

class ApplicationController extends Controller
{

    function get_application()
    {
        $applications = Applications::all();

        return response()->json($applications);
    }

    function add_application(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string',
            'desc' => 'required|string',
            'type_id' => 'required|integer',
        ]);

        $application = Applications::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'type_id' => $request->type_id,
            'user_id' => $user->id,
            'status' => 'waiting',
            'date' => now(),
        ]);

        return response()->json(['success' => 'application created'],200);
    }

    function find_application(Request $request)
    {
        $search = $request->query('search', ''); 

        $applications = Applications::with(['user', 'type'])
            ->where('name', 'like', '%' . $search . '%')
            ->get();

        return response()->json($applications);
    }

    function get_answer($id)
    {
        $answer = Answers::with(['user'])->where('application_id', $id)->first();

        return response()->json($answer);
    }

    function get_one_application($id){
        $application = Applications::with(['user', 'type'])->where('id', $id)->first();

        return response()->json($application);
    }
}
