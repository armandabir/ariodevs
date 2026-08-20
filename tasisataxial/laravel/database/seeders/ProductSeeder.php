<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\product;

class ProductSeeder extends Seeder
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

        $pic =["891licensed-image.jpg","79Untitled.jpg","46images.jpg"];
        
        function shuffleArray($array) {
          shuffle($array);
          return $array;
        }

        $newPics = shuffleArray($pic);

        

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

        for ($i = 1; $i <= 8; $i++) {
            $name = $names[array_rand($names)];
        
            
            $items[] = [
                'name' => $name,
                'slug' => trim(preg_replace('/[^\p{L}\p{N}]+/u', '-', $name), '-'),
                'pic' => json_encode($newPics, JSON_UNESCAPED_UNICODE),
                'price' => random_int(10, 1000) * 10000,
                'content' => $contents[array_rand($contents)],
                'publish' => random_int(0, 1),
                'cat_id' => random_int(1, 10),
            ];

    
        }

        foreach($items as $item){
            product::create($item);
        };
    }
}
