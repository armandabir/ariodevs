import React, { useState } from 'react';
import styles from '../../css/styles/Header.module.scss';

export default function Header({ theme, onToggleTheme }) {
    const [menuOpen, setMenuOpen] = useState(false);

    const navItems = [
        { href: '#home', num: '01', label: 'خانه' },
        { href: '#about', num: '02', label: 'درباره من' },
        { href: '#experience', num: '03', label: 'سوابق' },
        { href: '#publications', num: '04', label: 'مقالات' },
        { href: '#projects', num: '05', label: 'پروژه‌ها' },
    ];

    const mobileNavItems = [
        { href: '#home', num: '01', label: 'خانه' },
        { href: '#about', num: '02', label: 'درباره من' },
        { href: '#services', num: '03', label: 'خدمات' },
        { href: '#skills', num: '04', label: 'مهارت‌ها' },
        { href: '#experience', num: '05', label: 'سوابق' },
        { href: '#publications', num: '06', label: 'مقالات' },
        { href: '#projects', num: '07', label: 'پروژه‌ها' },
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
                    <a href="#" className={styles.logo} style={{ marginBottom: '1.5rem', display: 'block' }}>ARIO<span>DEVS</span><small>®</small></a>
                    <ul className={styles.mobileNavLinks}>
                        {mobileNavItems.map((item) => (
                            <li key={item.href}>
                                <a href={item.href} className={styles.mobileNavItem} onClick={closeMenu}>
                                    <b className={styles.navNum}>{item.num}</b> {item.label}
                                </a>
                            </li>
                        ))}
                    </ul>
                    <a href="#contact" className={`${styles.navButton}`} style={{ width: '100%', marginTop: '1.5rem', display: 'flex', justifyContent: 'center' }} onClick={closeMenu}>
                        LET’S TALK <span>↗</span>
                    </a>
                </div>
            </aside>

            <header className={styles.header}>
                <div className={`container ${styles.navContainer}`}>
                    <a href="#" className={styles.brand}>ARIO<span>DEVS</span><small>®</small></a>
                    <nav className={styles.nav}>
                        <ul className={styles.navLinks}>
                            {navItems.map((item) => (
                                <li key={item.href}>
                                    <a href={item.href} className={styles.navItem}>
                                        <b>{item.num}</b> {item.label}
                                    </a>
                                </li>
                            ))}
                        </ul>
                    </nav>
                    <div className={styles.headerActions}>
                        <button id="theme-toggle" className={styles.themeBtn} aria-label="تغییر تم" onClick={onToggleTheme}>
                            <i className={theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon'}></i>
                        </button>
                        <a href="#contact" className={`${styles.navButton} hidden-mobile`}>
                            <span>LET’S TALK</span>
                            <span className={styles.btnArrow}>↗</span>
                        </a>
                        <button className={styles.mobileMenuBtn} id="open-menu" onClick={() => setMenuOpen(true)}>
                            <i className="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </header>
        </>
    );
}
