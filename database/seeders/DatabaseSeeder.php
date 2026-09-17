<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Product;
use App\Models\Client;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Usuario administrador ───────────────────────────
        User::create([
            'rut'      => '11111111-1',
            'nombre'   => 'Administrador',
            'apellido' => 'Sistema',
            'email'    => 'admin@ventasfix.cl',
            'password' => Hash::make('Admin1234'),
        ]);

        // ── Producto de ejemplo ─────────────────────────────
        Product::create([
            'sku'               => 'PROD-001',
            'nombre'            => 'Teclado USB Estándar',
            'descripcion_corta' => 'Teclado USB 104 teclas, idioma español.',
            'descripcion_larga' => 'Teclado USB de 104 teclas con distribución en español de Chile. Compatible con Windows, Mac y Linux. Cable de 1.5 metros.',
            'imagen'            => 'products/teclado.jpg',
            'precio_neto'       => 15000,
            'precio_venta'      => round(15000 * 1.19, 2), // 17850
            'stock_actual'      => 50,
            'stock_minimo'      => 5,
            'stock_bajo'        => 10,
            'stock_alto'        => 100,
        ]);

        // ── Cliente de ejemplo ──────────────────────────────
        Client::create([
            'rut_empresa'     => '76123456-7',
            'rubro'           => 'Tecnología',
            'razon_social'    => 'Empresa Tecnológica SA',
            'telefono'        => '+56912345678',
            'direccion'       => 'Av. Providencia 123, Santiago',
            'nombre_contacto' => 'Ana González',
            'email_contacto'  => 'ana.gonzalez@empresatec.cl',
        ]);
    }
}
