<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Municipio;
use Illuminate\Http\Request;

class LocalidadController extends Controller
{
    public function getDepartamentos($paisId)
    {
        $departamentos = Departamento::where('pais_id', $paisId)->get();
        return response()->json($departamentos);
    }

    public function getMunicipios($departamentoId)
    {
        $municipios = Municipio::where('departamento_id', $departamentoId)->get();
        return response()->json($municipios);
    }
}