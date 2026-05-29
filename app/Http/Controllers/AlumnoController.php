<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AlumnoController extends Controller
{
    private const TABLE = 'alumno';

    public function obtenerTodos(): JsonResponse
    {
        return response()->json(DB::table(self::TABLE)->get());
    }

    public function obtenerPorId(int $id): JsonResponse
    {
        return response()->json($this->buscarAlumno($id));
    }

    public function crear(Request $request): JsonResponse
    {
        $data = $this->prepararDatos($request->validate($this->reglasCreacion()));
        $id = DB::table(self::TABLE)->insertGetId($data);

        return response()->json(
            DB::table(self::TABLE)->where('id', $id)->first(),
            201
        );
    }

    public function modificar(Request $request, int $id): JsonResponse
    {
        $this->buscarAlumno($id);

        $validated = $request->validate($this->reglasModificacion($id));

        if ($validated === []) {
            return response()->json(['message' => 'No hay datos para actualizar.'], 422);
        }

        $data = $this->prepararDatos($validated);
        DB::table(self::TABLE)->where('id', $id)->update($data);

        return response()->json(DB::table(self::TABLE)->where('id', $id)->first());
    }

    public function borrar(int $id): JsonResponse
    {
        $deleted = DB::table(self::TABLE)->where('id', $id)->delete();

        if ($deleted === 0) {
            return response()->json(['message' => 'Alumno no encontrado.'], 404);
        }

        return response()->json(null, 204);
    }

    private function buscarAlumno(int $id): object
    {
        $alumno = DB::table(self::TABLE)->where('id', $id)->first();

        if ($alumno === null) {
            abort(404, 'Alumno no encontrado.');
        }

        return $alumno;
    }

    private function reglasCreacion(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:32'],
            'telefono' => ['nullable', 'string', 'max:16'],
            'edad' => ['nullable', 'integer', 'min:0'],
            'password' => ['required', 'string', 'max:64'],
            'email' => ['required', 'string', 'email', 'max:64', 'unique:alumno,email'],
            'sexo' => ['required', 'string'],
        ];
    }

    private function reglasModificacion(int $id): array
    {
        return [
            'nombre' => ['sometimes', 'required', 'string', 'max:32'],
            'telefono' => ['nullable', 'string', 'max:16'],
            'edad' => ['nullable', 'integer', 'min:0'],
            'password' => ['sometimes', 'required', 'string', 'max:64'],
            'email' => [
                'sometimes',
                'required',
                'string',
                'email',
                'max:64',
                Rule::unique('alumno', 'email')->ignore($id),
            ],
            'sexo' => ['sometimes', 'required', 'string'],
        ];
    }

    private function prepararDatos(array $data): array
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $data;
    }
}
