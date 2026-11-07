import React, { useEffect, useRef } from 'react';
import styles from '../../css/styles/Hero.module.scss';

const textArray = ['برنامه نویس وب سایت', 'مهندس نرم‌افزار', 'توسعه‌دهنده فول‌استک'];

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

            <div className={`container ${styles.heroContent}`}>
                <div className={`${styles.heroText} reveal`}>
                    <div className={styles.badge}>در دسترس برای پروژه‌های فریلنسری <span className={styles.pulseDot}></span></div>
                    <h1 className={styles.name}>من <span className="gradient-text">آرمان دبیرمقدم</span> هستم</h1>
                    <h2 className={styles.role}>یک <span id="typed-text" className="typed-text" ref={typedTextRef}></span><span className={styles.cursor}>|</span></h2>
                    <p className={styles.bio}>
                        من با بیش از 7 سال تجربه در برنامه‌نویسی و توسعه نرم‌افزار، تمرکز من روی طراحی و ساخت سیستم‌های هوشمند {' '}بر پایه
                        <span className={`en-text ${styles.highlightBg}`} style={{ color: '#ff2d20', backgroundColor: 'rgba(255, 45, 32, 0.12)' }}>LARAVEL</span>،{' '}
                        <span className={`en-text ${styles.highlightBg}`}>REACT</span> و{' '}
                        <span className={`en-text ${styles.highlightBg}`} style={{ color: '#f5f8fb', backgroundColor: 'rgba(245, 248, 251, 0.14)' }}>AI</span> است.
                    </p>
                </div>
            </div>
        </section>
    );
}
