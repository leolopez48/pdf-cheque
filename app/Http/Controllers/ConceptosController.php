<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use App\Models\Conceptos;
use Illuminate\Http\Request;

class ConceptosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Conceptos  $conceptos
     * @return \Illuminate\Http\Response
     */
    public function show(Conceptos $conceptos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Conceptos  $conceptos
     * @return \Illuminate\Http\Response
     */
    public function edit(Conceptos $conceptos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conceptos  $conceptos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conceptos $conceptos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conceptos  $conceptos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conceptos $conceptos)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getConceptosPorCheque()
    {
        $conceptos = Cheque::join('conceptos as con', 'cheques.id', '=', 'con.cheque_id')
        ->orWhereNull('con.deleted_at')
        ->get();

        return response()->json(['message' => 'success', 'conceptos'=>$conceptos]);
    }
}
