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
    $packages = Package::all();
    $html = view('package.index', compact('packages'))->render();
    echo $html;
} else {
    echo "No Super Admin found.\n";
}
