<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index() {
        if (Session::has('user')) {
            return redirect()->route('dashboard');
        }

        return view('auth.index');
    }

    public function login(Request $request) {
        $validCodes = [
            '2111' => 'Admin'
        ];

        if (!array_key_exists($request->auth_code, $validCodes)) {
            return redirect()->route('index')->with('error', 'Kode salah. Silakan coba lagi!');
        }

        Session::put('user', [
            'name' => $validCodes[$request->auth_code],
            'auth_code' => $request->auth_code
        ]);

        return response()->json(['success' => true]);
    }
}
