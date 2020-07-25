<?php
namespace App\Middlewares;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;

class CurrentRoute extends Middleware{
	public function process(ServerRequestInterface $rq, Response $res, callable $next): ResponseInterface {
		$this->container["route"] = $rq->getAttribute("route")->getName() ;
		/*if($this->container["route"])
			$this->container["route"] = $this->container["route"]->getName();*/

		$this->container->view["route"] = $this->container["route"];
		return $next($rq, $res);
	}
}