<?php


use App\Helpers\Path;
use Slim\Container;

return function(Container $c){
	return json_decode(
		file_get_contents(Path::public("/assets/js/manifest.json")),
		true
	);
};