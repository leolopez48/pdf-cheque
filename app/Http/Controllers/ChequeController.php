<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use App\Models\Conceptos;
use Illuminate\Http\Request;

class ChequeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cheques = Cheque::get();

        return response()->json(['message' => 'success', 'cheques'=>$cheques]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conceptos = $request->conceptos;

        $cheque = new Cheque;
        $cheque->nombre = $request->cheque['nombre'];
        $cheque->monto = $request->cheque['monto'];
        $cheque->save();

        foreach ($conceptos as $concepto) {
            Conceptos::insert([
                'codigo'=>$concepto['codigo'],
                'concepto'=>$concepto['concepto'],
                'monto'=>$concepto['monto'],
                'cheque_id'=>$cheque->id
            ]);
        }
        return response()->json(['message'=>'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cheque  $cheques
     * @return \Illuminate\Http\Response
     */
    public function show(Cheque $cheque)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cheque  $cheques
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cheque $cheque)
    {
        $conceptos = $request->conceptos;

        $cheque->nombre = $request->cheque['nombre'];
        $cheque->monto = $request->cheque['monto'];
        $cheque->save();

        Conceptos::where('cheque_id', $cheque->id)->delete();

        foreach ($conceptos as $concepto) {
            Conceptos::updateOrCreate([
                'codigo'=>$concepto['codigo'],
                'concepto'=>$concepto['concepto'],
                'monto'=>$concepto['monto'],
                'cheque_id'=>$cheque->id
            ]);
        }
        return response()->json(["message"=>"success"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cheque  $cheques
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cheque $cheque)
    {
        Cheque::where('id', $cheque->id)->delete();
        return response()->json(["message"=>"success"]);
    }
}
