<?php

namespace Database\Seeders;

use App\Models\Publication;
use Illuminate\Database\Seeder;

class PublicationSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['https://www.triboon.net/blog/22681/core-web-vitals/', 'fas fa-gauge-high', 'Core Web Vitals چیست؟ نحوه بهینه‌سازی و تأثیر آن بر سئو', 'وبلاگ تریبون', 'سرعت و عملکرد وب', 'معرفی شاخص‌های تجربه کاربری گوگل (LCP، INP و CLS)، تأثیر آن‌ها بر رتبه سایت و روش‌های عملی برای بهبود سرعت بارگذاری و پایداری صفحه.'],
            ['https://webdaran.com/what-is-site-responsive-2/', 'fas fa-mobile-screen-button', 'طراحی سایت ریسپانسیو چیست؟ راهنمای کامل', 'وب داران', 'توسعه وب', 'اصول طراحی سایت واکنش‌گرا برای نمایش درست در موبایل، تبلت و دسکتاپ و اثر آن بر تجربه کاربری و سئوی موبایل.'],
            ['https://roocket.ir/articles/react-crash-course-how-it-works/', 'fab fa-react', 'مقدمه‌ای بر React و نحوه عملکرد آن', 'راکت', 'فرانت‌اند', 'آشنایی با مفاهیم پایه React، کامپوننت‌ها و روش کار این کتابخانه برای ساخت رابط‌های کاربری مدرن.'],
            ['https://roocket.ir/skills/laravel/', 'fab fa-laravel', 'آموزش لاراول؛ مسیر یادگیری فریمورک Laravel', 'راکت', 'بک‌اند', 'مسیر یادگیری فریمورک لاراول برای ساخت وب‌سایت و API با PHP، همراه با آموزش‌های مرحله‌به‌مرحله.'],
            ['https://blog.faradars.org/rest-چیست/', 'fas fa-plug', 'REST چیست؟ همه چیز درباره RESTful API به زبان ساده', 'مجله فرادرس', 'طراحی API', 'توضیح ساده معماری REST، اصول طراحی وب‌سرویس‌ها و نحوه ارتباط فرانت‌اند و بک‌اند از طریق API.'],
            ['https://mihanwp.com/ai-content-seo-effect/', 'fas fa-robot', 'تأثیر تولید محتوا با هوش مصنوعی روی سئوی سایت', 'میهن وردپرس', 'سئو و هوش مصنوعی', 'بررسی اینکه استفاده از هوش مصنوعی در تولید محتوا چه تأثیری بر سئو دارد و چگونه می‌توان از آن بدون افت کیفیت استفاده کرد.'],
        ];

        // Inserted in reverse so the first article in the list gets the highest id and shows first.
        foreach (array_reverse($items) as [$url, $icon, $title, $venue, $category, $description]) {
            Publication::updateOrCreate(
                ['url_hash' => hash('sha256', $url)],
                compact('url', 'icon', 'title', 'venue', 'category') + ['description' => $description]
            );
        }
    }
}
