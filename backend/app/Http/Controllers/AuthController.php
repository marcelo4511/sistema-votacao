<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function user(Request $request) 
    {
        return $request->user();
    }
    public function login(Request $request)
    {
        $regras = [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];
        $mensagens = [ 
            'password.min' => 'É necessário no mínimo 8 caracteres no campo senha.',
            'required' => 'O atributo :attribute não pode estar em branco.', 
            'email.required' => 'Digite um endereço de email.',
            'email.email' => 'Digite um endereço de email válido'
        ];
        $request->validate($regras, $mensagens);

        $user = User::where('email',$request->email)->first();

        if(!$user || !Hash::check($request->password,$user->password)) {
            throw ValidationException::withMessages([
                'email' => ['as credenciais fornecidas são incorretas']
            ]);
        }
        return response()->json($user->createToken('Auth Token')->accessToken);
    }

    public function register(Request $request)
    {
        $rules = [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', "min:8",'confirmed'],
            'password_confirmation' => ['required']
        ];
        
        $mensagens = [ 
            'password.min' => 'É necessário no mínimo 8 caracteres no campo senha.',
            'password.confirmed' => 'Preencha a sua senha para confirmação.',
            'required' => 'O atributo :attribute não pode estar em branco.', 
            'email.required' => 'Digite um endereço de email.',
            'email.email' => 'Digite um endereço de email válido',
            'email.unique' => 'Endereço de E-mail já cadastrado!',
        ];

        $request->validate($rules, $mensagens);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json($request,200);
    }
}
