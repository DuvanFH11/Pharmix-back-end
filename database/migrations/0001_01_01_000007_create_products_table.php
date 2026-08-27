<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\NullableType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 50)->comment('Nombre del producto');
            $table->string('brand', 50)->comment('Marca del producto');
            $table->text('description')->comment('Descripción del producto');
            $table->decimal('unit_price', 12, 2)->comment('Precio por unidad del producto');
            $table->decimal('package_price', 12,2)->comment('Precio por paquete del producto');
            $table->string('invima_registration')->comment('Registro del invima');
            $table->boolean('is_active')->default(true)->comment('Está activo');
            $table->string('strength')->comment('Cantidad de principio');
            $table->string('unit')->comment('unidad de medida');
            
            $table->foreignId('user_creator')->nullable()->constrained('users')->onDelete('set null')->comment('Creado por');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
