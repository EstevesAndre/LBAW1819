<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start_date = '2019-01-01 00:00:00';
        $end_date = '2019-05-01 00:00:00';

        $min = strtotime($start_date);
        $max = strtotime($end_date);

        for($x = 0; $x <= 20; $x++){       

            $val = rand($min, $max);
            $date = new DateTime(date('Y-m-d H:i:s', $val));

            $bool_rand = rand(0,1);
            $boolean = $bool_rand = 1 ? FALSE:FALSE;
            
            $users = DB::select('SELECT id FROM users');
            $user_id = rand(1,count($users));

            DB::table('posts')->insert([
                'date' => $date,
                'content' => Str::random(40),
                'has_img' => $boolean,
                'user_id' => $user_id,
                'clan_id' => NULL,
            ]);
        }
    }
}
