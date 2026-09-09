<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $contents = [
            'این محصول با کیفیت مناسب و عملکرد قابل اعتماد، انتخابی کاربردی برای پروژه‌های ساختمانی است.',
            'محصولی بادوام و کاربردی که برای استفاده در پروژه‌های مختلف عمرانی و ساختمانی پیشنهاد می‌شود.',
            'این کالا با طراحی مناسب و کیفیت مطلوب، نیازهای روزمره فعالان حوزه ساخت‌وساز را برطرف می‌کند.',
        ];

        $names = [
            'آجر سفالی',
            'بلوک سیمانی',
            'سیمان سفید',
            'گچ ساختمانی',
            'شن و ماسه',
            'میلگرد فولادی',
            'کاشی سرامیکی',
            'سنگ ساختمانی',
            'رنگ ساختمانی',
            'چسب کاشی',
        ];

         $items = [];

        for ($i = 1; $i <= 30; $i++) {
            $name = $names[array_rand($names)];

            $items[] = [
                'name' => $name,
                'slug' => trim(preg_replace('/[^\p{L}\p{N}]+/u', '-', $name), '-'),
                'pic' => 'products/default.jpg',
                'price' => random_int(100000, 10000000),
                'content' => $contents[array_rand($contents)],
                'publish' => random_int(0, 1),
                'cat_id' => random_int(1, 10),
            ];
        }

          foreach($items as $item){
             prduct::create($item);
          };
    }

  
}
