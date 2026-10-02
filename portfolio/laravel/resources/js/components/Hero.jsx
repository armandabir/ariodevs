import React, { useEffect, useRef } from 'react';
import styles from '../css/styles/Hero.module.scss';

const textArray = ['برنامه نویس وب', 'مهندس نرم‌افزار', 'توسعه‌دهنده فول‌استک'];

export default function Hero() {
    const typedTextRef = useRef(null);

    useEffect(() => {
        const typedTextSpan = typedTextRef.current;
        if (!typedTextSpan) return;

        const typingDelay = 100;
        const erasingDelay = 50;
        const newTextDelay = 2000;
        let textArrayIndex = 0;
        let charIndex = 0;
        let timeoutId;
        let stopped = false;

        function type() {
            if (stopped) return;
            if (charIndex < textArray[textArrayIndex].length) {
                typedTextSpan.textContent += textArray[textArrayIndex].charAt(charIndex);
                charIndex++;
                timeoutId = setTimeout(type, typingDelay);
            } else {
                timeoutId = setTimeout(erase, newTextDelay);
            }
        }

        function erase() {
            if (stopped) return;
            if (charIndex > 0) {
                typedTextSpan.textContent = textArray[textArrayIndex].substring(0, charIndex - 1);
                charIndex--;
                timeoutId = setTimeout(erase, erasingDelay);
            } else {
                textArrayIndex++;
                if (textArrayIndex >= textArray.length) textArrayIndex = 0;
                timeoutId = setTimeout(type, typingDelay + 1100);
            }
        }

        timeoutId = setTimeout(type, newTextDelay + 250);

        return () => {
            stopped = true;
            clearTimeout(timeoutId);
        };
    }, []);

    return (
        <section id="home" className={styles.hero}>
            <div className={`${styles.glowBlob} ${styles.blob1}`}></div>
            <div className={`${styles.glowBlob} ${styles.blob2}`}></div>
            <div className={`container ${styles.heroContent}`}>
                <div className={`${styles.heroText} reveal`}>
                    <div className={styles.badge}>در دسترس برای پروژه‌های فریلنسری <span className={styles.pulseDot}></span></div>
                    <h1 className={styles.name}>من <span className="gradient-text">آرمان دبیرمقدم</span> هستم</h1>
                    <h2 className={styles.role}>یک <span id="typed-text" className="typed-text" ref={typedTextRef}></span><span className={styles.cursor}>|</span></h2>
                    <p className={styles.bio}>
                        من با بیش از 7 سال تجربه در برنامه‌نویسی و توسعه نرم‌افزار، تمرکز من روی طراحی و ساخت سیستم‌های هوشمند {' '}بر پایه
                        <span className={`en-text ${styles.highlightBg}`}>LARAVEL</span>،{' '}
                        <span className={`en-text ${styles.highlightBg}`}>REACT</span> و{' '}
                        <span className={`en-text ${styles.highlightBg}`}>AI</span> است.
                    </p>
                    <div className={styles.heroButtons}>
                        <a href="#projects" className={`${styles.btn} btn-primary btn-large`}>
                            کاوش پروژه‌ها <i className="fas fa-arrow-left"></i>
                        </a>
                        <div className={styles.socialHero}>
                            <a href="#" className={styles.socialIcon}><i className="fab fa-github"></i></a>
                            <a href="#" className={styles.socialIcon}><i className="fab fa-linkedin-in"></i></a>
                            <a href="#" className={styles.socialIcon}><i className="fab fa-kaggle"></i></a>
                        </div>
                    </div>
                </div>

                <div className={`${styles.heroVisual} reveal reveal-delay-1`}>
                    <div className={styles.imageWrapper}>
                        <img src="/assets/images/image(6).jpg" alt="Aro devs Engineer" className={styles.profileImg} />
                        <div className={`${styles.techFloat} ${styles.float1}`}><i className="fab fa-laravel"></i></div>
                        <div className={`${styles.techFloat} ${styles.float2}`}><i className="fab fa-react"></i></div>
                        <div className={`${styles.techFloat} ${styles.float3}`}><i className="fa-solid fa-globe-www" aria-label="World Wide Web" title="WWW"></i></div>
                    </div>
                </div>
            </div>
        </section>
    );
}
