<?php

use Illuminate\Database\Seeder;

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
            $boolean = $bool_rand = 1 ? TRUE:FALSE;
            
            $num_users = DB::select('SELECT count(*) FROM users');
            $user_id = rand(1,$num_users);

            DB::table('posts')->insert([
                'date' => $date,
                'content' => Str::random(40),
                'hasImg' => $boolean,
                'userID' => $user_id,
                'clanID' => NULL,
            ]);
        }
    }
}
