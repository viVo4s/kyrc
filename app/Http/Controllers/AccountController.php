<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use Illuminate\Support\Facades\Auth;


class AccountController extends Controller
{
    function get_accountings()
    {
        $user = Auth::user();

        $accountings = Accounts::with('user')->where('user_id', $user->id)->get();

        return response()->json($accountings);
    }

    function get_one_accounting($id)
    {
        $user = Auth::user();

        $accountings = Accounts::with('user')->where('user_id', $user->id)->where('id', $id)->first();

        return response()->json($accountings);
    }

    function change_status($id)
    {
        $user = Auth::user();

        $accountings = Accounts::where('user_id', $user->id)->where('id', $id)->first();

        $accountings->status = 'paid';
        $accountings->save();

        return response()->json(['message' => 'оплачено'], 201);
    }
}
