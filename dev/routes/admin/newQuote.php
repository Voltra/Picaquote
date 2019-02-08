<?php

use App\Filters\AdminFilter;
use App\Filters\UserFilter;
use Slim\Http\Request;
use Slim\Http\Response;

$app->post("/admin/new-quote", function(Request $rq, Response $res){
	/**@var $this \Slim\Container*/
	return $res;
})->setName("admin.newQuote")
->add(
	UserFilter::from($app->getContainer())
	->composeWith(AdminFilter::from($app->getContainer()))
);