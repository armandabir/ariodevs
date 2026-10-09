import React from './React';
import Laravel from './Laravel';
import ComputerVision from './ComputerVision';
import VectorSpace from './VectorSpace';

export default function About() {
    return (
        <section id="about" className="section bento-section">
            <div className="container">
                <h2 className="section-title reveal">کشف <span className="gradient-text">دنیای من</span></h2>

                <div className="bento-grid">
                    <div className="bento-box bento-large reveal">
                        <i className="fas fa-quote-right bento-icon-bg"></i>
                        <h3>از اطلاعات تا تجربه‌ی دیجیتال</h3>
                        <p className="text-justify">توسعه‌دهنده فول‌استک وب با ۷ سال تجربه حرفه‌ای. دارای مدرک کارشناسی در مهندسی نرم‌افزار و مهارت بالا در جاوااسکریپت (ES6+)، پی‌اچ‌پی، ری‌اکت و لاراول. تسلط پیشرفته بر زبان انگلیسی برای همکاری در سطح جهانی. سابقه‌ی موفق در اجرای پروژه‌های متعدد فول‌استک، از جمله فروشگاه آنلاین، وب‌سایت‌های شرکتی برای معرفی کسب‌وکار، و سیستم‌های گزارش‌دهی، که نیازهای پیچیده‌ی کسب‌وکار را از سمت کلاینت تا سمت سرور پاسخ داده‌اند.</p>
                    </div>

                    <div className="bento-box bento-medium reveal reveal-delay-1 tech-stack-box">
                        <h3>ابزارهای کلیدی</h3>
                        <div className="tech-tags mt-4">
                            <span>PHP</span>
                            <span>JavaScript(ES6+)</span>
                            <span>SQL</span>
                            <span>Laravel</span>
                            <span>React</span>
                            <span>Tailwind CSS</span>
                        </div>
                    </div>

                    <div className="bento-box bento-small reveal stat-box">
                        <h2 className="stat-number en-text">10+</h2>
                        <p>پروژه</p>
                    </div>
                    <div className="bento-box bento-small reveal stat-box">
                        <h2 className="stat-number en-text">7+</h2>
                        <p>سال تجربه</p>
                    </div>

                    <div className="bento-box bento-large reveal edu-box">
                        <h3>مسیر آکادمیک</h3>
                        <div className="mb-4">
                            <h4 style={{ color: 'var(--accent-1)' }}>کارشناسی کامپیوتر نرم افزار</h4>
                            <p className="edu-uni font-bold">دانشگاه آزاد</p>
                            <p className="text-muted" style={{ fontSize: '0.85rem' }}> </p>
                        </div>
                        <div>
                            <h4 style={{ color: 'var(--accent-2)' }}>مدارک فنی</h4>
                            <p className="edu-uni font-bold">مجتمع فنی تهران</p>
                            <div className="flex flex-col md:flex-row gap-4">

                                <ul dir="ltr" className="flex-1 text-sm list-disc pl-5 text-left">
                                    <li>Cisco CCNA</li>
                                    <li>Microsoft MCSA</li>
                                    <li>Server maintenance courses</li>
                                    <li>Academic advance English language level study</li>
                                </ul>

                                <ul dir="ltr" className="flex-1 text-sm list-disc pl-5 text-left">
                                    <li>Dynamic website makeover with PHP and MySQL</li>
                                    <li>Advanced PHP and MySQL</li>
                                    <li>Web development projects using Laravel and React</li>
                                </ul>

                            </div>
                        </div>
                    </div>

                    <div className="bento-box bento-medium reveal map-box">
                        <div className="map-overlay">
                            <i className="fas fa-map-marker-alt"></i>
                            <p>تهران، ایران<br /><span className="en-text text-sm">Remote Worldwide</span></p>
                        </div>
                    </div>

                    <div className="bento-box bento-small reveal stat-box">
                        <h2 className="stat-number en-text">10+</h2>
                        <p>مشتری راضی</p>
                    </div>
                    <div className="bento-box bento-small reveal stat-box">
                        <h2 className="stat-number en-text">6+</h2>
                        <p>پروژه وب سایت دیپلوی شده</p>
                    </div>

                    <ComputerVision />
                    <React />
                    <Laravel />
                    <VectorSpace />

                    <div className="bento-box bento-medium reveal">
                        <i className="fas fa-heart bento-icon-bg"></i>
                        <h3>خارج از کد</h3>
                        <p className="" style={{ marginBottom: '15px', fontSize: '0.9rem' }}>وقتی پشت لپ‌تاپ نیستم...</p>
                        <div className="tech-tags">
                            <span><i className="fas fa-brain"></i> فلسفه ذهن</span>
                            <span><i className="fas fa-language"></i> زبان انگلیسی</span>
                            <span><i className="fas fa-bicycle"></i> دوچرخه سواری</span>
                            <span><i className="fas fa-microchip"></i> تکنولوژی</span>
                        </div>
                    </div>

                    <div className="bento-box bento-medium reveal">
                        <i className="fas fa-lightbulb bento-icon-bg"></i>
                        <h3>فلسفه کاری من</h3>
                        <p className="" style={{ fontSize: '0.95rem', lineHeight: 1.8 }}>کد خوب فقط کار نمی‌کند؛ ساده، قابل‌فهم و آماده‌ی رشد است.</p>
                    </div>
                </div>
            </div>
        </section>
    );
}
