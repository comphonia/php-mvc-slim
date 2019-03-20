<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->map(['GET', 'POST'], '/contact', function (Request $request, Response $response, array $args) {
    if ($request->getMethod() == "POST") {
        $args = array_merge($args, $request->getParsedBody());
        // validation
        if (!empty($args['name']) && !empty($args['email']) && !empty($args['msg'])) {
            $mail = json_encode([$args['name'], $args['email'], $args['msg']]);
            $this->logger->notice($mail);
            //  return $this->renderer->render($response,'thankyou.phtml',$args);
            $url = $this->router->pathFor('thankyou');
            return $response->withStatus(302)->withHeader('Location', $url);
        }
        $args['error'] = "all fields required";
    }

    //csrf
    $nameKey = $this->csrf->getTokenNameKey();
    $valueKey = $this->csrf->getTokenValueKey();
    $args['csrf'] = [
    $nameKey => $request->getAttribute($nameKey),
    $valueKey => $request->getAttribute($valueKey)
    ];
    // Render index view
    return $this->renderer->render($response, 'contact-form.phtml', $args);
});

$app->get('/contact/thankyou', function (Request $request, Response $response, array $args) {

    // Render index view
    return $this->renderer->render($response, 'thankyou.phtml', $args);
})->setName('thankyou');

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'about.phtml', $args);
});
