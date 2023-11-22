<?php

namespace App\Http\Controllers\Api;

use App\Models\Actividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ActividadesController extends ApiController
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:actividad',
            'foto' => 'required',
            'descripcion' => 'required',
            'fecha' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError("Error de validación", $validator->errors(), 422);
        }

        $actividad = new Actividad();
        $actividad->nombre = $request->get("nombre");
        $actividad->foto = $request->get("foto");
        $actividad->fecha = $request->get("fecha");
        $actividad->descripcion = $request->get("descripcion");
        $actividad->save();

        $data = [
            'actividad' => $actividad
        ];
        return $this->sendResponse($data, "Actividad creada correctamente");
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $data = [];

        $actividades = DB::table("actividad")
            ->select("actividad.id", "actividad.nombre", "actividad.foto", "actividad.fecha")
            ->get();

        $data['actividades'] = $actividades;

        return $this->sendResponse($data, "Actividades recuperadas correctamente");
    }

    public function showDetail($id){
        $actividad = Actividad::find($id);
        if($actividad === null){
            return $this->sendError("Error en los datos", ["La actividad no existe"], 422);
        }

        $confirmations = DB::table("confirmation")
            ->where("confirmation.idactividad", "=", $id)
            ->join("userdata", "confirmation.iduser", "userdata.iduser")
            ->select("userdata.iduser", "userdata.nombre", "userdata.foto", "userdata.edad", "userdata.genero")
            ->get();

        $data = [];
        $data["actividad"] = $actividad;
        $data["users"] = $confirmations;
        return $this->sendResponse($data, "Actividades recuperadas correctamente");
    }
}
