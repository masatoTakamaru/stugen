<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("Addressの作成を開始します...");
        $addressSplFileObject = new \SplFileObject(__DIR__ . '/csv/ken_all.csv');
        $addressSplFileObject->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );
        $count = 0;
        foreach($addressSplFileObject as $key=>$row) {
            DB::table('address')->insert([
                'zip'=>trim($row[0]),
                'pref'=>trim($row[1]),
                'city'=>trim($row[2]),
                'st'=>trim($row[3]),
                'ac'=>trim($row[4]),
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
            $count++;
        }
        $this->command->info("Addressを{$count}件作成しました。");
    }
}
