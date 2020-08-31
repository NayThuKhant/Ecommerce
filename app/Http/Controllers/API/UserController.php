<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUser()
    {
        if (Auth::check()) {
            return Auth::user();
        }
        return null;
    }
    public function updateInfo(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|numeric|min:9'
        ]);
        $data['more_info_needed'] = false;
        $request->user()->update($data);
    }
}
