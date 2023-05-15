<?php

namespace App\Http\Controllers;

use App\Models\Curs;
use App\Models\Cicle;
use App\Clases\Utilitat;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class CursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $actiu = $request->input('actiuBuscar');
        $ciclosBuscar = $request->input('ciclosBuscar');
        if (!empty($ciclosBuscar)) {
            if ($actiu == 'actiu') {
                $cursos = Curs::where('actiu', '=', true)->where('cicles_id', '=', $ciclosBuscar)->orderBy('nom', 'ASC')->paginate(6)->withQueryString();
            } else {
                $cursos = Curs::where('cicles_id', '=', $ciclosBuscar)->orderBy('nom', 'ASC')->paginate(6)->withQueryString();
            }
        } else {
            if ($actiu == 'actiu') {
                $cursos = Curs::where('actiu', '=', true)->orderBy('nom', 'ASC')->paginate(6)->withQueryString();
            } else {
                $cursos = Curs::orderBy('nom', 'ASC')->paginate(6)->withQueryString();
            }
        }
        $cicles = Cicle::where('actiu', '=', true)->orderBy('nom', 'ASC')->get();
        $request->flash($request->input());

        return view('cursos.index', compact('cursos', 'cicles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cicles = Cicle::where('actiu', true)->orderBy('nom')->get();
        $insert = true;
        return view('cursos.create', compact('cicles', 'insert'));
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
        $curs->cicles_id = $request->input('cicles_id');
        $curs->actiu = ($request->input('actiu') == 'actiu');

        try {
            $curs->save();
            $response =  redirect()->action([CursController::class, 'index']);
            session()->flash('mensaje', 'Registre creat correctament');
        } catch (QueryException $exception) {
            $mensaje = Utilitat::errorMessage($exception);
            session()->flash('error', $mensaje);
            $response =  redirect()->action([CursController::class, 'create'])->withInput();
        }
        return $response;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Curs  $curs
     * @return \Illuminate\Http\Response
     */
    public function show(Curs $curs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Curs  $curs
     * @return \Illuminate\Http\Response
     */
    public function edit(Curs $curso)
    {
        $cicles = Cicle::where('actiu', true)->orderBy('nom', 'ASC')->get();
        $insert = false;
        return view('cursos.create', compact('cicles', 'curso', 'insert'));
    }

    /**
     * 

     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Curs  $curs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Curs $curso)
    {
        $curso->nom = $request->input('nom');
        $curso->sigles = $request->input('sigles');
        $curso->cicles_id = $request->input('cicles_id');
        $curso->actiu = ($request->input('actiu') == 'actiu');

        try {
            $curso->save();
            $response =  redirect()->action([CursController::class, 'index']);
            session()->flash('mensaje', 'Registre actualitzat correctament');
        } catch (QueryException $exception) {
            $mensaje = Utilitat::errorMessage($exception);
            session()->flash('error', $mensaje);
            $response =  redirect()->action([CursController::class, 'edit'], ['curso' => $curso->id])->withInput();
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
            session()->flash('mensaje', 'Registre esborrat correctament');
        } catch (QueryException $exception) {
            $mensaje = Utilitat::errorMessage($exception);
            session()->flash('error', $mensaje);
        }
        return redirect()->action([CursController::class, 'index']);
    }
}
