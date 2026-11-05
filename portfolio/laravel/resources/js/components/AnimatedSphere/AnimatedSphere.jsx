import React, { useState, useEffect } from 'react';
import { motion } from 'motion/react';
import SphereScene from './SphereScene';
import styles from './AnimatedSphere.module.scss';

function checkWebGLSupport() {
    if (typeof window === 'undefined') return false;
    try {
        const canvas = document.createElement('canvas');
        return Boolean(
            window.WebGLRenderingContext &&
            (canvas.getContext('webgl') || canvas.getContext('experimental-webgl'))
        );
    } catch {
        return false;
    }
}

export default function AnimatedSphere({ className = '' }) {
    const [hasWebGL, setHasWebGL] = useState(true);
    const [isReducedMotion, setIsReducedMotion] = useState(false);

    useEffect(() => {
        setHasWebGL(checkWebGLSupport());

        const mediaQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
        setIsReducedMotion(mediaQuery.matches);

        const handleMotionPreference = (e) => setIsReducedMotion(e.matches);
        mediaQuery.addEventListener('change', handleMotionPreference);

        return () => {
            mediaQuery.removeEventListener('change', handleMotionPreference);
        };
    }, []);

    return (
        <motion.div
            className={`${styles.sphereBackground} ${className}`}
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ duration: 1.5, ease: 'easeOut' }}
            aria-hidden="true"
        >
            <div className={styles.ambientGlow} />

            {hasWebGL ? (
                <div className={styles.canvasWrapper}>
                    <SphereScene isReducedMotion={isReducedMotion} />
                </div>
            ) : (
                <div className={styles.fallbackSphere} />
            )}
        </motion.div>
    );
}
