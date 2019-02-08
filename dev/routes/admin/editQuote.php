<?php

use App\Filters\AdminFilter;
use App\Filters\UserFilter;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

$app->post("/admin/edit-quote/{id}", function(Request $rq, Response $res, $args){
	/**@var $this \Slim\Container*/
	$id = $args["id"];
	if(is_null($id) || empty($id) || !is_integer($id))
		return $res->withRedirect($this->router->pathFor("admin.dashboard"), StatusCode::HTTP_BAD_REQUEST);

	return $res;
})->setName("admin.editQuote")
	->add(
		UserFilter::from($app->getContainer())
		->composeWith(AdminFilter::from($app->getContainer()))
	);