<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
    $pesquisa = $request->get('pesquisa');
        $Users = User::when($request['pesquisa'],function($query) use($pesquisa) {
            $query->where('name','LIKE',"$pesquisa%")
            ->orWhere("email",'LIKE',"$pesquisa%")
            ->orWhere("password",'LIKE',"$pesquisa%");
        })->orderBy($request->column, $request->order)->paginate(intval($request->per_page));
    return response()->json($Users,200);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        return response()->json($user,200);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $user = User::find($id);
        $user = $user->update($data);
        return response()->json($user,200);
    }

    public function destroy($id)
    {
        $data = User::find($id);
        $user = $data->delete();
        return response()->json($user,200);
    }
}
