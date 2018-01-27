<?php

/** @var Nette\DI\Container $container */
$container = require __DIR__ . '/../app/bootstrap.php';

// Get application from DI container.
$application = $container->getByType(Contributte\Console\Application::class);

// Run application.
exit($application->run());
