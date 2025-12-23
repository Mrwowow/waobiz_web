<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_leads', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id')->unsigned()->index();
            $table->string('contact_id_prefix')->nullable();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('alternate_number')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();
            $table->text('address')->nullable();
            $table->unsignedBigInteger('source_id')->nullable()->index();
            $table->unsignedBigInteger('life_stage_id')->nullable()->index();
            $table->integer('assigned_to')->unsigned()->nullable()->index();
            $table->text('additional_info')->nullable();
            $table->string('custom_field_1')->nullable();
            $table->string('custom_field_2')->nullable();
            $table->string('custom_field_3')->nullable();
            $table->string('custom_field_4')->nullable();
            $table->integer('converted_contact_id')->unsigned()->nullable();
            $table->timestamp('converted_at')->nullable();
            $table->integer('converted_by')->unsigned()->nullable();
            $table->integer('created_by')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->foreign('source_id')->references('id')->on('crm_sources')->onDelete('set null');
            $table->foreign('life_stage_id')->references('id')->on('crm_life_stages')->onDelete('set null');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
            $table->foreign('converted_contact_id')->references('id')->on('contacts')->onDelete('set null');
            $table->foreign('converted_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crm_leads');
    }
}
