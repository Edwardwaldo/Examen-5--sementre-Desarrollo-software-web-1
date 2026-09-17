<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 50)->unique();
            $table->string('nombre', 150);
            $table->string('descripcion_corta', 255);
            $table->text('descripcion_larga');
            $table->string('imagen', 255)->nullable();
            $table->decimal('precio_neto', 10, 2);
            $table->decimal('precio_venta', 10, 2); // precio_neto * 1.19 (IVA 19%)
            $table->integer('stock_actual');
            $table->integer('stock_minimo');
            $table->integer('stock_bajo');
            $table->integer('stock_alto');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
