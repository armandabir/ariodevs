import React, { useEffect, useRef } from 'react';

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
        <section id="home" className="hero">
            <div className="glow-blob blob-1"></div>
            <div className="glow-blob blob-2"></div>
            <div className="container hero-content">
                <div className="hero-text reveal">
                    <div className="badge">در دسترس برای پروژه‌های فریلنسری <span className="pulse-dot"></span></div>
                    <h1 className="name">من <span className="gradient-text">آرمان دبیرمقدم</span> هستم</h1>
                    <h2 className="role">یک <span id="typed-text" className="typed-text" ref={typedTextRef}></span><span className="cursor">|</span></h2>
                    <p className="bio">
                        من با بیش از 7 سال تجربه در برنامه‌نویسی و توسعه نرم‌افزار، تمرکز من روی طراحی و ساخت سیستم‌های هوشمند {' '}بر پایه
                        <span className="en-text highlight-bg">LARAVEL</span>،{' '}
                        <span className="en-text highlight-bg">REACT</span> و{' '}
                        <span className="en-text highlight-bg">AI</span> است.
                    </p>
                    <div className="hero-buttons">
                        <a href="#projects" className="btn btn-primary btn-large">
                            کاوش پروژه‌ها <i className="fas fa-arrow-left"></i>
                        </a>
                        <div className="social-hero">
                            <a href="#" className="social-icon"><i className="fab fa-github"></i></a>
                            <a href="#" className="social-icon"><i className="fab fa-linkedin-in"></i></a>
                            <a href="#" className="social-icon"><i className="fab fa-kaggle"></i></a>
                        </div>
                    </div>
                </div>

                <div className="hero-visual reveal reveal-delay-1">
                    <div className="image-wrapper">
                        <img src="/assets/images/image(6).jpg" alt="Aro devs Engineer" className="profile-img" />
                        <div className="tech-float float-1"><i className="fab fa-laravel"></i></div>
                        <div className="tech-float float-2"><i className="fab fa-react"></i></div>
                        <div className="tech-float float-3"><i className="fa-solid fa-globe-www" aria-label="World Wide Web" title="WWW"></i></div>
                    </div>
                </div>
            </div>
        </section>
    );
}
