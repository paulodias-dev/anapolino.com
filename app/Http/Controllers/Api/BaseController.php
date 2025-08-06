<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;


/**
 * @OA\Info(
 *     title="Anapolino Classificados API",
 *     version="1.0.0",
 *     description="API para o sistema de classificados da cidade de Anápolis",
 *     @OA\Contact(
 *         email="suporte@anapolino.com.br",
 *         name="Equipe de Suporte"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 *
 * @OA\Tag(
 *     name="Autenticação",
 *     description="Endpoints para autenticação de usuários"
 * )
 */
class BaseController extends Controller
{
    protected function successResponse($data, $message = null, $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse($message, $code = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null
        ], $code);
    }
}
