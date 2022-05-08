<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Home\CreateRequest;
use Faker\Factory as Faker;

class CreateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CreateRequest $request)
    {
        $numbers = $request->input('numbers');
        $faker = Faker::create('ja_JP');
        $lastNames = Array();
        $firstNameMales = Array();
		for ($i = 1; $i <= $numbers; $i++) {
            $lastNames[] = $faker->lastName;
            $firstNameMales[] = $faker->firstNameMale;
        }
        return view("home.create")->with([
            "numbers" => $numbers,
            "lastNames" => $lastNames,
            "firstNameMales" => $firstNameMales
        ]);
    }
}
