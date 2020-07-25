<?php

use App\Actions\Flash;
use App\Actions\PostValidator;
use App\Filters\AdminFilter;
use App\Filters\UserFilter;
use App\Models\Quote;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

$app->post("/admin/edit-quote/{id}", function(Request $rq, Response $res, $args){
	/**
	 * @var $this \Slim\Container
	 * @var $validator PostValidator
	 * @var $flash Flash
	 */
	$router = $this->router;
	$flash = $this->get(Flash::class);
	$goBack = function(Response $res) use($router){
		return $res->withRedirect($router->pathFor("admin.dashboard"));
	};

	$id = $args["id"];
	if(is_null($id) || empty($id) || !is_integer($id + 0)) {
		$flash->failure("Invalid ID");
		return $goBack($res);
	}

	$qid = intval($id);
	$validator = $this->get(PostValidator::class);
	$noMissingFields = $validator->required(["quote"]);

	if(!$noMissingFields) {
		$flash->failure("Invalid form");
		return $goBack($res);
	}

	if(!Quote::hasQuoteFor($qid)){
		$flash->failure("There is no such quote for #{$qid}");
		return $goBack($res);
	}

	[$quote, $subText] = $validator->getAll([
		"quote" => [],
		"subtext" => []
	]);

	(empty($subText) ? Quote::edit($qid, $quote) : Quote::edit($qid, $quote, $subText))
	? $flash->success("Successfully edited quote #{$qid}")
	: $flash->failure("Couldn't edit quote #{$qid}");

	return $goBack($res);
})->setName("admin.editQuote")
->add(
	UserFilter::from($app->getContainer())
	->composeWith(AdminFilter::from($app->getContainer()))
);