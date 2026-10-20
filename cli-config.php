<?php

use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

$entityManager = require_once __DIR__ . '/config/doctrine.php';

return new SingleManagerProvider($entityManager);