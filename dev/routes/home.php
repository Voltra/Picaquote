<?php

/**
 * @var $app \Slim\App
 */

use App\Models\Quote;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

$app->get("/", function(Request $rq, Response $res): ResponseInterface{
	/** @var $this \Slim\Container */

	$quote = "Picarougne";
	return $this->view->render($res, "home.twig", [
		"quote" => Quote::random() ?? "Whoops"
	]);
})->setName("home");