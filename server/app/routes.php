<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/airports', function (Request $request, Response $response) {
  try {
    $payload = json_decode(file_get_contents(AIRPORTS_FILE));
    $response->getBody()->write(json_encode($payload));

    return $response
      ->withHeader('Content-Type', 'application/json')
      ->withStatus(200);
  } catch (Exception $e) {
    error_log($e->getMessage());

    return $response->withStatus(500);
  }
});

$app->get('/cheapest_flight/{departure}/{arrival}', function (Request $request, Response $response, array $args) {
  try {
    $cheapest_flight_combination = get_cheapest_flight($args['departure'], $args['arrival']);
    $response->getBody()->write(json_encode($cheapest_flight_combination));

    return $response
      ->withHeader('Content-Type', 'application/json')
      ->withStatus(200);
  } catch (Exception $e) {
    error_log($e->getMessage());

    return $response->withStatus(500);
  }
});
