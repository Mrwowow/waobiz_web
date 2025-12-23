<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_configurations', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id')->unique();
            $table->string('store_name', 255)->unique();
            $table->string('business_name', 255);
            $table->text('logo')->nullable();
            $table->text('banner')->nullable();
            $table->string('theme_color', 7)->default('#f97316');
            $table->string('whatsapp_number', 20)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->text('description')->nullable();
            $table->string('currency', 3)->default('NGN');
            $table->string('opening_hours', 50)->nullable();
            $table->string('closing_hours', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('social_media')->nullable();
            $table->json('payment_methods')->nullable();
            $table->json('delivery_options')->nullable();
            $table->text('custom_css')->nullable();
            $table->string('seo_title', 255)->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('store_name');
            $table->index('is_active');
            $table->index('business_id');

            // Foreign key (optional, uncomment if you want to enforce relationship)
            // $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_configurations');
    }
}
