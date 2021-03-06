<?php

namespace App\Http\Requests;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class loginRequest extends FormRequest
{
    public function authorize(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->password,$user->password)) {
            throw ValidationException::withMessages([
                'email' => ['the provided credential are incorret']
            ]);
        }
    }

    public function rules()
    {
        return [
            'email'  => 'required',
            'password'  => 'required|min:8',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Campo E-mail é requirido' ,
            'password.required' => 'Campo senha é requirido',
            'password.min' => 'Campo senha é no mínimo 8 caracteres' 
        ];
    }
}
