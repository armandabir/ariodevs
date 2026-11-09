import React, { useEffect, useRef } from 'react';
import { motion } from 'framer-motion';
import styles from '../../css/styles/Hero.module.scss';
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

const roles = ['FULL-STACK DEVELOPER', 'AI & SOFTWARE ENGINEER', 'LARAVEL & REACT CRAFTSMAN'];

export default function Hero() {
    const { t } = useLocale();
    const typedTextRef = useRef(null);

    useEffect(() => {
        const typedSpan = typedTextRef.current;
        if (!typedSpan) return;

        const typingDelay = 90;
        const erasingDelay = 45;
        const newTextDelay = 2200;
        let roleIdx = 0;
        let charIdx = 0;
        let timeoutId;
        let stopped = false;

        function type() {
            if (stopped) return;
            if (charIdx < roles[roleIdx].length) {
                typedSpan.textContent += roles[roleIdx].charAt(charIdx);
                charIdx++;
                timeoutId = setTimeout(type, typingDelay);
            } else {
                timeoutId = setTimeout(erase, newTextDelay);
            }
        }

        function erase() {
            if (stopped) return;
            if (charIdx > 0) {
                typedSpan.textContent = roles[roleIdx].substring(0, charIdx - 1);
                charIdx--;
                timeoutId = setTimeout(erase, erasingDelay);
            } else {
                roleIdx = (roleIdx + 1) % roles.length;
                timeoutId = setTimeout(type, typingDelay + 400);
            }
        }

        timeoutId = setTimeout(type, 800);

        return () => {
            stopped = true;
            clearTimeout(timeoutId);
        };
    }, []);

    return (
        <section id="home" className={styles.hero} aria-labelledby="hero-title">
            {/* Background live video */}
            <video
                className={styles.heroVideo}
                autoPlay
                muted
                loop
                playsInline
                preload="metadata"
                poster="/assets/retro/main-background.jpg"
                aria-hidden="true"
            >
                <source src="/assets/retro/hero section-background live.mp4" type="video/mp4" />
            </video>

            {/* Shading overlay */}
            <div className={styles.heroShade} aria-hidden="true"></div>

            {/* Retro Pixel Art Top-Section Background */}
            <div className={styles.heroPixelBg} aria-hidden="true"></div>

            {/* Top meta strip */}
            <div className={styles.heroInfo}>
                <span className={styles.metaLabel}>ARIODEVS / INDEPENDENT WEB DEVELOPER</span>
                <span className={styles.liveBadge}>
                    <i className={styles.liveDot}></i> OPEN TO SELECT PROJECTS
                </span>
            </div>

            {/* Center arcade display */}
            <div className={styles.heroMain}>
                <div className={styles.heroKicker}>
                    <span className={styles.pixelHeart}>♥</span> PRESS START TO EXPLORE <span className={styles.pixelHeart}>♥</span>
                </div>

                <div className={styles.heroTitleRow}>
                    <h1 id="hero-title" className={styles.title}>
                        PLAYFUL<br />
                        <span>BY DESIGN</span>
                        <b className={styles.regMark}>®</b>
                    </h1>

                    <motion.div
                        className={`bento-box ${styles.characterBox}`}
                        {...cardMotionProps}
                    >
                        <img
                            src="/assets/images/character.jpg"
                            alt="Character"
                            loading="eager"
                        />
                    </motion.div>
                </div>

                <div className={styles.typeRow}>
                    <span className={styles.typeRole} ref={typedTextRef}></span>
                    <span className={styles.cursor}>_</span>
                </div>

                <div className={styles.heroLower}>
                    <div className={styles.heroRight}>
                        <div className={styles.heroProfileBadge}>
                            {t('در دسترس برای پروژه‌های فریلنسری')} <span className={styles.profilePulse}></span>
                        </div>
                        <h2 className={styles.heroProfileName}>
                            {t('من')} <span>{t('آرمان دبیرمقدم')}</span> {t('هستم')}
                        </h2>
                        <p className={styles.heroProfileRole}>
                            {t('یک')} <span>{t('مهندس نرم‌افزار و توسعه‌دهنده فول‌استک')}</span>
                        </p>
                        <p className={styles.heroProfileBio}>
                            <strong className={styles.laravelTag}>LARAVEL</strong>، <strong className={styles.reactTag}>REACT</strong>  <strong className={styles.aiTag}>AI</strong>
                        </p>
                    </div>

                    <div className={styles.heroActions}>
                    <a className={styles.startButton} href="#about">
                        <motion.span
                            className={styles.btnIcon}
                            animate={{ opacity: [1, 0.01, 1] }}
                            transition={{ duration: 1.2, repeat: Infinity, ease: 'steps(1, end)' }}
                        >
                            ▶
                        </motion.span>
                        <motion.span
                            className="w-full"
                            animate={{ opacity: [1, 0.65, 1] }}
                            transition={{ duration: 1.2, repeat: Infinity, ease: 'steps(1, end)' }}
                        >
                            PRESS START
                        </motion.span>
                        <span className={styles.btnArrow}>↘</span>
                    </a>

                    <div className={styles.socialStrip}>
                        <a href="https://github.com/armandabir" target="_blank" rel="noopener noreferrer" className={styles.socialBtn} aria-label="GitHub">
                            <i className="fab fa-github"></i>
                        </a>
                        <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" className={styles.socialBtn} aria-label="LinkedIn">
                            <i className="fab fa-linkedin-in"></i>
                        </a>
                        <a href="mailto:ario.dabir@gmail.com" className={styles.socialBtn} aria-label="Email">
                            <i className="fas fa-envelope"></i>
                        </a>
                    </div>
                </div>
                <div></div>
            </div>
            </div>

            {/* Bottom info strip */}
            <div className={styles.heroBottom}>
                <span>SCROLL TO CONTINUE <b className={styles.bottomArrow}>↓</b></span>
                <span>EST. MMXX · DIGITAL GOODS</span>
            </div>

            {/* Retro decorative glyphs */}
            <span className={`${styles.heroCorner} ${styles.cornerA}`} aria-hidden="true">✳</span>
            <span className={`${styles.heroCorner} ${styles.cornerB}`} aria-hidden="true">✳</span>
        </section>
    );
}
