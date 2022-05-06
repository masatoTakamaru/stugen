<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory as Faker;

class IndexController extends Controller
{
	/**
	 * Handle the incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */

	 public function __invoke(Request $request)
	{

		$faker = Faker::create('ja_JP');
		return view("home.index")
						->with('name', $faker->name);
	}
}
