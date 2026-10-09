import React from 'react';
import styles from '../../css/styles/Publications.module.scss';

const publications = [
    {
        icon: 'fas fa-gauge-high',
        title: 'Core Web Vitals چیست؟ نحوه بهینه‌سازی و تأثیر آن بر سئو',
        venue: 'وبلاگ تریبون',
        category: 'سرعت و عملکرد وب',
        desc: 'معرفی شاخص‌های تجربه کاربری گوگل (LCP، INP و CLS)، تأثیر آن‌ها بر رتبه سایت و روش‌های عملی برای بهبود سرعت بارگذاری و پایداری صفحه.',
        url: 'https://www.triboon.net/blog/22681/core-web-vitals/',
        delay: '',
    },
    {
        icon: 'fas fa-mobile-screen-button',
        title: 'طراحی سایت ریسپانسیو چیست؟ راهنمای کامل',
        venue: 'وب داران',
        category: 'توسعه وب',
        desc: 'اصول طراحی سایت واکنش‌گرا برای نمایش درست در موبایل، تبلت و دسکتاپ و اثر آن بر تجربه کاربری و سئوی موبایل.',
        url: 'https://webdaran.com/what-is-site-responsive-2/',
        delay: 'reveal-delay-1',
    },
    {
        icon: 'fab fa-react',
        title: 'مقدمه‌ای بر React و نحوه عملکرد آن',
        venue: 'راکت',
        category: 'فرانت‌اند',
        desc: 'آشنایی با مفاهیم پایه React، کامپوننت‌ها و روش کار این کتابخانه برای ساخت رابط‌های کاربری مدرن.',
        url: 'https://roocket.ir/articles/react-crash-course-how-it-works/',
        delay: 'reveal-delay-2',
    },
    {
        icon: 'fab fa-laravel',
        title: 'آموزش لاراول؛ مسیر یادگیری فریمورک Laravel',
        venue: 'راکت',
        category: 'بک‌اند',
        desc: 'مسیر یادگیری فریمورک لاراول برای ساخت وب‌سایت و API با PHP، همراه با آموزش‌های مرحله‌به‌مرحله.',
        url: 'https://roocket.ir/skills/laravel/',
        delay: '',
    },
    {
        icon: 'fas fa-plug',
        title: 'REST چیست؟ همه چیز درباره RESTful API به زبان ساده',
        venue: 'مجله فرادرس',
        category: 'طراحی API',
        desc: 'توضیح ساده معماری REST، اصول طراحی وب‌سرویس‌ها و نحوه ارتباط فرانت‌اند و بک‌اند از طریق API.',
        url: 'https://blog.faradars.org/rest-چیست/',
        delay: 'reveal-delay-1',
    },
    {
        icon: 'fas fa-robot',
        title: 'تأثیر تولید محتوا با هوش مصنوعی روی سئوی سایت',
        venue: 'میهن وردپرس',
        category: 'سئو و هوش مصنوعی',
        desc: 'بررسی اینکه استفاده از هوش مصنوعی در تولید محتوا چه تأثیری بر سئو دارد و چگونه می‌توان از آن بدون افت کیفیت استفاده کرد.',
        url: 'https://mihanwp.com/ai-content-seo-effect/',
        delay: 'reveal-delay-2',
    },
];

export default function Publications() {
    return (
        <section id="publications" className="section publications-section">
            <div className="container">
                <h2 className="section-title reveal">مقالات و <span className="gradient-text">راهنماها</span></h2>
                <p className="section-subtitle reveal text-muted">منابع منتخب فارسی درباره توسعه وب، فرانت‌اند، بک‌اند و بهینه‌سازی سایت</p>

                <div className={styles.publicationsList}>
                    {publications.map((pub) => (
                        <div className={`${styles.publicationCard} reveal ${pub.delay}`} key={pub.url}>
                            <i className={`${pub.icon} ${styles.pubIcon}`} aria-hidden="true"></i>
                            <div className={styles.pubContent}>
                                <h3 className={styles.pubTitle}>{pub.title}</h3>
                                <div className={styles.pubMeta}>
                                    <span><i className="fas fa-globe" aria-hidden="true"></i> {pub.venue}</span>
                                    <span><i className="fas fa-tag" aria-hidden="true"></i> {pub.category}</span>
                                </div>
                                <p className={styles.pubDesc}>{pub.desc}</p>
                                <a href={pub.url} target="_blank" rel="noopener noreferrer" className={`btn btn-glow ${styles.pubBtn}`}>
                                    مطالعه مقاله <i className="fas fa-arrow-up-right-from-square " aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}
