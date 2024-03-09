<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accuracy_scores', function (Blueprint $table) {
            $table->renameColumn('admin_flagged', 'is_correct');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accuracy_scores', function (Blueprint $table) {
            $table->renameColumn('is_correct', 'admin_flagged');
        });
    }
};
