<?php

namespace App\Http\Controllers;

use App\Models\RecetaMedicamento;
use App\Models\Receta;
use Illuminate\Http\Request;

class RecetaMedicamentoController extends Controller
{
    public function index()
    {
        $medicamentos = RecetaMedicamento::with('receta')->latest('id_detalle')->paginate(10);
        return view('receta_medicamentos.index', compact('medicamentos'));
    }

    public function create()
    {
        $recetas = Receta::orderBy('id_receta')->get();
        return view('receta_medicamentos.create', compact('recetas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'recetas_id' => 'required|exists:recetas,id_receta',
            'nombre_medicamento' => 'required|string|max:100',
            'dosis' => 'nullable|string|max:50',
            'via_administracion' => 'nullable|string|max:30',
            'duracion' => 'nullable|string|max:50',
            'instrucciones' => 'nullable|string|max:200',
        ]);

        RecetaMedicamento::create($data);

        return redirect()->route('receta-medicamentos.index')->with('success', 'Medicamento agregado correctamente.');
    }

    public function show(RecetaMedicamento $receta_medicamento)
    {
        $receta_medicamento->load('receta');
        return view('receta_medicamentos.show', compact('receta_medicamento'));
    }

    public function edit(RecetaMedicamento $receta_medicamento)
    {
        $recetas = Receta::orderBy('id_receta')->get();
        return view('receta_medicamentos.edit', compact('receta_medicamento', 'recetas'));
    }

    public function update(Request $request, RecetaMedicamento $receta_medicamento)
    {
        $data = $request->validate([
            'recetas_id' => 'required|exists:recetas,id_receta',
            'nombre_medicamento' => 'required|string|max:100',
            'dosis' => 'nullable|string|max:50',
            'via_administracion' => 'nullable|string|max:30',
            'duracion' => 'nullable|string|max:50',
            'instrucciones' => 'nullable|string|max:200',
        ]);

        $receta_medicamento->update($data);

        return redirect()->route('receta-medicamentos.index')->with('success', 'Medicamento actualizado correctamente.');
    }

    public function destroy(RecetaMedicamento $receta_medicamento)
    {
        $receta_medicamento->delete();

        return redirect()->route('receta-medicamentos.index')->with('success', 'Medicamento eliminado correctamente.');
    }
}