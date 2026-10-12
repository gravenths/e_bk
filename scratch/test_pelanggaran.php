<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::first();
Illuminate\Support\Facades\Auth::login($user);

$http = $app->make(Illuminate\Contracts\Http\Kernel::class);

$res1 = $http->handle(Illuminate\Http\Request::create('/pelanggaran', 'GET'));
echo "/pelanggaran status: " . $res1->getStatusCode() . PHP_EOL;

$jp = App\Models\JenisPelanggaran::first();
if ($jp) {
    $res2 = $http->handle(Illuminate\Http\Request::create('/pelanggaran/jenis/' . $jp->id . '/edit', 'GET'));
    echo "/pelanggaran/jenis/{$jp->id}/edit status: " . $res2->getStatusCode() . PHP_EOL;
}
