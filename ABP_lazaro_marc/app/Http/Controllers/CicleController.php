<?php

namespace App\Http\Controllers;

use App\Clases\Cicle;
use Illuminate\Http\Request;

class CicleController extends Controller
{
    public function index()
    {
        $cicles = session()->get('cicles');
        if (!$cicles) {
            $cicles = [];
            session()->put('cicles', $cicles);
        }
        return view('cicles.index', compact('cicles'));
    }

    public function create()
    {
        return view('cicles.create');
    }

    public function store(Request $request)
    {
        $id = $request->input('id');
        $sigla = $request->input('sigla');
        $nom = $request->input('nom');
        $cicles = $request->session()->get('cicles', []);
        $cicle = new Cicle($id, $sigla, $nom);
        $cicles[] = $cicle;
        $request->session()->put('cicles', $cicles);
        return redirect()->action([CicleController::class, 'index']);
    }

    public function destroy($id)
    {
        $cicles = session()->get('cicles');
        for ($i = 0; $i < count($cicles); $i++) {
            if ($cicles[$i]->getId() == $id) {
                array_splice($cicles, $i, 1);
                break;
            }
        }
        session()->put('cicles', $cicles);
        return redirect()->action([CicleController::class, 'index']);
    }
}
