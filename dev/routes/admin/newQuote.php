<?php

use App\Actions\Flash;
use App\Actions\PostValidator;
use App\Filters\AdminFilter;
use App\Filters\UserFilter;
use App\Models\Quote;
use Slim\Http\Request;
use Slim\Http\Response;

$app->post("/admin/new-quote", function(Request $rq, Response $res){
	/**
	 * @var $this \Slim\Container
	 * @var $validator PostValidator
	 * @var $flash Flash
	 */
	$validator = $this->get(PostValidator::class);
	$flash = $this->get(Flash::class);

	$noMissingFields = $validator->required(["quote"]);
	$router = $this->router;
	$goBack = function(Response $res) use($router): Response{
		return $res->withRedirect($router->pathFor("admin.dashboard"));
	};

	if(!$noMissingFields) {
		$flash->failure("Invalid form");
		return $goBack($res);
	}

	[$quote, $subText] = $validator->getAll([
		"quote" => [],
		"subtext" => []
	]);
	$model = empty($subText) ? Quote::make($quote) : Quote::make($quote, $subText);

	is_null($model)
	? $flash->failure("Failed to add this quote :c")
	: $flash->success("Successfully added this quote!");

	return $goBack($res);
})->setName("admin.newQuote")
->add(
	UserFilter::from($app->getContainer())
	->composeWith(AdminFilter::from($app->getContainer()))
);