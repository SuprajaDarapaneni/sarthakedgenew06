<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;

// Select current school context tenant or loop over all databases
try {
    // Loop over ALL schools from main database to create table in their tenant databases
    DB::setDefaultConnection('mysql'); // Switch to main database
    $schools = DB::table('schools')->where('status', 1)->get();
    
    foreach ($schools as $school) {
        $db_name = $school->database_name;
        if (empty($db_name)) {
            continue;
        }

        try {
            // Dynamically reconnect
            Config::set('database.connections.tenant', [
                'driver' => 'mysql',
                'host' => env('DB_HOST'),
                'port' => env('DB_PORT'),
                'database' => $db_name,
                'username' => env('DB_USERNAME'),
                'password' => env('DB_PASSWORD'),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ]);

            DB::purge('tenant');
            DB::setDefaultConnection('tenant');

            if (!Schema::hasTable('tasks')) {
                Schema::create('tasks', function (Blueprint $table) {
                    $table->id();
                    $table->integer('school_id')->nullable();
                    $table->string('title');
                    $table->text('description')->nullable();
                    $table->boolean('status')->default(0); // 0 = Pending, 1 = Completed
                    $table->string('priority')->default('medium'); // low, medium, high
                    $table->timestamp('created_at')->nullable();
                    $table->timestamp('updated_at')->nullable();
                });
                echo "Table 'tasks' created on db: $db_name\n";
            } else {
                echo "Table 'tasks' already exists on db: $db_name\n";
            }

        } catch (\Exception $e) {
             echo "Error on db $db_name: " . $e->getMessage() . "\n";
        }
    }

} catch (\Exception $e) {
    echo "General Error: " . $e->getMessage() . "\n";
}
