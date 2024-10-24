<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docs;
use Illuminate\Support\Facades\Log;

class DocumentController extends Controller
{
    function get_documents()
    {
        $docs = Docs::with('type')->get();
        foreach($docs as $doc){
            $doc->file = asset('storage/' . $doc->file);
        }
        return response()->json($docs);
    }
    function find_documents(Request $request)
    {
        $search = $request->query('search', ''); 
        $documents = Docs::with('type')
            ->where('name', 'like', '%' . $search . '%')
            ->get();

        foreach ($documents as $doc) {
            $doc->file = asset('storage/' . $doc->file);
        }
        return response()->json($documents);
    }

}
