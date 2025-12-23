<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_campaigns', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id')->unsigned()->index();
            $table->string('name');
            $table->enum('campaign_type', ['email', 'sms'])->default('email');
            $table->string('subject')->nullable();
            $table->text('body')->nullable();
            $table->text('attachments')->nullable();
            $table->json('recipients')->nullable();
            $table->enum('recipient_type', ['all_customers', 'all_suppliers', 'all_leads', 'selected'])->default('selected');
            $table->enum('status', ['draft', 'scheduled', 'sent', 'failed'])->default('draft');
            $table->datetime('scheduled_at')->nullable();
            $table->datetime('sent_at')->nullable();
            $table->integer('total_sent')->default(0);
            $table->integer('total_failed')->default(0);
            $table->integer('created_by')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
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
        Schema::dropIfExists('crm_campaigns');
    }
}
