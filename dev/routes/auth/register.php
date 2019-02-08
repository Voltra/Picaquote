<?php

use App\Filters\VisitorFilter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App as SlimApp;


/**@var SlimApp $app*/
$app->get("/register", function(ServerRequestInterface $rq, ResponseInterface $res): ResponseInterface{
	/**@var \Slim\Container $this*/
	return $this->view->render($res, "auth/register.twig", []);
})->setName("register")
->add(VisitorFilter::from($app->getContainer()));