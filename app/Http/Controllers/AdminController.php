<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Answers;
use App\Models\Accounts;
use App\Models\Docs;
use App\Models\Types;
use App\Models\Applications;

class AdminController extends Controller
{
    function add_type(Request $request)
    {
        $user = Auth::user();

        if($user->role !== 'admin'){
            return response()->json(['error' => 'Not admin'],403);
        }

        $request->validate([
            'name' => 'required|string'
        ]);

        $type = Types::create([
            'name' => $request->name
        ]);
    }

    function get_types()
    {
        $types = Types::all();

        return response()->json($types);
    }

    function add_document(Request $request)
    {
        $user = Auth::user();

        if($user->role !== 'admin'){
            return response()->json(['error' => 'Not admin'],403);
        }

        $request->validate([
            'name' => 'required|string',
            'type_id' => 'required|integer',
            'file' => 'required|file|mimes:pdf,doc,docx,txt|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
    
            $filename = time() . '_' . $file->getClientOriginalName();
    
            $path = $file->storeAs('documents', $filename, 'public');
            
            $document = Docs::create([
                'name' => $request->name,
                'type_id' => $request->type_id,
                'file' => $path,
            ]);

            return response()->json([
                'message' => 'File uploaded successfully',
                'path' => $path
            ], 200);
        }
    
        return response()->json(['error' => 'File not found'], 400);
    }

    function add_accounting(Request $request)
    {
        $user = Auth::user();

        if($user->role !== 'admin'){
            return response()->json(['error' => 'Not admin'],403);
        }

        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'user_id' => 'required|integer',
        ]);

        $accounting = Accounts::create([
            'name' => $request->name,
            'price' => $request->price,
            'user_id' => $request->user_id,
            'date' => now(),
            'status' => 'waiting'
        ]);
    }

    function add_answer(Request $request)
    {
        $user = Auth::user();

        if($user->role !== 'admin'){
            return response()->json(['error' => 'Not admin'],403);
        }

        $request->validate([
            'text' => 'required|string|max:255',
            'application_id' => 'required|integer',
        ]);

        $answer = Answers::create([
            'text' => $request->text,
            'application_id' => $request->application_id,
            'user_id' => $user->id
        ]);

        $application = Applications::where('id', $request->application_id)->first();
        $application->status = 'answered';
        $application->save();
    }

    function get_users()
    {
        $user = Auth::user();

        if($user->role !== 'admin'){
            return response()->json(['error' => 'Not admin'],403);
        }

        $users = User::all();

        return response()->json(['users' => $users]);
    }
}
