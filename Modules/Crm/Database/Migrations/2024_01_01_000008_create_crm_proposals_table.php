<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_proposals', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id')->unsigned()->index();
            $table->unsignedBigInteger('lead_id')->index();
            $table->unsignedBigInteger('template_id')->nullable();
            $table->string('subject');
            $table->longText('body');
            $table->text('attachments')->nullable();
            $table->enum('status', ['draft', 'sent', 'viewed', 'accepted', 'rejected'])->default('draft');
            $table->datetime('sent_at')->nullable();
            $table->datetime('viewed_at')->nullable();
            $table->datetime('responded_at')->nullable();
            $table->text('response_notes')->nullable();
            $table->integer('created_by')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->foreign('lead_id')->references('id')->on('crm_leads')->onDelete('cascade');
            $table->foreign('template_id')->references('id')->on('crm_proposal_templates')->onDelete('set null');
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
        Schema::dropIfExists('crm_proposals');
    }
}
