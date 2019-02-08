<?php

use App\Actions\PostValidator;
use App\Filters\VisitorFilter;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App as SlimApp;
use Slim\Http\Response;
use Slim\Http\StatusCode;


/**@var SlimApp $app*/
$app->post("/register", function(ServerRequestInterface $rq, Response $res): Response{
	/**
	 * @var \Slim\Container $this
	 * @var PostValidator $validator
	 */
	$validator = $this->get(PostValidator::class);
	$noMissingFields = $validator->required(["username", "password", "pconfirm"]);
	$router = $this->router;
	$goBack = function(Response $res/*, $status*/) use($router): Response{
		return $res->withRedirect($router->pathFor("register")/*, $status*/);
	};

	if(!$noMissingFields)
		return $goBack($res/*, StatusCode::HTTP_BAD_REQUEST*/);

	[$username, $password, $confirm, $remember] = $validator->getAll([
		"username" => [],
		"password" => [],
		"pconfirm" => [],
		"remember" => ["type" => "bool", "default" => false]
	]);

	/**@var \App\Actions\Flash $flash*/
	$flash = $this->get(\App\Actions\Flash::class);
	if($password !== $confirm){
		$flash->failure("Passwords don't match");
		return $goBack($res/*, StatusCode::HTTP_CONFLICT*/);
	}

	/**@var \App\Actions\Auth $auth*/
	$auth = $this->get(\App\Actions\Auth::class);
	$response = $auth->register($res, $username, $password, $remember)->response;

	if(!$auth->isLoggedIn()){
		$flash->failure("Failed to register, username might be taken");
		return $goBack($response/*, StatusCode::HTTP_CONFLICT*/);
	}

	$flash->success("Successfully registered, you have been automatically logged in");
	return $response->withRedirect($router->pathFor("home"));
})->setName("register.post")
->add(VisitorFilter::from($app->getContainer()));