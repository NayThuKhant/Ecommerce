<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Address;
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
            'phone' => 'required|numeric|min:9',

            'address_name' => 'required|string',
            'address_phone' => 'required|numeric|min:9',
            'address' => 'required|string',
            'township' => 'required|string',
            'city' => 'required|string'
        ]);

        $request->user()->update([
            'phone' => $data['phone'],
            'more_info_needed' => false,
        ]);

        $request->user()->addresses()->save(new Address(
            [
                'full_name' => $data['address_name'],
                'address' => $data['address'],
                'phone' => $data['address_phone'],
                'township' => $data['township'],
                'city' => $data['city'],
            ]
        ));
    }
}
