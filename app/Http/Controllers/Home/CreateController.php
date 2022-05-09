<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Home\CreateRequest;
use Faker\Factory as Faker;
use App\Models\FamilyNames;
use App\Models\FirstNameMales;
use App\Models\FirstNameFemales;

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
        $firstNames = Array();
        $familyNames = FamilyNames::all();
        $firstNameMales = FirstNameMales::all();        $firstNameFemales = FirstNameFemales::all();
        $piis = Array();
		for ($i = 1; $i <= $numbers; $i++) {
            $piis[$i]['familyName'] = $familyNames[$i]['family_name'];
            $piis[$i]['familyNameKana'] = $familyNames[$i]['family_name_kana'];
            if(mt_rand(0,1) == 0) {
                $piis[$i]['firstName'] = $firstNameMales[$i]['first_name_male'];
                $piis[$i]['firstNameKana'] = $firstNameMales[$i]['first_name_male_kana'];
            } else {
                $piis[$i]['firstName'] = $firstNameFemales[$i]['first_name_female'];
                $piis[$i]['firstNameKana'] = $firstNameFemales[$i]['first_name_female_kana'];            }
        }
        return view("home.create")->with([
            "numbers" => $numbers,
            "piis" => $piis,
        ]);
    }
}
