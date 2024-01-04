<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $pedidos = Pedido::all();
        return Inertia::render('Pedido/Index', [
            'pedidos' => $pedidos
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
            'disponivel' => 'required|boolean',
        ]);

        Pedido::create($validated);
 
        return redirect(route('pedido.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        $this->authorize('update', $pedido);
 
        $validated = $request->validate([
            'disponivel' => 'required|boolean',
        ]);
 
        $pedido->update($validated);
 
        return redirect(route('mesa.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        $this->authorize('delete', $pedido);

        $pedido->delete();

        return redirect(route('pedido.index'));
    }
}
