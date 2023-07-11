<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:40',
            'midname' => 'required|string|max:40',
            'surname' => 'required|string|max:40',
            'phoneNo' => 'required',
            'email' => 'required|email|unique:users,email|max:191',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required'

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 401,
                'message' => $validator->messages(),
            ]);
        } else {
            $user = User::create([
                'firstname' => $request->firstname,
                'midname' => $request->midname,
                'surname' => $request->surname,
                'phoneNo' => $request->phoneNo,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken($user->email . '_Token')->plainTextToken;
            return response()->json([
                'status' => 200,
                'token' => $token,
                'username' => $user->firstname,
                'message' => 'Registered Successfully',

            ]);
        }
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:191',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'message' => $errors
            ]);
        } else {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => "Invalid Credentials",
                ]);
            } else {
                if ($user->role_as == 1) //1 = admin
                {
                    $role = 'admin';
                    $token = $user->createToken($user->email . '_AdminToken', ['server:admin'])->plainTextToken;
                } else {
                    $role = '';
                    $token = $user->createToken($user->email . '_Token', [''])->plainTextToken;
                }
                return response()->json([
                    'status' => 200,
                    'username' => $user->firstname,
                    'token' => $token,
                    'message' => 'Logged In',
                    'role' => $role,
                ]);
            }
        }
    }
    public function logout()
    {

        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Logged Out',
        ]);
    }

    public function adminData()
    {
        $adminData = User::where('role_as', '1')->get();
        if ($adminData) {
            return response()->json([
                'status' => 200,
                'admin' => $adminData,
            ]);
        }
    }
}
