import React, { useState } from 'react';
import styles from '../css/styles/Header.module.scss';

export default function Header({ theme, onToggleTheme }) {
    const [menuOpen, setMenuOpen] = useState(false);

    const navItems = [
        { href: '#home', label: 'خانه' },
        { href: '#about', label: 'درباره من' },
        { href: '#experience', label: 'سوابق' },
        { href: '#publications', label: 'مقالات' },
        { href: '#projects', label: 'پروژه‌ها' },
    ];

    const mobileNavItems = [
        { href: '#home', label: 'خانه' },
        { href: '#about', label: 'درباره من' },
        { href: '#services', label: 'خدمات' },
        { href: '#skills', label: 'مهارت‌ها' },
        { href: '#experience', label: 'سوابق' },
        { href: '#publications', label: 'مقالات' },
        { href: '#projects', label: 'پروژه‌ها' },
    ];

    const closeMenu = () => setMenuOpen(false);

    return (
        <>
            <div className={`${styles.mobileMenuOverlay}${menuOpen ? ` ${styles.active}` : ''}`} id="mobile-overlay" onClick={closeMenu}></div>
            <aside className={`${styles.mobileMenu}${menuOpen ? ` ${styles.active}` : ''}`} id="mobile-menu">
                <button className={styles.closeMenuBtn} id="close-menu" onClick={closeMenu}>
                    <i className="fas fa-times"></i>
                </button>
                <div>
                    <a href="#" className={styles.logo} style={{ marginBottom: '1.5rem', display: 'block' }}>Aria<span className="gradient-text">.AI</span></a>
                    <ul className={styles.mobileNavLinks}>
                        {mobileNavItems.map((item) => (
                            <li key={item.href}>
                                <a href={item.href} className={styles.mobileNavItem} onClick={closeMenu}>{item.label}</a>
                            </li>
                        ))}
                    </ul>
                    <a href="#contact" className={`${styles.btn} ${styles.btnPrimary}`} style={{ width: '100%', marginTop: '1.5rem', display: 'flex', justifyContent: 'center' }} onClick={closeMenu}>ارتباط با من</a>
                </div>
            </aside>

            <header className={styles.header}>
                <div className={`container ${styles.navContainer}`}>
                    <a href="#" className={styles.logo}>Aria<span className="gradient-text">.AI</span></a>
                    <nav>
                        <ul className={styles.navLinks}>
                            {navItems.map((item) => (
                                <li key={item.href}>
                                    <a href={item.href} className={styles.navItem}>{item.label}</a>
                                </li>
                            ))}
                        </ul>
                    </nav>
                    <div className={styles.headerActions}>
                        <button id="theme-toggle" className={styles.themeBtn} aria-label="تغییر تم" onClick={onToggleTheme}>
                            <i className={theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon'}></i>
                        </button>
                        <a href="#contact" className={`${styles.btn} ${styles.btnGlow} hidden-mobile`}>ارتباط با من</a>
                        <button className={styles.mobileMenuBtn} id="open-menu" onClick={() => setMenuOpen(true)}>
                            <i className="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </header>
        </>
    );
}
