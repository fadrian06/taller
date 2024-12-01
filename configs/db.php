<?php

use Symfony\Component\Dotenv\Dotenv;

(new Dotenv)->load(dirname(__DIR__) . '/.env');

db()->connect(
  $_ENV['DB_HOST'],
  $_ENV['DB_DATABASE'],
  $_ENV['DB_USERNAME'],
  $_ENV['DB_PASSWORD'],
  $_ENV['DB_CONNECTION']
);
