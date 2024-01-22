<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cardapio;
use App\Models\Mesa;
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
        $cardapio = Cardapio::all();
        $mesas = Mesa::all();
        return Inertia::render('Pedido/Index', [
            'pedidos' => $pedidos,
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
        $validated = $request->validate([
            'mesa_id' => 'required|exists:mesas,id|numeric',
            'itens' => 'required|array',
            'itens.*.nome' => 'required|string|max:255',
            'itens.*.quantidade' => 'required|numeric|min:1',
            'itens.*.preco' => 'required|numeric|min:0.01',
            'itens.*.observacao' => 'nullable|string',
        ]);
    
        $validated['itens'] = json_encode($validated['itens']);
    
        $pedido->update($validated);
    
        return redirect(route('pedido.index'));
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