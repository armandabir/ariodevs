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
                        <h3>تلفیق داده‌ها و هنر</h3>
                        <p>بیش از ۵ سال است که در مرزهای هوش مصنوعی قدم می‌زنم. من معتقدم کدهای تمیز و معماری شبکه‌های عصبی عمیق، هنر دنیای مدرن هستند. هدف من ساخت محصولاتی است که زندگی انسان‌ها را هوشمندتر کند. از آزمایشگاه‌های تحقیقاتی تا محیط‌های Production واقعی، همیشه دنبال راه‌حل‌هایی بوده‌ام که هم از نظر علمی محکم باشند و هم از نظر مهندسی قابل اتکا.</p>
                    </div>

                    <div className="bento-box bento-medium reveal reveal-delay-1 tech-stack-box">
                        <h3>ابزارهای کلیدی</h3>
                        <div className="tech-tags mt-4">
                            <span>PyTorch</span>
                            <span>TensorFlow</span>
                            <span>Python</span>
                            <span>LangChain</span>
                            <span>Docker</span>
                            <span>FastAPI</span>
                        </div>
                    </div>

                    <div className="bento-box bento-small reveal stat-box">
                        <h2 className="stat-number en-text">۴۰+</h2>
                        <p>پروژه</p>
                    </div>
                    <div className="bento-box bento-small reveal stat-box">
                        <h2 className="stat-number en-text">۵+</h2>
                        <p>سال تجربه</p>
                    </div>

                    <div className="bento-box bento-large reveal edu-box">
                        <i className="fas fa-graduation-cap bento-icon"></i>
                        <h3>مسیر آکادمیک</h3>
                        <div className="mb-4">
                            <h4 style={{ color: 'var(--accent-1)' }}>کارشناسی ارشد هوش مصنوعی</h4>
                            <p className="edu-uni font-bold">دانشگاه صنعتی شریف</p>
                            <p className="text-muted" style={{ fontSize: '0.85rem' }}>پایان‌نامه: بهینه‌سازی مدل‌های زبانی بزرگ با LoRA.</p>
                        </div>
                        <div>
                            <h4 style={{ color: 'var(--accent-2)' }}>کارشناسی مهندسی کامپیوتر</h4>
                            <p className="edu-uni font-bold">دانشگاه صنعتی اصفهان</p>
                            <p className="text-muted" style={{ fontSize: '0.85rem' }}>پروژه پایانی: تشخیص ناهنجاری در ترافیک شبکه با استفاده از یادگیری ماشین.</p>
                        </div>
                    </div>

                    <div className="bento-box bento-medium reveal map-box">
                        <div className="map-overlay">
                            <i className="fas fa-map-marker-alt"></i>
                            <p>تهران، ایران<br /><span className="en-text text-sm">Remote Worldwide</span></p>
                        </div>
                    </div>

                    <div className="bento-box bento-small reveal stat-box">
                        <h2 className="stat-number en-text">۲۰+</h2>
                        <p>مشتری راضی</p>
                    </div>
                    <div className="bento-box bento-small reveal stat-box">
                        <h2 className="stat-number en-text">۱۵+</h2>
                        <p>مدل دیپلوی شده</p>
                    </div>

                    <ComputerVision />
                    <React />
                    <Laravel />
                    <VectorSpace />

                    <div className="bento-box bento-medium reveal">
                        <i className="fas fa-heart bento-icon-bg"></i>
                        <h3>خارج از کد</h3>
                        <p className="text-muted" style={{ marginBottom: '15px', fontSize: '0.9rem' }}>وقتی پشت لپ‌تاپ نیستم...</p>
                        <div className="tech-tags">
                            <span><i className="fas fa-book-open text-muted"></i> فلسفه ذهن</span>
                            <span><i className="fas fa-guitar text-muted"></i> گیتار</span>
                            <span><i className="fas fa-mountain text-muted"></i> کوهنوردی</span>
                            <span><i className="fas fa-chess-knight text-muted"></i> شطرنج</span>
                        </div>
                    </div>

                    <div className="bento-box bento-medium reveal">
                        <i className="fas fa-lightbulb bento-icon-bg"></i>
                        <h3>فلسفه کاری من</h3>
                        <p className="text-muted" style={{ fontSize: '0.95rem', lineHeight: 1.8 }}>"هوش مصنوعی خوب، هوشی است که انسان را قوی‌تر کند، نه جایگزین او شود. من برای این هدف کد می‌نویسم."</p>
                    </div>
                </div>
            </div>
        </section>
    );
}
