<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\category;
class productcatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
                 $categories = [
                [
                    'name' => 'مصالح عایق‌کاری',
                    'description' => 'انواع محصولات و مصالح مورد استفاده برای عایق‌کاری حرارتی، صوتی و رطوبتی ساختمان.',
                    'maincat_id' => 2,
                    'parent_id' => rand(1, 10),
                ],
                [
                    'name' => 'چسب و مواد آب‌بندی',
                    'description' => 'انواع چسب‌های ساختمانی، مواد آب‌بندی و محصولات مورد استفاده در اجرای ساختمان.',
                    'maincat_id' => 2,
                    'parent_id' => rand(1, 10),
                ],
                [
                    'name' => 'داربست و تجهیزات کارگاهی',
                    'description' => 'انواع داربست، تجهیزات کارگاهی و ملزومات مورد نیاز برای اجرای پروژه‌های ساختمانی.',
                    'maincat_id' => 2,
                    'parent_id' => rand(1, 10),
                ],
                [
                    'name' => 'ماشین‌آلات ساختمانی',
                    'description' => 'انواع ماشین‌آلات و تجهیزات مکانیکی مورد استفاده در پروژه‌های ساختمانی و عمرانی.',
                    'maincat_id' => 2,
                    'parent_id' => rand(1, 10),
                ],
                [
                    'name' => 'ابزارآلات برقی',
                    'description' => 'انواع ابزارهای برقی مانند دریل، فرز، بتن‌کن و سایر تجهیزات مورد نیاز ساختمان‌سازی.',
                    'maincat_id' => 2,
                    'parent_id' => rand(1, 10),
                ],
                [
                    'name' => 'ابزارآلات دستی',
                    'description' => 'انواع ابزارهای دستی شامل چکش، آچار، پیچ‌گوشتی و تجهیزات مورد نیاز کارگاه.',
                    'maincat_id' => 2,
                    'parent_id' => rand(1, 10),
                ],
                [
                    'name' => 'تجهیزات تهویه و سرمایش',
                    'description' => 'انواع تجهیزات تهویه، کولر و سیستم‌های سرمایشی مناسب برای ساختمان‌های مسکونی و تجاری.',
                    'maincat_id' => 2,
                    'parent_id' => rand(1, 10),
                ],
                [
                    'name' => 'تجهیزات گرمایشی',
                    'description' => 'انواع سیستم‌ها و تجهیزات گرمایشی مناسب برای تأمین گرمای ساختمان.',
                    'maincat_id' => 2,
                    'parent_id' => rand(1, 10),
                ],
                [
                    'name' => 'محصولات چوبی و دکوراسیون',
                    'description' => 'انواع محصولات چوبی، صفحات ساختمانی و تجهیزات مورد استفاده در دکوراسیون داخلی.',
                    'maincat_id' => 2,
                    'parent_id' => rand(1, 10),
                ],
                [
                    'name' => 'تجهیزات و لوازم آتش‌نشانی',
                    'description' => 'انواع تجهیزات ایمنی و محصولات مورد استفاده برای حفاظت ساختمان در برابر آتش‌سوزی.',
                    'maincat_id' => 2,
                    'parent_id' => rand(1, 10),
                ],
            
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }


    }
}
