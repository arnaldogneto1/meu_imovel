<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\RealStateRequest;
use App\Models\RealState;

class RealStateController extends Controller
{
    private $realState;

    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }

    public function index()
    {
        $realState = $this->realState->paginate('10');
        return response()->json($realState, 200);
    }

    public function store(RealStateRequest $request)
    {
        $data = $request->all();

        try {
            $realSate = $this->realState->create($data);

            return response()->json(['data' => ['msg' => 'Imóvel cadastrado com sucesso!']], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function show($id)
    {
        try {
            $realSate = $this->realState->findOrFail($id);

            return response()->json(['data' => $realSate], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function update($id, RealStateRequest $request)
    {
        $data = $request->all();

        try {
            $realSate = $this->realState->findOrFail($id);
            $realSate->update($data);

            return response()->json(['data' => ['msg' => 'Imóvel atualizado com sucesso!']], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function destroy($id)
    {
        try {
            $realSate = $this->realState->findOrFail($id);
            $realSate->delete();

            return response()->json(['data' => ['msg' => 'Imóvel removido com sucesso!']], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
