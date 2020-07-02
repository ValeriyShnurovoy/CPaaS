<?php
declare(strict_types = 1);

require_once __DIR__.'/vendor/autoload.php';

use Cpaas\Processor;

$eachTimer = time();
$eachMaeker = true;

while($eachMaeker) {

    if (time() - $eachTimer >= 600) {
        $eachTimer = time();
        Processor::run();
    }

}