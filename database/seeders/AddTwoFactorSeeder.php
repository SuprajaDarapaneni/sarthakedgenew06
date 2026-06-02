<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class AddTwoFactorSeeder extends Seeder
{
    public function run()
    {
        if (!Schema::hasColumn('users', 'two_factor_secret')) {
            Schema::table('users', function (Blueprint $table) {
                $table->tinyInteger('two_factor_enabled')->default(1)->nullable();
                $table->string('two_factor_secret')->nullable();
                $table->string('two_factor_expires_at')->nullable();
            });
        }
    }
}
