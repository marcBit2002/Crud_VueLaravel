<?php

namespace App\Http\Controllers\Api;

use App\Models\Curs;
use App\Models\Cicle;
use App\Clases\Utilitat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CursResource;
use App\Http\Resources\CicleResource;
use Illuminate\Database\QueryException;

class CursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cursos = Curs::all();

        return CursResource::collection($cursos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $curs = new Curs;
        $curs->sigles = $request->input('sigles');
        $curs->nom = $request->input('nom');
        $curs->cicles_id = $request->input('cicle_id');
        $curs->actiu = ($request->input('actiu') == 'actiu');

        try {
            $curs->save();
            $response = response()->json(['mensaje' => 'Registre creat correctament'], 201);
            //$response =  (new CursResource($curs))->response()->setStatusCode(201);
        } catch (QueryException $exception) {
            $mensaje = Utilitat::errorMessage($exception);
            $response =  response()->json(['error' => $mensaje], 400);
        }
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Curs  $curs
     * @return \Illuminate\Http\Response
     */
    public function show(Curs $curso)
    {
        return new CursResource($curso);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Curs  $curs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Curs $curso)
    {
        $curso->sigles = $request->input('sigles');
        $curso->nom = $request->input('nom');
        $curso->cicles_id = $request->input('cicle_id');
        $curso->actiu = ($request->input('actiu') == 'actiu');

        try {
            $curso->save();
            $response = response()->json(['mensaje' => 'Registre actualitzat correctament'], 201);
        } catch (QueryException $exception) {
            $mensaje = Utilitat::errorMessage($exception);
            $response =  response()->json(['error' => $mensaje], 400);
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Curs  $curs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Curs $curso)
    {
        try {
            $curso->delete();
            $response =  response()->json(['mensaje' => 'Registre esborrat correctament'], 200);
        } catch (QueryException $exception) {
            $mensaje = Utilitat::errorMessage($exception);
            $response =  response()->json(['error' => $mensaje], 400);
        }
        return $response;
    }
}
