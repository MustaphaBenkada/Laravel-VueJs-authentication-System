<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // public function logout(Request $request)
    // {
    //     if (Auth::check()) {
    //         $token = $request->token;
    //         $token->revoke();

    //         $success['logout'] = true;
    //         $success['message'] = 'User loged out';
    //         return response()->json(['success' => $success]);
    //     } 
    //     else{ 
    //         $success['logout'] = false;
    //         $success['message'] = 'Unauthorised';
    //         return response()->json(['success' => $success]);
    //     } 
    // }

    public function logout(Request $res)
    {
      if (Auth::user()) {
        $user = Auth::user()->token();
        $user->revoke();

        return response()->json([
          'success' => true,
          'message' => 'Logout successfully'
      ]);
      }else {
        return response()->json([
          'success' => false,
          'message' => 'Unable to Logout'
        ]);
      }
     }
    
    public function login(Request $request)
    {
        
        $credentials = [
            'email' => $request->email, 
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $success['token'] = Auth::user()->createToken('Personal Access Token')->accessToken;
            $success['name'] = Auth::user()->name;

            return response()->json(['success' => $success]);
        }

        return response()->json(['error' => 'Unauthorised'], 401);
    }

    public function register(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;

        return response()->json(['success' => $success]);
    }

    public function getDetails()
    {
        return response()->json(['success' => Auth::user()]);
    }
}