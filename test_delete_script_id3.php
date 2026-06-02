<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Package;

$user = User::whereHas('roles', function($q) { $q->where('name', 'Super Admin'); })->first();
if ($user) {
    Auth::login($user);
    $package = Package::find(3); // Pro package ID
    if ($package) {
        try {
            echo "Package Found: " . $package->id . " Name: " . $package->name . "\n";
            $res = app(App\Http\Controllers\PackageController::class)->destroy($package->id);
            echo "RESULT: " . json_encode($res) . "\n";
        } catch (Throwable $e) {
            echo "EXCEPTION: " . $e->getMessage() . "\n";
            echo "TRACE: " . $e->getTraceAsString() . "\n";
        }
    } else {
        echo "No package available with ID 3.\n";
    }
} else {
    echo "No Super Admin found.\n";
}
