import React from 'react';
import { motion } from 'motion/react';
import ReactComponent from './React';
import Laravel from './Laravel';
import ComputerVision from './ComputerVision';
import VectorSpace from './VectorSpace';
import styles from '../../css/styles/About.module.scss';
import { useLocale } from '../lib/LocaleContext';

const cardMotionProps = {
    whileHover: {
        x: -4,
        y: -4,
        transition: { type: 'spring', stiffness: 400, damping: 25 }
    },
    whileTap: {
        x: 2,
        y: 2,
        transition: { type: 'spring', stiffness: 500, damping: 30 }
    }
};

export default function About() {
    const { t } = useLocale();
    return (
        <section id="about" className={`section bento-section ${styles.bentoSection}`}>
            <div className="container">
                <div className="section-tag mb-4">
                    <span>01 / PLAYER PROFILE</span>
                    <span>READY &nbsp;↗</span>
                </div>
                <h2 className="section-title reveal">{t('کشف')} <span className="gradient-text">{t('دنیای من')}</span></h2>

                <div className="bento-grid">
                    <motion.div
                        className={`bento-box bento-large reveal ${styles.bentoInteractive}`}
                        {...cardMotionProps}
                    >
                        <i className="fas fa-quote-right bento-icon-bg"></i>
                        <h3>{t('از اطلاعات تا تجربه‌ی دیجیتال')}</h3>
                        <p className="text-justify">{t('توسعه‌دهنده فول‌استک وب با ۷ سال تجربه حرفه‌ای. دارای مدرک کارشناسی در مهندسی نرم‌افزار و مهارت بالا در جاوااسکریپت (ES6+)، پی‌اچ‌پی، ری‌اکت و لاراول. تسلط پیشرفته بر زبان انگلیسی برای همکاری در سطح جهانی. سابقه‌ی موفق در اجرای پروژه‌های متعدد فول‌استک، از جمله فروشگاه آنلاین، وب‌سایت‌های شرکتی برای معرفی کسب‌وکار، و سیستم‌های گزارش‌دهی، که نیازهای پیچیده‌ی کسب‌وکار را از سمت کلاینت تا سمت سرور پاسخ داده‌اند.')}</p>
                    </motion.div>

                    <motion.div
                        className={`bento-box bento-medium reveal reveal-delay-1 tech-stack-box ${styles.bentoInteractive}`}
                        {...cardMotionProps}
                    >
                        <h3>{t('ابزارهای کلیدی')}</h3>
                        <div className="tech-tags mt-4">
                            <span>PHP</span>
                            <span>JavaScript(ES6+)</span>
                            <span>SQL</span>
                            <span>Laravel</span>
                            <span>React</span>
                            <span>Tailwind CSS</span>
                        </div>
                    </motion.div>

                    <motion.div
                        className={`bento-box bento-small reveal stat-box ${styles.bentoInteractive}`}
                        {...cardMotionProps}
                    >
                        <h2 className="stat-number en-text">10+</h2>
                        <p>{t('پروژه')}</p>
                    </motion.div>
                    <motion.div
                        className={`bento-box bento-small reveal stat-box ${styles.bentoInteractive}`}
                        {...cardMotionProps}
                    >
                        <h2 className="stat-number en-text">7+</h2>
                        <p>{t('سال تجربه')}</p>
                    </motion.div>

                    <motion.div
                        className={`bento-box bento-large reveal edu-box ${styles.bentoInteractive}`}
                        {...cardMotionProps}
                    >
                        <h3>{t('مسیر آکادمیک')}</h3>
                        <div className="mb-4">
                            <h4 style={{ color: 'var(--accent-1)' }}>{t('کارشناسی کامپیوتر نرم افزار')}</h4>
                            <p className="edu-uni font-bold">{t('دانشگاه آزاد')}</p>
                            <p className="text-muted" style={{ fontSize: '0.85rem' }}> </p>
                        </div>
                        <div>
                            <h4 style={{ color: 'var(--accent-2)' }}>{t('مدارک فنی')}</h4>
                            <p className="edu-uni font-bold">{t('مجتمع فنی تهران')}</p>
                            <div className="flex flex-col-reverse md:flex-row gap-4">

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
                    </motion.div>

                    <motion.div
                        className={`bento-box bento-medium reveal map-box ${styles.bentoInteractive}`}
                        {...cardMotionProps}
                    >
                        <div className="map-overlay">
                            <i className="fas fa-map-marker-alt"></i>
                            <p>{t('تهران، ایران')}<br /><span className="en-text text-sm">Remote Worldwide</span></p>
                        </div>
                    </motion.div>

                    <motion.div
                        className={`bento-box bento-small reveal stat-box ${styles.bentoInteractive}`}
                        {...cardMotionProps}
                    >
                        <h2 className="stat-number en-text">10+</h2>
                        <p>{t('مشتری راضی')}</p>
                    </motion.div>
                    <motion.div
                        className={`bento-box bento-small reveal stat-box ${styles.bentoInteractive}`}
                        {...cardMotionProps}
                    >
                        <h2 className="stat-number en-text">6+</h2>
                        <p>{t('پروژه وب سایت دیپلوی شده')}</p>
                    </motion.div>

                    <ComputerVision />
                    <ReactComponent />

                    <motion.div
                        className={`bento-box bento-medium reveal ${styles.bentoInteractive}`}
                        {...cardMotionProps}
                    >
                        <i className="fas fa-heart bento-icon-bg"></i>
                        <h3>{t('خارج از کد')}</h3>
                        <p className="" style={{ marginBottom: '15px', fontSize: '0.9rem' }}>{t('وقتی پشت لپ‌تاپ نیستم...')}</p>
                        <div className="tech-tags">
                            <span><i className="fas fa-brain"></i> {t('فلسفه ذهن')}</span>
                            <span><i className="fas fa-language"></i> {t('زبان انگلیسی')}</span>
                            <span><i className="fas fa-bicycle"></i> {t('دوچرخه سواری')}</span>
                            <span><i className="fas fa-microchip"></i> {t('تکنولوژی')}</span>
                        </div>
                    </motion.div>

                    <motion.div
                        className={`bento-box bento-medium reveal ${styles.bentoInteractive}`}
                        {...cardMotionProps}
                    >
                        <i className="fas fa-lightbulb bento-icon-bg"></i>
                        <h3>{t('فلسفه کاری من')}</h3>
                        <p className="" style={{ fontSize: '0.95rem', lineHeight: 1.8 }}>{t('کد خوب فقط کار نمی‌کند؛ ساده، قابل‌فهم و آماده‌ی رشد است.')}</p>
                    </motion.div>
                </div>
            </div>
        </section>
    );
}
