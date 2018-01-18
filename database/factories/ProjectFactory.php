<?php

use Faker\Generator as Faker;

$factory->define(\App\Model\Project\Project::class, function (Faker $faker) {
    return [
        'village'           => $faker->unique()->randomElement(['连河','横岗','东光','冲溪',
        											   '安溪','丰城','安全','望月',
        											   '龙颈','石窝','白云','梯岭',
        											   '鹤坑','桃源','圆溪','下圆',
        											   '红裕','扬芬','樟木','曲溪',
        											   '洋溪','黄金','瓜塘','莲塘']),
        'category'          => $faker->randomElement(['入户路','卫生厕','文化室','卫生室','通组公路','排水沟']),
        'name'              => $faker->name,
        'year' => $faker->randomElement(['2017','2014','2015','2016']),
    ];
});
