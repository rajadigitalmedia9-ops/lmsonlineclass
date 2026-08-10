<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Livewire\Admin\LiveClasses;
use Livewire\Livewire;

try {
    Livewire::test(LiveClasses::class)
        ->call('create')
        ->assertSet('showModal', true);
        
    echo "SUCCESS: Component rendered without errors.\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
