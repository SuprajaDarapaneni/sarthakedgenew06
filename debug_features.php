<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Services\FeaturesService;
use Illuminate\Support\Facades\Auth;

$user = User::where('email', 'saisuppu1@gmail.com')->first();
Auth::login($user);

echo "User ID: " . $user->id . "\n";
echo "School ID: " . $user->school_id . "\n";

$features = FeaturesService::getFeatures();
echo "Features Count: " . count($features) . "\n";
echo "Features List: " . implode(', ', $features) . "\n";

$testFeature = 'Timetable Management';
echo "Has '$testFeature': " . (FeaturesService::hasFeature($testFeature) ? 'YES' : 'NO') . "\n";
