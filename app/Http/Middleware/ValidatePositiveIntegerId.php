<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidatePositiveIntegerId
{
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->route('id');

        $valid = filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

        if ($valid === false) {
            return response()->json([
                'message' => 'El identificador debe ser un número entero positivo.',
            ], 422);
        }

        return $next($request);
    }
}
