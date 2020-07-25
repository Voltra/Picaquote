<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Quote extends Model{
//	protected $table = "quotes";
	protected $fillable = ["content", "subtext"];

	public static function random(): ?self{
		$count = self::count();
		$id = random_int(1, $count);
		return self::find($id);
	}

	public static function make(string $quote, ?string $subText = null): self{
		$arr = ["content" => $quote];
		if(!is_null($subText))
			$arr["subtext"] = $subText;

		return self::create($arr);
	}

	public static function hasQuoteFor(int $id): bool{
		return !is_null(self::find($id));
	}

	public static function edit(int $id, string $quote, ?string $subText = null): bool{
		if(!self::hasQuoteFor($id))
			return false;

		$arr = [
//			"id" => $id,
			"content" => $quote,
		];

		if(!is_null($subText))
			$arr["subtext"] = $subText;

		return self::where("id", $id)->update($arr);
	}
}