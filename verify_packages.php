
use App\Models\Package;
$packages = Package::all();
foreach($packages as $p) {
    $subCount = $p->subscription()->count();
    print "ID: " . $p->id . " | Name: " . $p->name . " | Subs: " . $subCount . "
";
}
