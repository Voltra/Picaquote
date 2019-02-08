<?php

use App\Actions\PostValidator;
use App\Filters\VisitorFilter;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App as SlimApp;
use Slim\Http\Response;
use Slim\Http\StatusCode;


/**@var SlimApp $app*/
$app->post("/login", function(ServerRequestInterface $rq, Response $res): Response{
	/**
	 * @var \Slim\Container $this
	 * @var PostValidator $validator
	 */
	$validator = $this->get(PostValidator::class);
	$noMissingFields = $validator->required(["username", "password"]);
	$router = $this->router;
	$goBack = function(Response $res) use($router): Response{
		return $res->withRedirect($router->pathFor("login"));
	};

	if(!$noMissingFields)
		return $goBack($res);


	[$username, $password, $remember] = $validator->getAll([
		"username" => [],
		"password" => [],
		"remember" => ["type" => "bool", "default" => false]
	]);

	/**@var \App\Actions\Flash $flash*/
	$flash = $this->get(\App\Actions\Flash::class);
	/**@var \App\Actions\Auth $auth*/
	$auth = $this->get(\App\Actions\Auth::class);

	/**@var Response $response*/
	$response = $auth->login($res, $username, $password, $remember)->response;

	if(!$auth->isLoggedIn()) {
		$flash->failure("Invalid credentials");
		return $goBack($response);
	}

	$flash->success("Successfully logged in");
	return $response->withRedirect($router->pathFor("home"));
})->setName("login.post")
->add(VisitorFilter::from($app->getContainer()));