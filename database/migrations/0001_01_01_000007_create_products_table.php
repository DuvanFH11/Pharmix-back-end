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
            $table->unsignedBigInteger('unit_price')->comment('Precio por unidad del producto');
            $table->unsignedBigInteger('package_price')->comment('Precio por paquete del producto');
            $table->string('invima_registration', 50)->comment('Registro del invima');
            $table->decimal('strength', 8,2)->unsigned()->comment('Cantidad de principio');
            $table->string('unit', 2)->comment('Unidad de medida');
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
