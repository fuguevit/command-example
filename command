#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Fuguevit\Command\CodeLineCounter;
use Fuguevit\Command\OssUploader;

$app = new Application;
$app->add(new CodeLineCounter);
$app->add(new OssUploader);
$app->run();


