import React from 'react';

const experiences = [
    {
        date: '۱۴۰۲ - تاکنون',
        title: 'Senior AI Engineer',
        company: 'TechVision AI Lab',
        desc: 'رهبری تیم ۵ نفره برای توسعه یک مدل بینایی ماشین صنعتی. کاهش خطای تولید به میزان ۲۲٪ با استقرار روی لبه (Edge AI). طراحی معماری کامل Pipeline از جمع‌آوری داده تا استقرار روی دستگاه‌های Jetson Nano.',
    },
    {
        date: '۱۴۰۰ - ۱۴۰۲',
        title: 'Machine Learning Engineer',
        company: 'AI Innovators Co',
        desc: 'طراحی و آموزش مدل‌های پردازش زبان طبیعی (NLP) برای تحلیل احساسات مشتریان. یکپارچه‌سازی مدل‌ها با بک‌اند میکروسرویس از طریق FastAPI و Dockerization.',
    },
    {
        date: '۱۳۹۸ - ۱۴۰۰',
        title: 'Data Scientist',
        company: 'DataPulse Inc',
        desc: 'طراحی سیستم Recommendation برای فروشگاه‌های آنلاین و پردازش بیش از ۱۰ میلیون رکورد در روز با PySpark. افزایش ۲۵٪ نرخ تبدیل کاربر به خریدار در اولین ماه استقرار.',
    },
    {
        date: '۱۳۹۷ - ۱۳۹۸',
        title: 'Junior Python Developer',
        company: 'WebTech Studio',
        desc: 'توسعه خزنده‌های وب (Web Scrapers) پیشرفته برای جمع‌آوری داده‌های ساختاریافته. اتوماسیون فرآیندهای دیتابیس و طراحی داشبوردهای تحلیلی با Pandas و Matplotlib.',
    },
    {
        date: '۱۳۹۶ - ۱۳۹۷',
        title: 'Research Assistant',
        company: 'Sharif University Lab',
        desc: 'مشارکت در پژوهش‌های مرتبط با شبکه‌های عصبی کانولوشنال (CNN). جمع‌آوری و پاکسازی دیتاسِت‌های تصویری برای مقالات علمی.',
    },
];

export default function Experience() {
    return (
        <section id="experience" className="section timeline-section">
            <div className="container">
                <h2 className="section-title reveal">مسیر <span className="gradient-text">تکامل</span></h2>

                <div className="timeline">
                    {experiences.map((item) => (
                        <div className="timeline-item reveal" key={item.title}>
                            <div className="timeline-dot"></div>
                            <div className="timeline-content glass-card">
                                <span className="timeline-date">{item.date}</span>
                                <h3 className="timeline-title">{item.title}</h3>
                                <h4 className="timeline-company" style={{ color: 'var(--accent-1)', marginBottom: '10px' }}>{item.company}</h4>
                                <p>{item.desc}</p>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}
