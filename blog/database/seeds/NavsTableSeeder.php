<?php

use Illuminate\Database\Seeder;

class NavsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'nav_name' => '后盾网',
                'nav_title' => '国内口碑最好的PHP培训机构',
                'nav_url' => 'http://www.houdunwang.com',
                'nav_order' => '1',
            ],
            [
                'nav_name' => '后盾论坛',
                'nav_title' => '后盾网,人人做后盾',
                'nav_url' => 'http://bbs.houdunwang.com',
                'nav_order' => '2',
            ],
        ];
        DB::table('navs')->insert($data);
    }
}
