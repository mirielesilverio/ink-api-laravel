<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agenda;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->get('user_id')) {
            return DB::table('agendas')
            ->join('clients', 'agendas.id_client', '=', 'clients.id')
            ->where('agendas.id_user', $request->get('user_id'))
            ->select('agendas.*', 'clients.name')
            ->get();
        }
        return Agenda::all();
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'amount' => 'required',
            'id_client' => 'required',
            'id_user' => 'required',
            'date' => 'required'
        ]);
        $agenda = new Agenda([
            'title' => $request->get('title'),
            'amount' =>  $request->get('amount'),
            'id_client' =>  $request->get('id_client'),
            'id_user' =>  $request->get('id_user'),
            'date' =>  $request->get('date')
        ]);
        try 
        {
            $agenda->save();

            return DB::table('agendas')
            ->join('clients', 'agendas.id_client', '=', 'clients.id')
            ->where('agendas.id', $agenda->id)
            ->select('agendas.*', 'clients.name')
            ->get();

        } 
        catch (Exception $e) 
        {
            return Response::json(['error'=>'Erro ao salvar entidade de evento'], $e->getCode());
        }
    }
    public function show($id)
    {
        try
        {
            return Agenda::findOrfail($id);
        }
        catch (Exception $e)
        {
            return response()->json(['erro' => 'Falha ao buscar evento'], 500);
        } 
    }
    public function update(Request $request, $id)
    {
        $agenda = Agenda::find($id);
        if ($request->get('title'))
            $agenda->title = $request->get('title');
        if ($request->get('amount'))
            $agenda->amount = $request->get('amount');
        if ($request->get('id_client'))
            $agenda->id_client = $request->get('id_client');
        if ($request->get('id_user'))
            $agenda->id_user = $request->get('id_user');
        if ($request->get('date'))
            $agenda->date = $request->get('date');

        try 
        {
            $agenda->save();
            return response()->json(['agenda' => $agenda], 200);
        } 
        catch (Exception $e) 
        {
            return response()->json(['message' => 'Falha ao atualizar agenda'], 500);
        }
    }
    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);

        try
        {
            $agenda->delete();
            return response()->json(['message' => 'Evento deletado com sucess'], 200);
        }
        catch (\PDOException $e)
        {
            return response()->json(['message' => 'Falha ao deletar evento'], 500);
        } 
    }
}
