<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Doctrine\ORM\Tools\SchemaTool;

$entityManager = require_once __DIR__ . '/../../config/doctrine.php';

echo "DB Migrate\n";

try {
    $schemaTool = new SchemaTool($entityManager);
    $classes = $entityManager->getMetadataFactory()->getAllMetadata();

    $schemaTool->updateSchema($classes);
    
    echo "Sucesso!\n";
} catch (\Exception $e) {
    echo "Erro ao atualizar o banco: " . $e->getMessage() . "\n";
}