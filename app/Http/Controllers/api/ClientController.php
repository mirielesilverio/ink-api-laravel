<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clients;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        if ($request->get('user_id')) 
            return DB::table('clients')->where('id_user', $request->get('user_id'))->get();
        return Clients::all();
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'telephone' => 'required',
            'id_user' => 'required'
        ]);
        $client = new Clients([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'telephone' => $request->get('telephone'),
            'id_user' => $request->get('id_user')
        ]);
        try 
        {
            $client->save();
            return $client;
        } 
        catch (Exception $e) 
        {
            return Response::json(['error'=>'Erro ao salvar entidade de cliente'], $e->getCode());
        }
    }
    public function show($id)
    {
        try
        {
            return Clients::findOrfail($id);
        }
        catch (Exception $e)
        {
            return Response::json(['error'=>'Erro ao consultar entidade de cliente'], $e->getCode());
        } 
    }
    public function update(Request $request, $id)
    {
        $client = Clients::find($id);
        if ($request->get('name'))
            $client->name = $request->get('name');
        if ($request->get('email'))
            $client->email = $request->get('email');
        if ($request->get('telephone'))
            $client->telephone = $request->get('telephone');
        if ($request->get('id_user'))
            $client->id_user = $request->get('id_user');

        try 
        {
            $client->save();
            return response()->json(['client' => $client], 200);
        } 
        catch (Exception $e) 
        {
            return response()->json(['message' => 'Falha ao atualizar cliente'], 500);
        }
    }
    public function destroy($id)
    {
        $client = Clients::findOrFail($id);

        try
        {
            $client->delete();
            return response()->json(['message' => 'Cliente deletado com sucess'], 200);
        }
        catch (\PDOException $e)
        {
            return response()->json(['message' => $e], 500);
        } 
    }
}
