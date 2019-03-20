<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

// Register middleware for all routes
// If you are implementing per-route checks you must not add this
$app->add($container->get('csrf'));
