<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmContactLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_contact_logins', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id')->unsigned()->index();
            $table->integer('contact_id')->unsigned()->index();
            $table->string('username')->unique();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('password');
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->integer('created_by')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
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
        Schema::dropIfExists('crm_contact_logins');
    }
}
