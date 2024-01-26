<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AnuncioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $anuncios = $request->user()->anuncios;

        return response()->json($anuncios, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $anuncio = $request->user()->anuncios()->create([
            'nome' => $request->nome,
            'link' => $request->link,
        ]);

        return response()->json($anuncio, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Anuncio $anuncio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anuncio $anuncio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anuncio $anuncio)
    {
        if (!Gate::allows('update-anuncio', $anuncio)) {
            return response()->json(['message' => 'Esse anúncio é de outro usuário!'], 404);
        }
        $anuncio->update([
            'nome' => $request->nome,
            'link' => $request->link ?? $anuncio->link,
        ]);

        return response()->json($anuncio, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anuncio $anuncio)
    {
        if (!Gate::allows('update-anuncio', $anuncio)) {
            return response()->json(['message' => 'Esse anúncio é de outro usuário!'], 404);
        }

        $anuncio->delete();

        return response()->json($anuncio, 200);
    }
}
