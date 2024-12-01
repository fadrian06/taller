<?php

use Symfony\Component\Dotenv\Dotenv;

(new Dotenv)->load('.env');
db()->autoConnect();
