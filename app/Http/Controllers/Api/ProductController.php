<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * GET /api/products — Listar todos los productos.
     */
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();

        return response()->json([
            'message' => 'Listado de productos.',
            'data'    => $products,
            'total'   => $products->count(),
        ], 200);
    }

    /**
     * GET /api/products/{id} — Obtener producto por ID.
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (! $product) {
            return response()->json([
                'message' => 'Producto no encontrado.',
            ], 404);
        }

        return response()->json([
            'message' => 'Producto encontrado.',
            'data'    => $product,
        ], 200);
    }

    /**
     * POST /api/products — Crear nuevo producto.
     * Nota: para la API se envía la imagen como nombre/URL de string (no upload).
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'sku'               => ['required', 'string', 'max:50', 'unique:products,sku'],
                'nombre'            => ['required', 'string', 'max:150'],
                'descripcion_corta' => ['required', 'string', 'max:255'],
                'descripcion_larga' => ['required', 'string'],
                'imagen'            => ['required', 'string', 'max:255'],
                'precio_neto'       => ['required', 'numeric', 'min:0'],
                'stock_actual'      => ['required', 'integer', 'min:0'],
                'stock_minimo'      => ['required', 'integer', 'min:0'],
                'stock_bajo'        => ['required', 'integer', 'min:0'],
                'stock_alto'        => ['required', 'integer', 'min:0'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación.',
                'errors'  => $e->errors(),
            ], 422);
        }

        // Calcular precio de venta con IVA 19%
        $validated['precio_venta'] = round($validated['precio_neto'] * 1.19, 2);

        $product = Product::create($validated);

        return response()->json([
            'message' => 'Producto creado correctamente.',
            'data'    => $product,
        ], 201);
    }

    /**
     * PUT /api/products/{id} — Actualizar producto.
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (! $product) {
            return response()->json([
                'message' => 'Producto no encontrado.',
            ], 404);
        }

        try {
            $validated = $request->validate([
                'sku'               => ['required', 'string', 'max:50', Rule::unique('products', 'sku')->ignore($id)],
                'nombre'            => ['required', 'string', 'max:150'],
                'descripcion_corta' => ['required', 'string', 'max:255'],
                'descripcion_larga' => ['required', 'string'],
                'imagen'            => ['nullable', 'string', 'max:255'],
                'precio_neto'       => ['required', 'numeric', 'min:0'],
                'stock_actual'      => ['required', 'integer', 'min:0'],
                'stock_minimo'      => ['required', 'integer', 'min:0'],
                'stock_bajo'        => ['required', 'integer', 'min:0'],
                'stock_alto'        => ['required', 'integer', 'min:0'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación.',
                'errors'  => $e->errors(),
            ], 422);
        }

        // Recalcular precio de venta
        $validated['precio_venta'] = round($validated['precio_neto'] * 1.19, 2);

        $product->update($validated);

        return response()->json([
            'message' => 'Producto actualizado correctamente.',
            'data'    => $product,
        ], 200);
    }

    /**
     * DELETE /api/products/{id} — Eliminar producto.
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (! $product) {
            return response()->json([
                'message' => 'Producto no encontrado.',
            ], 404);
        }

        $product->delete();

        return response()->json([
            'message' => 'Producto eliminado correctamente.',
        ], 200);
    }
}
