<?php

use App\Filters\AdminFilter;
use App\Filters\UserFilter;
use Slim\Http\Request;
use Slim\Http\Response;

$app->get("/admin", function(Request $rq, Response $res){
	/** @var $this \Slim\Container */
})->setName("admin.dashboard")
->add(
	UserFilter::from($app->getContainer())
	->composeWith(AdminFilter::from($app->getContainer()))
);