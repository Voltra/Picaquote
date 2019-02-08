<?php


use App\Filters\VisitorFilter;
use Slim\Http\Request;
use Slim\Http\Response;

$app->get("/login", function(Request $rq, Response $res){
	/** @var $this \Slim\Container */
})->setName("login")
->add(VisitorFilter::from($app->getContainer()));

$app->post("/login", function(Request $rq, Response $res){
	/** @var $this \Slim\Container */
})->setName("login.post")
->add(VisitorFilter::from($app->getContainer()));