<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id')->unsigned()->index();
            $table->string('title');
            $table->enum('contact_type', ['lead', 'customer', 'supplier'])->default('lead');
            $table->unsignedBigInteger('lead_id')->nullable()->index();
            $table->integer('contact_id')->unsigned()->nullable()->index();
            $table->enum('status', ['scheduled', 'open', 'completed', 'cancelled'])->default('scheduled');
            $table->datetime('start_datetime');
            $table->datetime('end_datetime')->nullable();
            $table->text('description')->nullable();
            $table->enum('followup_type', ['call', 'email', 'meeting', 'sms', 'other'])->default('call');
            $table->integer('assigned_to')->unsigned()->nullable()->index();
            $table->boolean('send_notification')->default(false);
            $table->boolean('is_recurring')->default(false);
            $table->enum('recurrence_type', ['daily', 'weekly', 'monthly', 'yearly'])->nullable();
            $table->integer('recurrence_interval')->nullable();
            $table->date('recurrence_end_date')->nullable();
            $table->unsignedBigInteger('parent_schedule_id')->nullable();
            $table->enum('followup_category', ['one_time', 'recurring', 'invoice_based'])->default('one_time');
            $table->enum('invoice_status', ['pending', 'partial', 'overdue'])->nullable();
            $table->text('notes')->nullable();
            $table->integer('created_by')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->foreign('lead_id')->references('id')->on('crm_leads')->onDelete('cascade');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
            $table->foreign('parent_schedule_id')->references('id')->on('crm_schedules')->onDelete('cascade');
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
        Schema::dropIfExists('crm_schedules');
    }
}
