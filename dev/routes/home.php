<?php

/**
 * @var $app \Slim\App
 */

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

$app->get("/", function(Request $rq, Response $res): ResponseInterface{
	/** @var $this \Slim\Container */

	$quote = "Picarougne";
	return $this->view->render($res, "home.twig", [
		"quote" => $quote
	]);
})->setName("home");