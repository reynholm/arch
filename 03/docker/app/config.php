<?php

$config = [];

$config['db']['dsn'] = $_ENV['DATABASE_DSN'];
$config['db']['username'] = $_ENV['DATABASE_USERNAME'];
$config['db']['password'] = $_ENV['DATABASE_PASSWORD'];

return $config;