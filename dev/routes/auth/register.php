<?php

use App\Filters\VisitorFilter;
use Slim\Http\Request;
use Slim\Http\Response;

$app->get("/register", function(Request $rq, Response $res){
	/** @var $this \Slim\Container */
})->setName("register")
->add(VisitorFilter::from($app->getContainer()));

$app->post("/register", function(Request $rq, Response $res){
	/** @var $this \Slim\Container */
})->setName("register.post")
->add(VisitorFilter::from($app->getContainer()));