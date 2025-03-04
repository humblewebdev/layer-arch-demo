<?php
use Dotenv\Dotenv;

$loader = new \Phalcon\Autoload\Loader();

Dotenv::createImmutable($config->application->baseDir)->load();

$loader->setNamespaces(
    [
        'SmileTrunk\Models' => $config->application->modelsDir,
        'SmileTrunk\Controllers' => $config->application->controllersDir,
        'SmileTrunk\Views' => $config->application->viewsDir,
        'SmileTrunk\Repositories' => $config->application->repositoriesDir,
        'SmileTrunk\Services' => $config->application->servicesDir,
        'SmileTrunk\Clients' => $config->application->clientsDir,
        'SmileTrunk\ValueObjects' => $config->application->valueObjectsDir,
        'SmileTrunk\Exceptions' => $config->application->exceptionsDir,
        'SmileTrunk\Tasks' => $config->application->tasksDir
    ]
)->register();