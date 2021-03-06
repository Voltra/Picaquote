<?php

use App\Filters\UserFilter;
use App\Filters\AdminFilter;
use App\Models\Quote;
use App\Models\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App as SlimApp;


/**@var SlimApp $app*/
$app->get("/admin", function(ServerRequestInterface $rq, ResponseInterface $res): ResponseInterface{
	/**
	 * @var \Slim\Container $this
	 * @var User $user
	 */
	$user = $this->get("user");
	$quotes = Quote::all();
	return $this->view->render($res, "admin/dashboard.twig", [
		"user" => $user,
		"quotes" => $quotes
	]);
})->setName("admin.dashboard")
->add(
	UserFilter::from($app->getContainer())
	->composeWith(AdminFilter::from($app->getContainer()))
);