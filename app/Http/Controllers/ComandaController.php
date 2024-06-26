<?php

namespace App\Http\Controllers;

use App\Models\Comanda;
use App\Models\Cardapio;
use App\Models\Mesa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ComandaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $comandas = Comanda::all();
        $cardapio = Cardapio::where('estoque', '>', 0)->get();
        $mesas = Mesa::all();
        return Inertia::render('Comanda/Index', [
            'comandas' => $comandas,
            'produtos' => $cardapio,
            'mesas' => $mesas
        ]);
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
        $validated = $request->validate([
            'mesa_id' => 'required|exists:mesas,id|numeric',
            'itens' => 'required|array',
            'itens.*.nome' => 'required|string|max:255',
            'itens.*.quantidade' => 'required|numeric|min:1',
            'itens.*.preco' => 'required|numeric|min:0.01',
            'itens.*.observacao' => 'nullable|string',
        ]);

        $validated['itens'] = json_encode($validated['itens']);

        Comanda::create($validated);
 
        return redirect(route('comanda.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Comanda $comanda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comanda $comanda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comanda $comanda)
    {
        $validated = $request->validate([
            'mesa_id' => 'required|exists:mesas,id|numeric',
            'itens' => 'required|array',
            'itens.*.nome' => 'required|string|max:255',
            'itens.*.quantidade' => 'required|numeric|min:1',
            'itens.*.preco' => 'required|numeric|min:0.01',
            'itens.*.observacao' => 'nullable|string',
            'aberto' => 'required|boolean',
        ]);
    
        $validated['itens'] = json_encode($validated['itens']);
    
        $comanda->update($validated);
    
        return redirect(route('comanda.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comanda $comanda)
    {
        $this->authorize('delete', $comanda);

        $comanda->delete();

        return redirect(route('comanda.index'));
    }
}