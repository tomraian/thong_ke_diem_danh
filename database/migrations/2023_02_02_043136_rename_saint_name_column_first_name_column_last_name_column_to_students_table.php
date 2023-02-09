<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameSaintNameColumnFirstNameColumnLastNameColumnToStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->renameColumn('saint_name', 'tenthanh');
            $table->renameColumn('first_name', 'ho');
            $table->renameColumn('last_name', 'ten');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->renameColumn('tenthanh', 'saint_name');
            $table->renameColumn('ho', 'first_name');
            $table->renameColumn('ten', 'last_name');
        });
    }
}
