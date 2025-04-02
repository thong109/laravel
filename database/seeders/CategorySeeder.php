<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $categories = [
            [
                'name' => 'Điện thoại',
                'slug' => Str::slug('Điện thoại'),
                'image' => $faker->imageUrl(640, 480, 'technics', true), // Fake image URL
                'status' => 1,
            ],
            [
                'name' => 'Máy tính',
                'slug' => Str::slug('Máy tính'),
                'image' => $faker->imageUrl(640, 480, 'technics', true),
                'status' => 1,
            ],
            [
                'name' => 'Thời trang nam',
                'slug' => Str::slug('Thời trang nam'),
                'image' => $faker->imageUrl(640, 480, 'fashion', true),
                'status' => 1,
            ],
            [
                'name' => 'Thời trang nữ',
                'slug' => Str::slug('Thời trang nữ'),
                'image' => $faker->imageUrl(640, 480, 'fashion', true),
                'status' => 1,
            ],
            [
                'name' => 'Đồ gia dụng',
                'slug' => Str::slug('Đồ gia dụng'),
                'image' => $faker->imageUrl(640, 480, 'appliance', true),
                'status' => 1,
            ],
            [
                'name' => 'Sách',
                'slug' => Str::slug('Sách'),
                'image' => $faker->imageUrl(640, 480, 'books', true),
                'status' => 1,
            ],
            [
                'name' => 'Thể thao',
                'slug' => Str::slug('Thể thao'),
                'image' => $faker->imageUrl(640, 480, 'sports', true),
                'status' => 1,
            ],
            [
                'name' => 'Đồ chơi',
                'slug' => Str::slug('Đồ chơi'),
                'image' => $faker->imageUrl(640, 480, 'toys', true),
                'status' => 1,
            ],
            [
                'name' => 'Mỹ phẩm',
                'slug' => Str::slug('Mỹ phẩm'),
                'image' => $faker->imageUrl(640, 480, 'beauty', true),
                'status' => 1,
            ],
            [
                'name' => 'Ô tô, xe máy',
                'slug' => Str::slug('Ô tô, xe máy'),
                'image' => $faker->imageUrl(640, 480, 'transport', true),
                'status' => 1,
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}
