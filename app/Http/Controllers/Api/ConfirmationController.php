<?php

namespace App\Http\Controllers\Api;

use App\Models\Confirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Actividad;

class ConfirmationController extends ApiController
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'iduser' => 'required',
            'idactividad' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError("Error de validación", $validator->errors(), 422);
        }

        $confirmation = Confirmation::where([
            ["iduser", "=", $request->get("iduser")],
            ["idactividad", "=", $request->get("idactividad")],
            ])->first();
        if($confirmation !== null){
            return $this->sendError("Error de confirmación", ["El usuario ya ha confirmado previamente"], 422);
        }

        $confirmation = new Confirmation();
        $confirmation->iduser = $request->get("iduser");
        $confirmation->idactividad = $request->get("idactividad");
        $confirmation->save();

        /*$users = DB::table("confirmation")
            ->where("confirmation.idactividad", "=", $confirmation->idactividad)
            ->join("userdata", "confirmation.iduser", "userdata.iduser")
            ->select("userdata.idonesignal")
            ->get();*/
        /*foreach ($users as $user){
            $id = $user->idonesignal;
            if($id !=1){
                OneSignal::sendNotificationToUser("Se ha apuntado otro usuario a la actividad",
                    $id,
                    $url = null,
                    $data = null,
                    $buttons = null,
                    $schedule = null);
            }
        }*/


        $data = [
            'confirmation' => $confirmation
        ];
        return $this->sendResponse($data, "Confirmación creada correctamente");
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $data = [];
        $confirmations = Confirmation::all();

        $data['confirmations'] = $confirmations;

        return $this->sendResponse($data, "Confirmaciones recuperadas correctamente");
    }

    /**
     * Display the specified resource by id.
     */
    public function showDetail($id)
    {
        $confirmation = Confirmation::find($id);
        if ($confirmation === null) {
            return $this->sendError("Error en los datos", ["La confirmación no existe"], 422);
        }

        $actividad = Actividad::find($confirmation->idactividad);
        if($actividad === null){
            return $this->sendError("Error en los datos", ["La actividado no existe"], 422);
        }

        $users = DB::table("confirmation")
            ->where("confirmation.idactividad", "=", $confirmation->idactividad)
            ->join("userdata", "confirmation.iduser", "userdata.iduser")
            ->select("userdata.iduser", "userdata.nombre", "userdata.foto", "userdata.edad", "userdata.genero")
            ->get();

        $data = [
            'actividad' => $actividad,
            'users' => $users
        ];
        return $this->sendResponse($data, "Confirmación recuperada correctamente");
    }

    /**
     * Display the specified resource by user id.
     */
    public function showDetailUser($id)
    {
        $confirmations = DB::table("confirmation")
            ->where("confirmation.iduser", "=", $id)
            ->join("actividad", "confirmation.idactividad", "actividad.id")
            ->get();


        $data = [
            'confirmations' => $confirmations
        ];
        return $this->sendResponse($data, "Confirmaciones recuperadas correctamente");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $confirmation = Confirmation::find($request->get("id"));
        if ($confirmation === null) {
            return $this->sendError("Error en los datos", ["El usuario no existe"], 422);
        }

        $confirmation->delete();

        return $this->sendResponse([
            'status' => "OK"
        ], "Confirmación borrada correctamente");
    }
}
