<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller {

    protected $marca;

    public function __construct(Marca $marca) {
        $this->marca = $marca;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $marcas = $this->marca->all();
        return response()->json($marcas, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $request->validate($this->marca->rules(), $this->marca->feedback());
        
        $marca = $this->marca->create($request->all());
        return response()->json($marca, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show(int $id) {
        $marca = $this->marca->find($id);
        
        if ($marca === null) {
            return response()->json(['msg' => 'Recurso solicitado não existe'], 404);
        } else {
            return response()->json($marca, 200);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id) {
        // Request = Dados atualizados -> Vindo da requisição
        // marca = Dado recuperado automaticamente do banco pelo Laravel
        
        $marca = $this->marca->find($id);
        
        if ($marca === null) {
            return response()->json(['msg' => 'Impossivel realizar a atualização, o recurso solicitado não existe'], 404);
        } else {

            if ($request->method() == 'PATCH') {
                
                $regrasDinamicas = array();

                foreach ($marca->rules() as $input => $regra) {
                    if (array_key_exists($input, $request->all())) {
                        $regrasDinamicas[$input] = $regra;
                    }
                }

                $request->validate($regrasDinamicas, $this->marca->feedback());
                $marca->update($request->all());
                return response()->json($marca, 200);
            } else {
                $request->validate($this->marca->rules(), $this->marca->feedback());
                $marca->update($request->all());
                return response()->json($marca, 200);
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id) {
        $marca = $this->marca->find($id);

        if ($marca === null) {
            return response()->json(['msg' => 'Impossivel realizar a remoção, o recurso solicitado não existe'], 404);
        } else {
            $marca->delete();
            return response()->json(['msg' => 'A marca foi removida com sucesso :)'], 200);
        }

    }
}
