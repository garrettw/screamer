<?php
require_once 'vendor/autoload.php';

use Dice\Dice;

$dicConfig = @include 'dic-config.php';
$dic = (new Dice())->addRules($dicConfig);

$app = $dic->create(Screamer\App::class);
$app();
