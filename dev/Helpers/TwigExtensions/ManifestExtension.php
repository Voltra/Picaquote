<?php
/**
 * Created by PhpStorm.
 * User: Ludwig
 * Date: 09/02/2019
 * Time: 13:15
 */

namespace App\Helpers\TwigExtensions;


use Slim\Container;

class ManifestExtension extends \Twig_Extension{
	/**
	 * @var $manifest array
	 * @var $routeName string
	 */
	protected $manifest;
//	protected $routeName;

	public function __construct(Container $c) {
		$this->manifest = $c->get("manifest");
//		$this->routeName = $c->get("route");
	}

	protected function transcodeName(string $routeName){
		return str_replace(".", "/", $routeName) . ".js";
	}

	public function getEntry(string $routeName): string{
		return $this->manifest[$this->transcodeName($routeName)];
	}

	/*public function getCurrentEntry(): string{
		return $this->getEntry($this->routeName);
	}*/

	public function getFunctions() {
		return [
			new \Twig_SimpleFunction("manifest_entry", [$this, "getEntry"]),
//			new \Twig_SimpleFunction("manifest_js", [$this, "getCurrentEntry"]),
		];
	}
}