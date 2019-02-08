<?php
/**
 * Created by PhpStorm.
 * User: Ludwig
 * Date: 08/02/2019
 * Time: 20:28
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Quote extends Model{
//	protected $table = "quotes";
	protected $fillable = ["content"];

	public static function random(): ?self{
		$count = self::count();
		$id = random_int(0, $count);
		return self::find($id);
	}

	public static function make(string $quote): self{
		return self::create([
			"content" => $quote
		]);
	}
}