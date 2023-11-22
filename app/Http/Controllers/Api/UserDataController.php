<?php

namespace App\Http\Controllers\Api;

use App\Models\UserData;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserDataController extends ApiController
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'edad' => 'required',
            'genero' => 'required',
            'acercade' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError("Error de validación", $validator->errors(), 422);
        }

        $input = $request->all();
        $input["password"] = bcrypt($request->get("password"));
        $user = User::create($input);
        $token = $user->createToken("MyApp")->accessToken;

        $userdata = new Userdata();
        $userdata->nombre = $request->get("name");
        $userdata->foto = $request->get("foto");
        $userdata->edad = $request->get("edad");
        $userdata->genero = $request->get("genero");
        $userdata->acercade = $request->get("acercade");
        $userdata->iduser = $user->id;
        $userdata->save();

        $data = [
            'token' => $token,
            'user' => $user,
            'userdata' => $userdata
        ];

        return $this->sendResponse($data, "Usuario creado correctamente");
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $data = [];
        // $users = Userdata::all();
        $users = DB::table("users")
            ->join("userdata", "users.id", "=", "userdata.iduser")
            ->select("users.id", "userdata.nombre", "userdata.foto", "userdata.edad", "userdata.genero")
            ->get();

        $data['users'] = $users;

        return $this->sendResponse($data, "usuarios obtenidos correctamente.");
    }
    
    /**
     * Display the specified resource by id.
     */
    public function showDetail($id)
    {
        $user = new User();
        $userdata = Userdata::where("iduser", "=", $id)->first();
        $data = [];
        $data["user"] = $user->find($id);
        $data["userdata"] = $userdata;

        return $this->sendResponse($data, "usuario consultado correctamente");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = User::find($request->get("id"));
        if($user === null){
            return $this->sendError("Error en los datos", ["El usuario no existe"], 422);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'edad' => 'required',
            'genero' => 'required',
            'acercade' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError("Error de validación", $validator->errors(), 422);
        }

        $user->name = $request->get("name");
        $user->save();

        $userdata = Userdata::where("iduser", "=", $request->get("id"))->first();
        $userdata->nombre = $request->get("name");
        $userdata->edad = $request->get("edad");
        $userdata->genero = $request->get("genero");
        $userdata->acercade = $request->get("acercade");
        $userdata->save();

        $data = [
            'user' => $user,
            'userdata' => $userdata
        ];

        return $this->sendResponse($data, "Usuario modificado correctamente");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $user = User::find($request->get("id"));
        if ($user === null) {
            return $this->sendError("Error en los datos", ["El usuario no existe"], 422);
        }

        $user->delete();
        $userdata = Userdata::where("iduser", "=", $request->get("id"))->first();
        $userdata->delete();

        return $this->sendResponse([
            'status' => "OK"
        ], "Usuario borrado correctamente");
    }
}
