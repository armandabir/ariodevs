import React, { useState } from 'react';
import axios from 'axios';
import { useLocale } from '../lib/LocaleContext';
import styles from '../../css/styles/Footer.module.scss';

export default function Footer() {
    const { t, isLocale } = useLocale();
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [status, setStatus] = useState(null);

    async function handleSubmit(e) {
        e.preventDefault();
        const form = e.currentTarget;
        const formData = new FormData(form);
        setIsSubmitting(true);
        setStatus(null);

        try {
            await axios.post('/contact-requests', {
                name: formData.get('name'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                message: formData.get('message'),
            }, {
                headers: {
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
            });
            form.reset();
            setStatus({ type: 'success', message: t('پیام شما با موفقیت ثبت شد. به‌زودی با شما تماس می‌گیرم.') });
        } catch (error) {
            const message = error.response?.status === 422
                ? t('لطفاً نام، شماره تماس معتبر و پیام خود را بررسی کنید.')
                : t('ارسال پیام انجام نشد. لطفاً دوباره تلاش کنید.');
            setStatus({ type: 'error', message });
        } finally {
            setIsSubmitting(false);
        }
    }

    return (
        <footer id="contact" className={`${styles.modernFooter} section`}>
            <div className="container">
                <div className="section-tag mb-4">
                    <span>06 / GAME ON · LET’S TALK</span>
                    <span>CO-OP MODE</span>
                </div>
                <div className={styles.footerGrid}>
                    <div className="footer-text reveal">
                        <h2 className={styles.hugeText}>{t('آماده خلق')} <br /><span className="gradient-text">{t('آینده')}</span> {t('هستید؟')}</h2>
                        <p>{t('برای مشاوره، پروژه‌های فریلنسری یا یک فنجان قهوه پیام دهید. من همیشه آماده شنیدن ایده‌های جدید هستم. معمولاً ظرف ۲۴ ساعت پاسخ می‌دهم.')}</p>
                        <a href="mailto:ario.dabir@gmail.com" className={`${styles.emailLink} en-text`}>ario.dabir@gmail.com</a>
                    </div>

                    <div className={`${styles.footerForm} glass-card reveal reveal-delay-1`}>
                        <form id="contact-form" dir={isLocale('en') ? 'ltr' : 'rtl'} onSubmit={handleSubmit}>
                            <div className={styles.inputContainer}>
                                <input type="text" id="name" name="name" maxLength="120" required placeholder=" " />
                                <label htmlFor="name">{t('نام شما')}</label>
                            </div>
                            <div className={styles.inputContainer}>
                                <input type="tel" id="phone" name="phone" maxLength="30" required placeholder=" " dir="ltr" inputMode="tel" autoComplete="tel" />
                                <label htmlFor="phone">{t('شماره تماس')}</label>
                            </div>
                            <div className={styles.inputContainer}>
                                <input type="email" id="email" name="email" maxLength="255" placeholder=" " />
                                <label htmlFor="email">{t('ایمیل شما (اختیاری)')}</label>
                            </div>
                            <div className={styles.inputContainer}>
                                <textarea id="message" name="message" rows="4" maxLength="5000" required placeholder=" "></textarea>
                                <label htmlFor="message">{t('پروژه یا ایده شما...')}</label>
                            </div>
                            {status && <p className={`${styles.formStatus} ${status.type === 'error' ? styles.formStatusError : ''}`} role="status" aria-live="polite">{status.message}</p>}
                            <button type="submit" className={`btn bordered ${styles.pubBtn} w-100`} disabled={isSubmitting}>
                                {isSubmitting ? t('در حال ارسال...') : t('ارسال درخواست')} <i className={`fas ${isSubmitting ? 'fa-spinner fa-spin' : 'fa-paper-plane'} text-blue-500`}></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div className={styles.footerBottom}>
                    <p>&copy; 2026 {t('طراحی شده با ریکت و هوش مصنوعی')} | <span className="en-text">Ario.Devs</span></p>
                    <div className="social-hero">
                        <a href="#" className="social-icon"><i className="fab fa-telegram-plane"></i></a>
                        <a href="#" className="social-icon"><i className="fab fa-twitter"></i></a>
                        <a href="#" className="social-icon"><i className="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </footer>
    );
}
