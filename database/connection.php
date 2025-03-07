<?php

function getDatabaseConnection(): PDO
{
    $config = include __DIR__ . "/settings.php";

    return new PDO(
        "{$config['databaseDialect']}:host={$config['databaseHostname']};port={$config['databasePort']};dbname={$config['databaseName']}",
        $config['databaseUsername'],
        $config['databasePassword']
    );
}
