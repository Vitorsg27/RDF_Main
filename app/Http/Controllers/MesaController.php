<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {   
        $mesas = Mesa::all();
        return Inertia::render('Mesa/Index', [
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
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'disponivel' => 'required|boolean',
        ]);

        Mesa::create($validated);
 
        return redirect(route('mesa.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Mesa $mesa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mesa $mesa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mesa $mesa)
    {
        $this->authorize('update', $mesa);
 
        $validated = $request->validate([
            'disponivel' => 'required|boolean',
        ]);
 
        $mesa->update($validated);
 
        return redirect(route('mesa.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mesa $mesa): RedirectResponse
    {
        $this->authorize('delete', $mesa);

        $mesa->delete();

        return redirect(route('mesa.index'));
    }
}
