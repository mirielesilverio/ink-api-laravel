<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Budget;
use Illuminate\Support\Facades\DB;

class BudgetController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->get('user_id')) {
            return DB::table('budgets')
            ->join('clients', 'budgets.id_client', '=', 'clients.id')
            ->where('budgets.id_user', $request->get('user_id'))
            ->select('budgets.*', 'clients.name')
            ->get();
        }
        return Budget::all();
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'amount' => 'required',
            'id_client' => 'required',
            'id_user' => 'required',
            'size' => 'required',
            'body_part' => 'required',
        ]);
        $budget = new Budget([
            'title' => $request->get('title'),
            'amount' =>  $request->get('amount'),
            'id_client' =>  $request->get('id_client'),
            'id_user' =>  $request->get('id_user'),
            'size' =>  $request->get('size'),
            'body_part' =>  $request->get('body_part'),
        ]);
        try 
        {
            $budget->save();

            return DB::table('budgets')
            ->join('clients', 'budgets.id_client', '=', 'clients.id')
            ->where('budgets.id', $budget->id)
            ->select('budgets.*', 'clients.name')
            ->get();

        } 
        catch (Exception $e) 
        {
            return Response::json(['error'=>'Erro ao salvar entidade de orçamento'], $e->getCode());
        }
    }
    public function show($id)
    {
        try
        {
            return Budget::findOrfail($id);
        }
        catch (Exception $e)
        {
            return response()->json(['erro' => 'Falha ao buscar orçamento'], 500);
        } 
    }
    public function update(Request $request, $id)
    {
        $budget = Budget::find($id);
        if ($request->get('title'))
            $budget->title = $request->get('title');
        if ($request->get('amount'))
            $budget->amount = $request->get('amount');
        if ($request->get('id_client'))
            $budget->id_client = $request->get('id_client');
        if ($request->get('id_user'))
            $budget->id_user = $request->get('id_user');
        if ($request->get('size'))
            $budget->size = $request->get('size');
        if ($request->get('body_part'))
            $budget->body_part = $request->get('body_part');

        try 
        {
            $budget->save();
            return response()->json(['orçamento' => $budget], 200);
        } 
        catch (Exception $e) 
        {
            return response()->json(['message' => 'Falha ao atualizar orçamento'], 500);
        }
    }
    public function destroy($id)
    {
        $agenda = Budget::findOrFail($id);

        try
        {
            $agenda->delete();
            return response()->json(['message' => 'Orçamento deletado com sucess'], 200);
        }
        catch (\PDOException $e)
        {
            return response()->json(['message' => 'Falha ao deletar evento'], 500);
        } 
    }
}
