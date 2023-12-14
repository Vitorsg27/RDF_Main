<?php

namespace App\Http\Controllers;

use App\Models\Cardapio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CardapioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $items = Cardapio::all();
        
        return Inertia::render('Cardapio/Index',[
            'items' => $items,
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
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'preco' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/']
        ]);
 
        Cardapio::create($validated);
 
        return redirect(route('cardapio.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Cardapio $cardapio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cardapio $cardapio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cardapio $cardapio): RedirectResponse
    {
        $this->authorize('update', $cardapio);
 
        $validated = $request->validate([
            'descricao' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0.01|max:999.99',
        ]);
 
        $cardapio->update($validated);
 
        return redirect(route('cardapio.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cardapio $cardapio)
    {
        //
    }
}
