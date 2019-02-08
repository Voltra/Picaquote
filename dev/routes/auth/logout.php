<?php

use App\Filters\UserFilter;
use Slim\Http\Request;
use Slim\Http\Response;

$app->get("/logout", function(Request $rq, Response $res){
	/** @var $this \Slim\Container */
})->setName("logout")
->add(UserFilter::from($app->getContainer()));