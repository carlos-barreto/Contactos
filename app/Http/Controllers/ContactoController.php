<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Contacto::whereHas('account', function ($q) {
            $q->where('id_user', Auth::user()->id);
        })->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        try {
            // DB::beginTransaction();
            $validated = Validator::make($request->all(), [
                "nombre"            => 'required|max:255',
                "telefono"          => 'required|max:255',
                "fecha_nacimiento"  => 'required|max:255',
                'direccion'         => 'required|max:255',
                "email"             => 'required|max:255',
                "sexo"              => 'required',
            ]);
            if ($validated->fails()) {
                return response()->json($validated, 210);
            }

            if ($request->fecha_nacimiento) {
                # test validar fecha de nacimiento, si la persona es menor a 18 retorna error
                $años = $this->calcularFecha($request->fecha_nacimiento);
                if ($años < 18) {
                    $data['respuesta'] = [
                        'codigo' => 502,
                        'icon' => 'mdi-succsess',
                        'text' => 'El contacto es menor de edad, tiene (' . $años . ') años, verifique datos.',

                    ];
                    return response()->json($data, 500);
                }
            }

            $crearContacto = Contacto::create([
                "id_user"           => Auth::user()->id,
                "nombre"            => $request->nombre,
                "telefono"          => $request->telefono,
                "fecha_nacimiento"  => $request->fecha_nacimiento,
                'direccion'         => $request->direccion,
                "email"             => $request->email,
                "sexo"              => $request->sexo,
            ]);
            $data['respuesta'] = [
                'codigo' => 200,
                'icon' => 'mdi-succsess',
                'text' => 'Contacto añadido.',
                'data' => $crearContacto->id
            ];
            return response()->json($data, 200);
            // DB::commit();
        } catch (\Exception $e) {
            // DB::rollBack();
            $data['respuesta'] = [
                'codigo' => 412,
                'icon' => 'mdi-succsess',
                'text2' => 'Los datos proporcionados no son validos.',
                'text' => $e->getMessage(),
            ];
            return response()->json($data, 412);
        }
    }

    /**
     * Calclular fecha
     * @return bool
     */

    public function calcularFecha($fecha)
    {
        $f_nacimiento = new DateTime($fecha);
        // $hoy =  Carbon::parce(NOW());
        $hoy =  new DateTime(date("Y-m-d"));

        $calclular = $hoy->diff($f_nacimiento);
        return $calclular->format('%y');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contacto  $contacto
     * @return \Illuminate\Http\Response
     */
    public function show(Contacto $contacto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contacto  $contacto
     * @return \Illuminate\Http\Response
     */
    public function edit(Contacto $contacto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contacto  $contacto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contacto $contacto)
    {
        try {
            // DB::beginTransaction();

            $actualizarContacto = Contacto::where('id', $request->params['id'])->update([
                "nombre"            => $request->params['nombre'],
                "telefono"          => $request->params['telefono'],
                "fecha_nacimiento"  => $request->params['fecha_nacimiento'],
                'direccion'         => $request->params['direccion'],
                "email"             => $request->params['email'],
                "sexo"             => $request->params['sexo'],
            ]);
            $data['respuesta'] = [
                'codigo' => 200,
                'icon' => 'mdi-succsess',
                'text' => 'Contacto actualizado.',
                'data' => $actualizarContacto
            ];
            return response()->json($data, 200);
            // DB::commit();
        } catch (\Exception $e) {
            // DB::rollBack();
            $data['respuesta'] = [
                'codigo' => 412,
                'icon' => 'mdi-succsess',
                'text2' => 'Los datos proporcionados no son validos.',
                'text' => $e->getMessage(),
                'line' => $e->getLine(),
            ];
            return response()->json($data, 412);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contacto  $contacto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {
            // DB::beginTransaction();

            $contacto = Contacto::where('id', $id)->delete();
            $data['respuesta'] = [
                'codigo' => 200,
                'icon' => 'mdi-succsess',
                'text' => 'Contacto eliminado.',
                'data' => $contacto
            ];
            return response()->json($data, 200);
            // DB::commit();
        } catch (\Exception $e) {
            // DB::rollBack();
            $data['respuesta'] = [
                'codigo' => 412,
                'icon' => 'mdi-succsess',
                'text2' => 'Los datos proporcionados no son validos.',
                'text' => $e->getMessage(),
                'line' => $e->getLine(),
            ];
            return response()->json($data, 412);
        }
    }
}