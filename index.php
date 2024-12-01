<?php

const APP_DIR = __DIR__;

require 'vendor/autoload.php';
require 'configs/db.php';
require 'configs/view.php';

echo app()->blade->render('login');
