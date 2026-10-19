#!/bin/sh

composer install --no-interaction

# verifica se o banco já subiu pra subir as tabelas
echo "Aguardando o banco de dados MySQL iniciar..."
php -r "

\$ready = false; \$maxTries = 3;
while (!\$ready && \$maxTries > 0) {
    try {
        new PDO('mysql:host=db;dbname=php_crud_agenda', 'root', 'root');
        \$ready = true;
        echo \"Banco de dados conectado com sucesso!\n\";
    } catch (Exception \$e) {
        \$maxTries--;
        sleep(5);
    }
}
"

# cria/atualiza os esquemas do banco
php app/Commands/db_migrate.php

# inicia o server PHP-FPM
php-fpm