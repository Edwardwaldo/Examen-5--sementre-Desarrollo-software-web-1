<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Listar todos los productos.
     */
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('products.index', compact('products'));
    }

    /**
     * Formulario para crear producto.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Guardar nuevo producto.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sku'               => ['required', 'string', 'max:50', 'unique:products,sku'],
            'nombre'            => ['required', 'string', 'max:150'],
            'descripcion_corta' => ['required', 'string', 'max:255'],
            'descripcion_larga' => ['required', 'string'],
            'imagen'            => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'precio_neto'       => ['required', 'numeric', 'min:0'],
            'stock_actual'      => ['required', 'integer', 'min:0'],
            'stock_minimo'      => ['required', 'integer', 'min:0'],
            'stock_bajo'        => ['required', 'integer', 'min:0'],
            'stock_alto'        => ['required', 'integer', 'min:0'],
        ]);

        // Subir imagen
        $imagePath = $request->file('imagen')->store('products', 'public');

        Product::create([
            'sku'               => $request->sku,
            'nombre'            => $request->nombre,
            'descripcion_corta' => $request->descripcion_corta,
            'descripcion_larga' => $request->descripcion_larga,
            'imagen'            => $imagePath,
            'precio_neto'       => $request->precio_neto,
            'precio_venta'      => round($request->precio_neto * 1.19, 2), // IVA 19%
            'stock_actual'      => $request->stock_actual,
            'stock_minimo'      => $request->stock_minimo,
            'stock_bajo'        => $request->stock_bajo,
            'stock_alto'        => $request->stock_alto,
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Producto creado correctamente.');
    }

    /**
     * Formulario para editar producto.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Actualizar producto existente.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'sku'               => ['required', 'string', 'max:50', Rule::unique('products', 'sku')->ignore($product->id)],
            'nombre'            => ['required', 'string', 'max:150'],
            'descripcion_corta' => ['required', 'string', 'max:255'],
            'descripcion_larga' => ['required', 'string'],
            'imagen'            => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'precio_neto'       => ['required', 'numeric', 'min:0'],
            'stock_actual'      => ['required', 'integer', 'min:0'],
            'stock_minimo'      => ['required', 'integer', 'min:0'],
            'stock_bajo'        => ['required', 'integer', 'min:0'],
            'stock_alto'        => ['required', 'integer', 'min:0'],
        ]);

        $data = [
            'sku'               => $request->sku,
            'nombre'            => $request->nombre,
            'descripcion_corta' => $request->descripcion_corta,
            'descripcion_larga' => $request->descripcion_larga,
            'precio_neto'       => $request->precio_neto,
            'precio_venta'      => round($request->precio_neto * 1.19, 2),
            'stock_actual'      => $request->stock_actual,
            'stock_minimo'      => $request->stock_minimo,
            'stock_bajo'        => $request->stock_bajo,
            'stock_alto'        => $request->stock_alto,
        ];

        // Actualizar imagen solo si se sube una nueva
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior
            if ($product->imagen) {
                Storage::disk('public')->delete($product->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Eliminar producto.
     */
    public function destroy(Product $product)
    {
        // Eliminar imagen del storage
        if ($product->imagen) {
            Storage::disk('public')->delete($product->imagen);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}
