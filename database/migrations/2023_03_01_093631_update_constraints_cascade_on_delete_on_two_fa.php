<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateConstraintsCascadeOnDeleteOnTwoFa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nova_twofa', function (Blueprint $table) {
            $table->dropForeign('nova_twofa_user_id_foreign');
            $table->foreign('user_id')
                ->references(config('nova-two-factor.user_id_column'))
                ->on(config('nova-two-factor.user_table'))
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nova_twofa', function (Blueprint $table) {
            $table->dropForeign('nova_twofa_user_id_foreign');
            $table->foreign('user_id')
                ->references(config('nova-two-factor.user_id_column'))
                ->on(config('nova-two-factor.user_table'));
        });
    }
}
