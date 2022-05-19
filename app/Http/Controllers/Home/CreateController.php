<?php

namespace App\Http\Controllers\Home;

use DateTime;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Home\CreateRequest;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Faker\Factory as Faker;
use App\Models\FamilyNames;
use App\Models\FirstNameMales;
use App\Models\FirstNameFemales;
use App\Models\Address;
use App\Models\Nursery;
use App\Models\Elem;
use App\Models\Middle;
use App\Models\High;
use App\Models\Univ;

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
        date_default_timezone_set('Asia/Tokyo');

        $numbers = $request->input('numbers'); //人数
        $prefs = Array();
        $prefs = $request->input('prefs'); //都道府県名
        $gradeNames = Array();
        $gradeNames = $request->input('gradeNames'); //学年名
        $piis = Array(); //個人情報をまとめた配列
		for($i = 1; $i <= $numbers; $i++) {
            $piis[$i]['name'] = $this->getName();
            $piis[$i]['address'] = $this->getAddress($prefs);
            $piis[$i]['phone1'] = $this->getPhone1($piis[$i]['address']);
            $piis[$i]['phone2'] = $this->getPhone2();
            $piis[$i]['gradeName'] = $this->getGradeName($gradeNames);
            $piis[$i]['birthDate'] = $this->getBirthDate($piis[$i]['gradeName']);
            $piis[$i]['schoolName'] = $this->getSchoolName($piis[$i]['address'], $piis[$i]['gradeName']);
            $piis[$i]['username'] = $this->getUserName();
            $piis[$i]['password'] = $this->getPassword();
            $piis[$i]['email'] = $this->getEmail();
        }
        return $this->download($piis);
    }

    private function download($data)
    {
        $response = new StreamedResponse(function () use ($data) {
            $stream = fopen('php://output', 'w');
            $head = [
                '姓', '名', '姓フリガナ', '名フリガナ',
                '学年','生年月日','学校名',
                '郵便番号', '都道府県', '市区町村', 'その他', '番地等',
                '電話番号', '携帯電話番号',
                'ユーザー名','パスワード','メールアドレス',
            ];
            mb_convert_variables('SJIS-win', 'UTF-8', $head);
            fputcsv($stream, $head);
            if($data)
            {
                foreach($data as $row) {
                    mb_convert_variables('SJIS-win', 'UTF-8', $row);
                    fputcsv($stream, [
                        $row['name']['familyName'],
                        $row['name']['firstName'],
                        $row['name']['familyNameKana'],
                        $row['name']['firstNameKana'],
                        $row['gradeName'],
                        $row['birthDate']->format('Y-m-d'),
                        $row['schoolName'],
                        $row['address']['zip'],
                        $row['address']['pref'],
                        $row['address']['city'],
                        $row['address']['st'],
                        $row['address']['block'],
                        $row['phone1'],
                        $row['phone2'],
                        $row['username'],
                        $row['password'],
                        $row['email'],
                    ]);
                }
            }
            fclose($stream);
        },
        \Illuminate\Http\Response::HTTP_OK,
        [
            'Content-Type'=>'text/csv',
            'Content-Disposition'=>'attachment; filename=students_list.csv',
        ]
        );
        return $response;
    }

    private function getName()
    {
        //姓，男性名，女性名はテーブルから全取得してランダム
        //に抽出する。
        $lastNames = Array();
        $firstNames = Array();
        $firstNameMales = FirstNameMales::all(); //男性名
        $firstNameFemales = FirstNameFemales::all(); //女性名
        $familyNames = FamilyNames::all(); //姓
        $n = mt_rand(1, count($familyNames) - 1);
        //姓
        $e['familyName'] = $familyNames[$n]['family_name'];
        $e['familyNameKana'] = $familyNames[$n]['family_name_kana'];
        //名
        if(mt_rand(0,1) == 0) {
            $n = mt_rand(0, count($firstNameMales) - 1);
            $e['firstName'] = $firstNameMales[$n]['first_name_male'];
            $e['firstNameKana'] = $firstNameMales[$n]['first_name_male_kana'];
        } else {
            $n = mt_rand(0, count($firstNameFemales) - 1);
            $e['firstName'] = $firstNameFemales[$n]['first_name_female'];
            $e['firstNameKana'] = $firstNameFemales[$n]['first_name_female_kana'];
        }
        return $e;
    }

    private function getAddress($prefs)
    {
        //住所は選択された都道府県名をもとに，テーブルから
        //その都道府県内の住所をランダムに1件抽出する。
        if($prefs == null) {
            $address = Address::inRandomOrder()->first();
        } else {
            $address = Address::where('pref', $prefs[mt_rand(0, count($prefs) - 1)])->inRandomOrder()->first();
        }
        $e['zip'] = $address['zip']; //郵便番号
        $e['pref'] = $address['pref']; //都道府県
        $e['city'] = $address['city']; //郡市町村
        $e['st'] = $address['st']; //町名
        $e['ac'] = $address['ac']; //市外局番
        //1/4の確率で地番XXXX
        //3/4の確率で地番X-XX-XXの形式とする
        if(mt_rand(0,3) == 0){
            $e['block'] = strval(mt_rand(10,2000));
        } else {
            $e['block'] = strval(mt_rand(1,9)) . '-' . strval(mt_rand(1,19)) . '-' . strval(mt_rand(1,30));
        }
        //1/3の確率で建物名を加える(fakerで生成)
        $faker = Faker::create('ja_JP');
        if(mt_rand(0,2) == 0) {
            $e['block'] = $e['block'] . $faker->secondaryAddress();
        }
        return $e;
    }

    private function getPhone1($address)
    {
        //電話番号
        //市外局番のケタ数によって市内局番のケタ数を決定する

        //市外局番の先頭に0を追加
        $ac = '0' . strval($address['ac']);
        switch(mb_strlen($ac)) {
            case 2:
                //XX-XXXX-XXXX
                $str = $ac . '-' . str_pad(mt_rand(1,9999), 4, '0', STR_PAD_LEFT) . '-' . str_pad(mt_rand(1,9999), 4, '0', STR_PAD_LEFT);
                break;
            case 3:
                //XXX-XXX-XXXXX
                $str = $ac . '-' . str_pad(mt_rand(1,999), 3, '0', STR_PAD_LEFT) . '-' . str_pad(mt_rand(1,9999), 4, '0', STR_PAD_LEFT);
                break;
            case 4:
                //XXXX-XX-XXXX
                $str = $ac . '-' . str_pad(mt_rand(1,99), 2, '0', STR_PAD_LEFT) . '-' . str_pad(mt_rand(1,9999), 4, '0', STR_PAD_LEFT);
                break;
            case 5:
                //XXXXX-X-XXXX
                $str = $ac . '-' . str_pad(mt_rand(1,9), 1, '0', STR_PAD_LEFT) . '-' . str_pad(mt_rand(1,9999), 4, '0', STR_PAD_LEFT);
                break;                                
        }
        return $str;
    }

    private function getPhone2()
    {
        //携帯電話番号
        //070-XXXX-XXXX 080-XXXX-XXXX 090-XXXX-XXXX
        //のいずれか
        return '0' . strval(mt_rand(7,9)) . '0-' . strval(mt_rand(1000,9999)) . '-' . strval(mt_rand(1000,9999));
    }

    private function getGradeName($gradeNames)
    {
        //学年未選択の場合は全学年
        if($gradeNames == null) {
            $gradeNames = $this->gradeNames;
        }
        return $gradeNames[mt_rand(0, count($gradeNames) - 1)];
    }

    private function getBirthDate($gradeName)
    {
        //生年月日
        //選択された学年の要素番号を取得
        $n = array_search($gradeName, $this->gradeNames);
        //いったん年度初めの日付を取得する
        //$date = new Carbon('today');
        $date = new Carbon('2022-05-01');
        if ($date->month <= 3) {
            $date->subYear();
        }
        if ($n == 0) {
            $e = new Carbon(strval($date->year - mt_rand(0, 3)) . '-04-02');
        } else {
            $e = new Carbon(strval($date->year - $n - 3) . '-04-02');
        }
        //年度初めから日付をランダムに加算して生年月日とする
        $birthDate = $e->addDay(mt_rand(0,364));
        return $birthDate;
        
    }

    private function getSchoolName($address, $gradeName)
    {
        //選択された学年の要素番号を取得
        $n = array_search($gradeName, $this->gradeNames);
        switch($n) {
            case 0:
                $e = '';
                break;
            case $n >= 1 && $n <= 3:
                $e = Nursery::wherePref($address['pref'])
                    ->where('city', 'LIKE', "%{$address['city']}%")
                    ->inRandomOrder()
                    ->first();
                break;
            case $n >= 4 && $n <= 9:
                $e = Elem::wherePref($address['pref'])
                    ->where('city', 'LIKE', "%{$address['city']}%")
                    ->inRandomOrder()
                    ->first();
                break;
            case $n >= 10 && $n <= 12:
                $e = Middle::wherePref($address['pref'])
                    ->where('city', 'LIKE', "%{$address['city']}%")
                    ->inRandomOrder()
                    ->first();
                break;
            case $n >= 13 && $n <= 15:
                $e = High::wherePref($address['pref'])
                    ->inRandomOrder()
                    ->first();
                break;
            case $n >= 16 && $n <= 19:
                $e = Univ::wherePref($address['pref'])
                    ->inRandomOrder()
                    ->first();
                break;
        }
        if($e == null) {
            return "";
        } else {
            return $e['name'];
        }
    }

    private function getUserName()
    {
        $faker = Faker::create('en_US');
        $e = $faker->userName();
        return $e;
    }

    private function getEmail()
    {
        $faker = Faker::create('ja_JP');
        $str = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $e = "";
        $r = mt_rand(7, 12);
        for($i = 0; $i <= $r; $i++) {
            $e = $e . substr($str,mt_rand(0, strlen($str) - 1), 1);
        }
        $e = $e . '@' . $faker->safeEmailDomain();
        return $e;        
    }

    private function getPassword()
    {
        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $e = "";
        $r = mt_rand(8, 10);
        for($i = 0; $i <= $r; $i++) {
            $e = $e . substr($str,mt_rand(0, strlen($str) - 1), 1);
        }
        return $e;        
    }
}
