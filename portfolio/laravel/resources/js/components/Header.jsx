import React, { useState } from 'react';

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
            <div className={`mobile-menu-overlay${menuOpen ? ' active' : ''}`} id="mobile-overlay" onClick={closeMenu}></div>
            <aside className={`mobile-menu${menuOpen ? ' active' : ''}`} id="mobile-menu">
                <button className="close-menu-btn" id="close-menu" onClick={closeMenu}>
                    <i className="fas fa-times"></i>
                </button>
                <div className="mobile-menu-content">
                    <a href="#" className="logo mb-4">Aria<span className="gradient-text">.AI</span></a>
                    <ul className="mobile-nav-links">
                        {mobileNavItems.map((item) => (
                            <li key={item.href}>
                                <a href={item.href} className="mobile-nav-item" onClick={closeMenu}>{item.label}</a>
                            </li>
                        ))}
                    </ul>
                    <a href="#contact" className="btn btn-primary w-100 mt-4" onClick={closeMenu}>ارتباط با من</a>
                </div>
            </aside>

            <header className="header">
                <div className="container nav-container">
                    <a href="#" className="logo">Aria<span className="gradient-text">.AI</span></a>
                    <nav className="navbar">
                        <ul className="nav-links">
                            {navItems.map((item) => (
                                <li key={item.href}>
                                    <a href={item.href} className="nav-item">{item.label}</a>
                                </li>
                            ))}
                        </ul>
                    </nav>
                    <div className="header-actions">
                        <button id="theme-toggle" className="theme-btn" aria-label="تغییر تم" onClick={onToggleTheme}>
                            <i className={theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon'}></i>
                        </button>
                        <a href="#contact" className="btn btn-glow hidden-mobile">ارتباط با من</a>
                        <button className="mobile-menu-btn" id="open-menu" onClick={() => setMenuOpen(true)}>
                            <i className="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </header>
        </>
    );
}
