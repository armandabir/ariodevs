import { useEffect } from 'react';

export default function useScrollEffects() {
    useEffect(() => {
        const scrollProgress = document.getElementById('scroll-progress');
        function onScroll() {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const scrollPercent = (scrollTop / docHeight) * 100;
            if (scrollProgress) {
                scrollProgress.style.width = `${scrollPercent}%`;
            }
        }
        window.addEventListener('scroll', onScroll);

        const cursorDot = document.getElementById('cursor-dot');
        const cursorOutline = document.getElementById('cursor-outline');
        const isTouchDevice = !window.matchMedia('(pointer: fine)').matches;
        let onMouseMove;

        if (!isTouchDevice && cursorDot && cursorOutline) {
            onMouseMove = (e) => {
                const posX = e.clientX;
                const posY = e.clientY;
                cursorDot.style.left = `${posX}px`;
                cursorDot.style.top = `${posY}px`;
                cursorOutline.animate({ left: `${posX}px`, top: `${posY}px` }, { duration: 500, fill: 'forwards' });
            };
            window.addEventListener('mousemove', onMouseMove);

            const hoverTargets = document.querySelectorAll('a, button, .bento-box, .modern-project-card, .service-card, .testimonial-card');
            hoverTargets.forEach((target) => {
                target.addEventListener('mouseenter', onEnter);
                target.addEventListener('mouseleave', onLeave);
            });

            function onEnter() {
                cursorOutline.style.width = '60px';
                cursorOutline.style.height = '60px';
                cursorOutline.style.backgroundColor = 'rgba(255, 255, 255, 0.1)';
            }
            function onLeave() {
                cursorOutline.style.width = '40px';
                cursorOutline.style.height = '40px';
                cursorOutline.style.backgroundColor = 'transparent';
            }

            var cleanupHover = () => {
                hoverTargets.forEach((target) => {
                    target.removeEventListener('mouseenter', onEnter);
                    target.removeEventListener('mouseleave', onLeave);
                });
            };
        } else {
            if (cursorDot) cursorDot.style.display = 'none';
            if (cursorOutline) cursorOutline.style.display = 'none';
        }

        const progressBars = document.querySelectorAll('.progress-bar');
        function reveal() {
            const reveals = document.querySelectorAll('.reveal');
            const windowHeight = window.innerHeight;
            for (let i = 0; i < reveals.length; i++) {
                const elementTop = reveals[i].getBoundingClientRect().top;
                const elementVisible = 100;
                if (elementTop < windowHeight - elementVisible) {
                    reveals[i].classList.add('active');
                }
            }
            progressBars.forEach((bar) => {
                const barPosition = bar.getBoundingClientRect().top;
                if (barPosition < windowHeight - 50) {
                    const targetWidth = bar.getAttribute('data-width');
                    bar.style.width = targetWidth;
                }
            });
        }
        window.addEventListener('scroll', reveal);
        reveal();

        function onAnchorClick(e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                window.scrollTo({ top: targetElement.offsetTop - 90, behavior: 'smooth' });
            }
        }
        const anchors = document.querySelectorAll('a[href^="#"]');
        anchors.forEach((anchor) => anchor.addEventListener('click', onAnchorClick));

        return () => {
            window.removeEventListener('scroll', onScroll);
            window.removeEventListener('scroll', reveal);
            if (onMouseMove) window.removeEventListener('mousemove', onMouseMove);
            if (typeof cleanupHover === 'function') cleanupHover();
            anchors.forEach((anchor) => anchor.removeEventListener('click', onAnchorClick));
        };
    }, []);
}
