import React, { useRef } from 'react';

export default function Footer() {
    const formRef = useRef(null);

    function handleSubmit(e) {
        e.preventDefault();
        const contactForm = formRef.current;
        const btn = contactForm.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;

        btn.innerHTML = 'در حال ارسال... <i class="fas fa-spinner fa-spin"></i>';
        btn.style.pointerEvents = 'none';

        setTimeout(() => {
            btn.innerHTML = 'پیام با موفقیت ارسال شد <i class="fas fa-check"></i>';
            btn.style.background = '#10b981';
            btn.style.color = '#fff';
            contactForm.reset();

            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.style.background = '';
                btn.style.color = '';
                btn.style.pointerEvents = 'auto';
            }, 3000);
        }, 1500);
    }

    return (
        <footer id="contact" className="modern-footer section">
            <div className="container">
                <div className="footer-grid">
                    <div className="footer-text reveal">
                        <h2 className="huge-text">آماده خلق <br /><span className="gradient-text">آینده</span> هستید؟</h2>
                        <p>برای مشاوره، پروژه‌های فریلنسری یا یک فنجان قهوه مجازی، پیام دهید. من همیشه آماده شنیدن ایده‌های جدید هستم. معمولاً ظرف ۲۴ ساعت پاسخ می‌دهم.</p>
                        <a href="mailto:hello@aria-ai.com" className="email-link en-text">hello@aria-ai.com</a>
                    </div>

                    <div className="footer-form glass-card reveal reveal-delay-1">
                        <form id="contact-form" ref={formRef} onSubmit={handleSubmit}>
                            <div className="input-container">
                                <input type="text" id="name" required placeholder=" " />
                                <label htmlFor="name">نام شما</label>
                            </div>
                            <div className="input-container">
                                <input type="email" id="email" required placeholder=" " />
                                <label htmlFor="email">ایمیل شما</label>
                            </div>
                            <div className="input-container">
                                <textarea id="message" rows="4" required placeholder=" "></textarea>
                                <label htmlFor="message">پروژه یا ایده شما...</label>
                            </div>
                            <button type="submit" className="btn btn-glow w-100">ارسال درخواست <i className="fas fa-paper-plane"></i></button>
                        </form>
                    </div>
                </div>

                <div className="footer-bottom">
                    <p>&copy; ۱۴۰۴ طراحی شده با هوش و هنر | <span className="en-text">Aria.AI</span></p>
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
