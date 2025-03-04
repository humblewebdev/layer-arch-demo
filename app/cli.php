<?php

declare(strict_types=1);
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
require_once BASE_PATH . '/vendor/autoload.php';

use Dotenv\Dotenv;
use GuzzleHttp\Client;
use Phalcon\Autoload\Loader;
use Phalcon\Cli\Console;
use Phalcon\Cli\Dispatcher;
use Phalcon\Cli\Console\Exception as PhalconException;
use Phalcon\Di\FactoryDefault\Cli as CliDI;
use SmileTrunk\Clients\Mattermost;
use SmileTrunk\Repositories\UserRepository;
use SmileTrunk\Services\UserCreationSyncService;

$container  = new CliDI();
$dispatcher = new Dispatcher();

$dispatcher->setDefaultNamespace('SmileTrunk\Tasks');
$container->setShared('dispatcher', $dispatcher);

$container->setShared('config', function () {
    return include 'app/config/config.php';
});

$container->set(
    'mattermostClient',
    function () {
        return new Client(
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $_ENV['MATTERMOST_TOKEN']
                ]
            ]
        );
    }
);

$container->set(
    Mattermost::class,
    [
        'className' => Mattermost::class,
        'arguments' => [
            [
                'type' => 'service',
                'name' => 'mattermostClient'
            ]
        ]
    ]
);

$container->setShared('db', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset
    ];

    if ($config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    return new $class($params);
});

$container->set(
    UserRepository::class,
    [
        'className' => UserRepository::class
    ]
);

$container->set(
    UserCreationSyncService::class,
    [
        'className' => UserCreationSyncService::class,
        'arguments' => [
            [
                'type' => 'service',
                'name' => Mattermost::class
            ],
            [
                'type' => 'service',
                'name' => UserRepository::class
            ]
        ]
    ]
);


$config = $container->get('config');

Dotenv::createImmutable($config->application->baseDir)->load();

$loader = new Loader();
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
);
$loader->register();

$console = new Console($container);

$arguments = [];
foreach ($argv as $k => $arg) {
    if ($k === 1) {
        $arguments['task'] = $arg;
    } elseif ($k === 2) {
        $arguments['action'] = $arg;
    } elseif ($k >= 3) {
        $arguments['params'][] = $arg;
    }
}

try {
    $console->handle($arguments);
} catch (PhalconException $e) {
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
} catch (Throwable $throwable) {
    fwrite(STDERR, $throwable->getMessage() . PHP_EOL);
    exit(1);
} catch (Exception $exception) {
    fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    exit(1);
}