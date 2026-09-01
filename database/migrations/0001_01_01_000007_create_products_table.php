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
            $table->string('description', 250)->comment('Descripción del producto');
            $table->decimal('unit_price', 12, 2)->unsigned()->comment('Precio por unidad del producto');
            $table->decimal('package_price', 12,2)->unsigned()->comment('Precio por paquete del producto');
            $table->string('invima_registration', 50)->comment('Registro del invima');
            $table->boolean('is_active')->default(true)->comment('Está activo');
            $table->decimal('strength', 12,4)->unsigned()->comment('Cantidad de principio');
            $table->string('unit', 2)->comment('Unidad de medida');
            
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
