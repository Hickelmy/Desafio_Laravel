<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



return new class extends Migration
{
    /**
     * Run the migrations.
     */

     
     public function up(): void
     {
         if (!Schema::hasTable('products')) {
             Schema::create('products', function (Blueprint $table) {
                 $table->id();
                 $table->string('name');
                 $table->text('description');
                 $table->decimal('price', 8, 2);
                 $table->date('expiration_date');
                 $table->string('image')->nullable();
                 $table->foreignId('category_id')->constrained('categories'); // 'categories' é o nome da tabela de categorias
                 $table->timestamps();
             });
         }
     }
     
     
     

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
