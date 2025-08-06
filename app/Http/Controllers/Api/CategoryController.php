<?php

namespace App\Http\Controllers\Api;

use App\Models\Core\Category;
use App\Http\Controllers\Api\BaseController;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Categorias",
 *     description="Endpoints para gerenciamento de categorias"
 * )
 */
class CategoryController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/api/v1/categories",
     *     tags={"Categorias"},
     *     summary="Listar todas as categorias",
     *     description="Retorna uma lista de todas as categorias ativas e ordenadas, incluindo suas subcategorias.",
     *     @OA\Response(
     *         response=200,
     *         description="Operação bem-sucedida",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example=null),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Alimentação"),
     *                     @OA\Property(property="slug", type="string", example="alimentacao"),
     *                     @OA\Property(property="icon", type="string", example="fas fa-utensils"),
     *                     @OA\Property(property="order", type="integer", example=1),
     *                     @OA\Property(property="active", type="integer", example=1),
     *                     @OA\Property(property="created_at", type="string", example="2025-08-02T23:44:01.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", example="2025-08-02T23:44:01.000000Z"),
     *                     @OA\Property(
     *                         property="subcategories",
     *                         type="array",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="category_id", type="integer", example=1),
     *                             @OA\Property(property="name", type="string", example="Restaurantes"),
     *                             @OA\Property(property="slug", type="string", example="alimentacao-restaurantes"),
     *                             @OA\Property(property="icon", type="string", example=null),
     *                             @OA\Property(property="order", type="integer", example=1),
     *                             @OA\Property(property="active", type="integer", example=1),
     *                             @OA\Property(property="created_at", type="string", example="2025-08-02T23:44:01.000000Z"),
     *                             @OA\Property(property="updated_at", type="string", example="2025-08-02T23:44:01.000000Z")
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
     */
    public function index()
    {
        try {
            $categories = Category::with('subcategories')
                ->active()
                ->ordered()
                ->get();

            return $this->successResponse($categories);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve categories: ');
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/categories/featured",
     *     tags={"Categorias"},
     *     summary="Listar categorias com anúncios em destaque",
     *     description="Retorna uma lista de categorias ativas e ordenadas, incluindo os 4 anúncios mais recentes de suas subcategorias.",
     *     @OA\Response(
     *         response=200,
     *         description="Operação bem-sucedida",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items()
     *         )
     *     )
     * )
     */
    public function withListings()
    {
        $categories = Category::with([
            'subcategories.listings' => function ($query) {
                $query->active()->latest()->limit(4);
            }
        ])->active()->ordered()->get();

        return $this->successResponse($categories);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/categories/{id}",
     *     tags={"Categorias"},
     *     summary="Obter detalhes de uma categoria",
     *     description="Retorna os detalhes de uma categoria específica com base no ID fornecido.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da categoria",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operação bem-sucedida",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example=null),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Alimentação"),
     *                 @OA\Property(property="slug", type="string", example="alimentacao"),
     *                 @OA\Property(property="icon", type="string", example="fas fa-utensils"),
     *                 @OA\Property(property="order", type="integer", example=1),
     *                 @OA\Property(property="active", type="integer", example=1),
     *                 @OA\Property(property="created_at", type="string", example="2025-08-02T23:44:01.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", example="2025-08-02T23:44:01.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro interno do servidor"
     *     )
     * )
     */
    public function show(Category $category)
    {
        return $this->successResponse($category);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/categories/{id}/listings",
     *     tags={"Categorias"},
     *     summary="Listar anúncios de uma categoria",
     *     description="Retorna uma lista de todos os anúncios associados à categoria específica e suas subcategorias com base no ID fornecido.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da categoria",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operação bem-sucedida",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example=null),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=51),
     *                     @OA\Property(property="user_id", type="integer", example=2),
     *                     @OA\Property(property="category_id", type="integer", example=1),
     *                     @OA\Property(property="subcategory_id", type="integer", example=3),
     *                     @OA\Property(property="title", type="string", example="Id et enim officia ab sunt."),
     *                     @OA\Property(property="slug", type="string", example="id-et-enim-officia-ab-sunt"),
     *                     @OA\Property(property="description", type="string", example="Ut ut voluptatem at modi ex. Et dignissimos dolor aut est sit qui suscipit. Quia dolorem qui magni porro non at asperiores."),
     *                     @OA\Property(property="phone", type="string", example="978.437.0012"),
     *                     @OA\Property(property="whatsapp", type="boolean", example=true),
     *                     @OA\Property(property="address", type="string", example="4151 Madalyn Ferry"),
     *                     @OA\Property(property="city", type="string", example="New Matilda"),
     *                     @OA\Property(property="state", type="string", example="NH"),
     *                     @OA\Property(property="zip_code", type="string", example="47500"),
     *                     @OA\Property(property="latitude", type="string", example="-16.50531300"),
     *                     @OA\Property(property="longitude", type="string", example="-49.14707100"),
     *                     @OA\Property(property="delivery_available", type="boolean", example=true),
     *                     @OA\Property(property="website", type="string", example="https://lowe.com/alias-inventore-nisi-molestiae-quia-omnis-facere.html"),
     *                     @OA\Property(property="active", type="boolean", example=true),
     *                     @OA\Property(property="featured", type="boolean", example=false),
     *                     @OA\Property(property="featured_until", type="string", example=null),
     *                     @OA\Property(property="created_at", type="string", example="2025-08-02T23:44:47.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", example="2025-08-02T23:44:47.000000Z")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro interno do servidor"
     *     )
     * )
     */
    public function showWithListings(Category $category)
    {
        $category->load([
            'subcategories.listings' => function ($query) {
                $query->active()->latest()->limit(4);
            }
        ]);

        return $this->successResponse($category);
    }
}
