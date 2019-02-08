<?php

use App\Filters\LogoutFilter;
use App\Filters\UserFilter;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App as SlimApp;
use Slim\Http\Response;
use Slim\Http\StatusCode;


/**@var SlimApp $app*/
$app->get("/logout", function(ServerRequestInterface $rq, Response $res): Response{
	/**@var \Slim\Container $this*/
	/**@var \App\Actions\Flash $flash*/
	$flash = $this->get(\App\Actions\Flash::class);
	/**@var \App\Actions\Auth $auth*/
	$auth = $this->get(\App\Actions\Auth::class);
	/**@var Response $response*/
	$response = $auth->logout($res);

	$flash->success("Successfully logged out");
	return $response->withRedirect($this->router->pathFor("home"));
})->setName("logout")
->add(LogoutFilter::from($app->getContainer()));