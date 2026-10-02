import React from 'react';

const publications = [
    {
        icon: 'fas fa-file-pdf',
        title: 'بهینه‌سازی مدل‌های زبانی بزرگ با استفاده از تطبیق‌پذیری رتبه-پایین (LoRA) برای دستگاه‌های لبه',
        venue: 'نشریه تراکنش‌های شبکه‌های عصبی IEEE',
        date: 'آبان ۱۴۰۴',
        desc: 'این مقاله روشی نوین برای کاهش مصرف حافظه در هنگام Fine-tune کردن مدل‌های زبانی با پارامتر بالا روی دستگاه‌های لبه (IoT) پیشنهاد می‌دهد که باعث کاهش ۶۰ درصدی مصرف VRAM می‌شود.',
        delay: '',
    },
    {
        icon: 'fas fa-file-alt',
        title: 'تشخیص بلادرنگ ناهنجاری در تولید صنعتی با استفاده از ترانسفورمرهای بینایی',
        venue: 'کنفرانس بین‌المللی CVPR ۱۴۰۳ ',
        venueIcon: 'fas fa-globe',
        date: 'خرداد ۱۴۰۳',
        desc: 'معرفی یک معماری هیبریدی بر پایه ViT و CNN برای تشخیص بلادرنگ نقص‌های تولیدی در خطوط مونتاژ با نرخ فریم بالا و دقت ۹۹.۲ درصد.',
        delay: 'reveal-delay-1',
    },
    {
        icon: 'fas fa-newspaper',
        title: 'یادگیری تقویتی عمیق برای کنترل پویای چراغ‌های راهنمایی',
        venue: 'ژورنال اینترنت اشیاء IEEE',
        date: 'دی ۱۴۰۱',
        desc: 'یک چارچوب مبتنی بر یادگیری تقویتی عمیق (DQN) برای زمان‌بندی هوشمند چراغ‌های راهنمایی شهری که منجر به کاهش ۳۰ درصدی زمان انتظار در تقاطع‌های شلوغ شد.',
        delay: 'reveal-delay-2',
    },
];

export default function Publications() {
    return (
        <section id="publications" className="section publications-section">
            <div className="container">
                <h2 className="section-title reveal">مقالات و <span className="gradient-text">پژوهش‌ها</span></h2>
                <p className="section-subtitle reveal text-muted">مشارکت‌های علمی در معتبرترین ژورنال‌ها و کنفرانس‌های بین‌المللی</p>

                <div className="publications-list">
                    {publications.map((pub) => (
                        <div className={`publication-card reveal ${pub.delay}`} key={pub.title}>
                            <i className={`${pub.icon} pub-icon`}></i>
                            <div className="pub-content">
                                <h3 className="pub-title">{pub.title}</h3>
                                <div className="pub-meta">
                                    <span className="en-text"><i className={pub.venueIcon || 'fas fa-book'}></i> {pub.venue}</span>
                                    <span><i className="far fa-calendar-alt"></i> {pub.date}</span>
                                </div>
                                <p className="pub-desc">{pub.desc}</p>
                                <a href="./publication-lora.html" className="btn btn-glow mt-4" style={{ padding: '8px 16px', fontSize: '0.85rem' }}>مشاهده مقاله <i className="fas fa-external-link-alt"></i></a>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}
