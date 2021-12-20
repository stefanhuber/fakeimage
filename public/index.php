<?php

require_once __DIR__ . '/../vendor/autoload.php';

const CACHED_DIR = __DIR__ . '/cached/';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use FakeImage\FakeImage;
use FakeImage\Generators\RandomImageGenerator;

$app = AppFactory::create();

$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, false, false);

function loadFakeImage(int $width, int $height, string $extension, int $tile=5): string {
    $random = rand(1, 20);
    $extension = strtolower($extension);
    $filename = "random-$random-{$width}x{$height}x{$tile}.$extension";

    if (!file_exists(CACHED_DIR . $filename)) {
        FakeImage::create($width, $height, new RandomImageGenerator($tile))
            ->generate()
            ->save(CACHED_DIR . $filename);
    }

    return file_get_contents(CACHED_DIR . $filename);
}

$app->get('/random-{width:\d+}.{extension:(?i)png|jpg|jpeg|gif}', function (Request $request, Response $response, $args) {
    $response->getBody()->write(loadFakeImage($args['width'], $args['width'], $args['extension']));
    return $response->withHeader("Content-Type", "image/" . strtolower($args['extension']));
});

$app->get('/random-{width:\d+}x{height:\d+}.{extension:(?i)png|jpg|jpeg|gif}', function (Request $request, Response $response, $args) {
    $response->getBody()->write(loadFakeImage($args['width'], $args['height'], $args['extension']));
    return $response->withHeader("Content-Type", "image/" . strtolower($args['extension']));
});

$app->get('/random-{width:\d+}x{height:\d+}x{tile:\d+}.{extension:(?i)png|jpg|jpeg|gif}', function (Request $request, Response $response, $args) {
    $response->getBody()->write(loadFakeImage($args['width'], $args['height'], $args['extension'], $args['tile']));
    return $response->withHeader("Content-Type", "image/" . strtolower($args['extension']));
});

$app->run();
