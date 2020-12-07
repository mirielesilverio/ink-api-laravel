<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ]);
        try 
        {
            $user->save();
            return $user;
        } 
        catch (Exception $e) 
        {
            return Response::json(['error'=>'Erro ao salvar entidade de cliente'], $e->getCode());
        }
    }
    public function show($id)
    {
        return User::findOrfail($id);
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrfail($id);
        if ($request->get('name'))
            $user->name = $request->get('name');
        if ($request->get('email'))
            $user->email = $request->get('email');
        if ($request->get('password'))
            $user->password =  $request->get('password');

        try 
        {
            $user->save();
            return $user;
        } 
        catch (Exception $e) 
        {
            return Response::json(['error'=>'Erro ao atualizar entidade de cliente'], $e->getCode());
        }
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        try
        {
            $user->delete();
            return Response::json(['success'=>'Entidade de cliente deletada com sucesso'], '200');
        }
        catch (\PDOException $e)
        {
            return redirect()->route('noticia.index')->with('error', $e->getCode());
        } 
    }
}
