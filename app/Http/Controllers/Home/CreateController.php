<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Home\CreateRequest;
use Faker\Factory as Faker;
use App\Models\FamilyNames;
use App\Models\FirstNameMales;
use App\Models\FirstNameFemales;
use App\Models\Address;

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
        $prefs = Array();
        $prefs = $request->input('prefs');
        $faker = Faker::create('ja_JP');
        $lastNames = Array();
        $firstNames = Array();
        $familyNames = FamilyNames::all();
        $firstNameMales = FirstNameMales::all();        $firstNameFemales = FirstNameFemales::all();
        $address = Array();
        $piis = Array();
		for($i = 1; $i <= $numbers; $i++) {
            $n = mt_rand(1, count($familyNames) - 1);
            //名字
            $piis[$i]['familyName'] = $familyNames[$n]['family_name'];
            $piis[$i]['familyNameKana'] = $familyNames[$n]['family_name_kana'];
            //名
            if(mt_rand(0,1) == 0) {
                $n = mt_rand(0, count($firstNameMales) - 1);
                $piis[$i]['firstName'] = $firstNameMales[$n]['first_name_male'];
                $piis[$i]['firstNameKana'] = $firstNameMales[$n]['first_name_male_kana'];
            } else {
                $n = mt_rand(0, count($firstNameFemales) - 1);
                $piis[$i]['firstName'] = $firstNameFemales[$n]['first_name_female'];
                $piis[$i]['firstNameKana'] = $firstNameFemales[$n]['first_name_female_kana'];
            }
            //住所
            if($prefs == null) {
                $address = Address::inRandomOrder()->first();
            } else {
                $address = Address::where('pref', $prefs[mt_rand(0, count($prefs) - 1)])->inRandomOrder()->first();
            }
            $piis[$i]['zip'] = $address['zip'];
            $piis[$i]['pref'] = $address['pref'];
            $piis[$i]['city'] = $address['city'];
            $piis[$i]['st'] = $address['st'];
            if(mt_rand(0,3) == 0){
                $piis[$i]['block'] = strval(mt_rand(10,2000));
            } else {
                $piis[$i]['block'] = strval(mt_rand(1,9)) . '-' . strval(mt_rand(1,19)) . '-' . strval(mt_rand(1,30));
            }
            if(mt_rand(0,2) == 0){
                $piis[$i]['block'] = $piis[$i]['block'] . $faker->secondaryAddress();
            }
            //電話番号
            $ac = "0" . strval($address['ac']);
            switch(mb_strlen($ac)) {
                case 2:
                    $phone1 = $ac . "-" . str_pad(mt_rand(1,9999), 4, '0', STR_PAD_LEFT) . "-" . str_pad(mt_rand(1,9999), 4, '0', STR_PAD_LEFT);
                    break;
                case 3:
                    $phone1 = $ac . "-" . str_pad(mt_rand(1,999), 3, '0', STR_PAD_LEFT) . "-" . str_pad(mt_rand(1,9999), 4, '0', STR_PAD_LEFT);
                    break;
                case 4:
                    $phone1 = $ac . "-" . str_pad(mt_rand(1,99), 2, '0', STR_PAD_LEFT) . "-" . str_pad(mt_rand(1,9999), 4, '0', STR_PAD_LEFT);
                    break;
                case 5:
                    $phone1 = $ac . "-" . str_pad(mt_rand(1,9), 1, '0', STR_PAD_LEFT) . "-" . str_pad(mt_rand(1,9999), 4, '0', STR_PAD_LEFT);
                    break;                                
            }
            $piis[$i]['phone1'] = $phone1;
            //携帯電話番号
            $phone2 = "0" . strval(mt_rand(7,9)) . "0-" . strval(mt_rand(1000,9999)) . "-" . strval(mt_rand(1000,9999));
            $piis[$i]['phone2'] = $phone2;
        }
        return view("home.create")->with([
            "numbers" => $numbers,
            "piis" => $piis,
        ]);
    }
}
