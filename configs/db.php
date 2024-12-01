<?php

use Symfony\Component\Dotenv\Dotenv;

(new Dotenv)->load(APP_DIR . '/.env');
db()->autoConnect();
