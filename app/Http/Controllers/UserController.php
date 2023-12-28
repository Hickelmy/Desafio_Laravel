<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function createUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Erro de validacao',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User criado com sucesso',
                'token' => $user->createToken('API TOKEN')->plainTextToken,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }



    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                // 'name'=> 'required',
                'email' => 'required|email',
                'password' => 'required'
            ]);


            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Erro na validação',
                    'errors' => $validateUser->errors()

                    
                ], 401);
            }

            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Senha diferentes',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status'=> true,
                'message'=> 'User logado com sucesso',
                'token'=> $user->createToken('API TOKEN')->plainTextToken,
            ],200 );

        } catch (\Throwable $th) {
           return response()->json([
            'status'=> false,
            'message'=> $th->getMessage(),
            ], 500);
        }
    }


}
