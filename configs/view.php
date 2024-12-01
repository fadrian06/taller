<?php

use Illuminate\Contracts\Foundation\Application as ApplicationContract;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Leaf\Blade;
use SMD\App;

$app = App::getInstance();
$app->bind(ApplicationContract::class, App::class);
$app->alias('view', ViewFactory::class);

app()->register('blade', static fn(): Blade => new Blade(
  APP_DIR . '/resources/views',
  APP_DIR . '/storage/cache',
  $app
));
