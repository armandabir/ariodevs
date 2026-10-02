import React, { useEffect, useState } from 'react';
import Header from '../components/Header';
import Hero from '../components/Hero';
import About from '../components/About';
import Experience from '../components/Experience';
import Publications from '../components/Publications';
import Projects from '../components/Projects';
import Testimonials from '../components/Testimonials';
import Footer from '../components/Footer';
import useScrollEffects from '../lib/useScrollEffects';

export default function Home() {
    const [theme, setTheme] = useState(() => {
        return localStorage.getItem('modern-portfolio-theme') || 'dark';
    });

    useEffect(() => {
        document.body.setAttribute('data-theme', theme);
        document.documentElement.setAttribute('data-theme', theme);
    }, [theme]);

    function toggleTheme() {
        setTheme((prev) => {
            const next = prev === 'dark' ? 'light' : 'dark';
            localStorage.setItem('modern-portfolio-theme', next);
            return next;
        });
    }

    useScrollEffects();

    return (
        <>
            <div className="scroll-progress" id="scroll-progress"></div>
            <div className="cursor-dot" id="cursor-dot"></div>
            <div className="cursor-outline" id="cursor-outline"></div>
            <div className="noise-bg"></div>

            <Header theme={theme} onToggleTheme={toggleTheme} />
            <Hero />
            <About />
            <Experience />
            <Publications />
            <Projects />
            <Testimonials />
            <Footer />
        </>
    );
}
