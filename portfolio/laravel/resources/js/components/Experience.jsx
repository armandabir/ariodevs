import React from 'react';
import styles from '../../css/styles/Experience.module.scss';

const experiences = [
    {
        date: '۷+ سال تجربه',
        title: 'توسعه‌دهنده فول‌استک وب',
        company: 'توسعه وب و نرم‌افزار',
        desc: 'توسعه پروژه‌های فول‌استک از رابط کاربری تا سمت سرور با JavaScript (ES6+)، PHP، React و Laravel؛ از جمله فروشگاه‌های آنلاین، وب‌سایت‌های شرکتی و سیستم‌های گزارش‌دهی.',
    },
    {
        date: '۱۱+ پروژه',
        title: 'پروژه‌های فول‌استک',
        company: 'فروشگاه آنلاین، وب‌سایت شرکتی و گزارش‌دهی',
        desc: 'اجرای پروژه‌های متعدد برای پاسخ‌گویی به نیازهای کسب‌وکار، با پیاده‌سازی قابلیت‌ها در سمت کلاینت و سرور.',
    },
    {
        date: '10+ وب‌سایت دیپلوی‌شده',
        title: 'توسعه و استقرار وب‌سایت',
        company: 'بیش از ۱۰ مشتری راضی',
        desc: 'طراحی و توسعه وب‌سایت‌های کاربردی برای معرفی کسب‌وکارها و ارائه تجربه‌ای کامل از رابط کاربری تا بک‌اند.',
    },
    {
        date: '۲ سال تا امروز',
        title: 'توانایی زبان انگلیسی',
        company: 'مطالعه آکادمیک ',
        desc: 'با دو سال یادگیری زبان انگلیسی تا امروز، توانایی من در درک و استفاده از این زبان تقویت شده است.',
    },
    {
        date: 'مدارک و دوره‌های فنی',
        title: 'آموزش‌های تخصصی',
        company: 'مجتمع فنی تهران',
        desc: 'گذراندن دوره‌های Cisco CCNA، Microsoft MCSA، نگهداری سرور، PHP و MySQL، و توسعه وب با Laravel و React.',
    },
];

export default function Experience() {
    return (
        <section id="experience" className="section timeline-section">
            <div className="container">
                <h2 className="section-title reveal">مسیر <span className="gradient-text">تکامل</span></h2>

                <div className={styles.timeline}>
                    {experiences.map((item) => (
                        <div className={`${styles.timelineItem} reveal`} key={item.title}>
                            <div className={styles.timelineDot}></div>
                            <div className={`${styles.timelineContent} glass-card`}>
                                <span className={styles.timelineDate}>{item.date}</span>
                                <h3 className={styles.timelineTitle}>{item.title}</h3>
                                <h4 className={styles.timelineCompany}>{item.company}</h4>
                                <p>{item.desc}</p>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}
