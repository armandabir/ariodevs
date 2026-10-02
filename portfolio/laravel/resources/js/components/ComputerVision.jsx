import React, { useEffect, useRef } from 'react';
import styles from '../../css/styles/ComputerVision.module.scss';

export default function ComputerVision() {
    const viewportRef = useRef(null);

    useEffect(() => {
        const viewport = viewportRef.current;
        if (!viewport) return;

        let timeoutId;
        let stopped = false;

        const cocoClasses = [
            { name: 'person', color: '#00ff00' },
            { name: 'vehicle', color: '#00f2fe' },
            { name: 'traffic light', color: '#ffbd2e' },
            { name: 'laptop', color: '#d2a8ff' },
            { name: 'cup', color: '#ff7b72' },
        ];

        function createBoundingBox() {
            const box = document.createElement('div');
            box.className = 'bounding-box';

            const objClass = cocoClasses[Math.floor(Math.random() * cocoClasses.length)];

            const width = 15 + Math.random() * 25;
            const height = 20 + Math.random() * 40;
            const left = Math.random() * (100 - width);
            const top = 10 + Math.random() * (80 - height);

            const confidence = (0.75 + Math.random() * 0.24).toFixed(2);

            box.style.width = `${width}%`;
            box.style.height = `${height}%`;
            box.style.left = `${left}%`;
            box.style.top = `${top}%`;
            box.style.borderColor = objClass.color;
            box.style.boxShadow = `inset 0 0 10px rgba(255,255,255,0.1), 0 0 8px ${objClass.color}`;

            const label = document.createElement('div');
            label.className = 'bb-label';
            label.style.backgroundColor = objClass.color;
            label.innerHTML = `${objClass.name} ${confidence}`;

            box.appendChild(label);
            viewport.appendChild(box);

            const displayTime = 1500 + Math.random() * 1500;
            setTimeout(() => {
                box.style.opacity = '0';
                setTimeout(() => {
                    if (viewport.contains(box)) viewport.removeChild(box);
                }, 300);
            }, displayTime);
        }

        function detectionLoop() {
            if (stopped) return;
            const currentBoxes = viewport.querySelectorAll('.bounding-box').length;
            if (currentBoxes < 3 && Math.random() > 0.3) {
                createBoundingBox();
            }

            const nextTick = 400 + Math.random() * 1000;
            timeoutId = setTimeout(detectionLoop, nextTick);
        }

        timeoutId = setTimeout(detectionLoop, 1000);

        return () => {
            stopped = true;
            clearTimeout(timeoutId);
        };
    }, []);

    return (
        <div className={`bento-box bento-medium reveal ${styles.cvBox}`}>
            <div className={styles.cvHeader}>
                <div className={styles.cvStatus}>
                    <span className={styles.liveDot}></span>
                    <span className="en-text" style={{ fontSize: '0.8rem', color: '#ff5f56' }}>LIVE INFERENCE</span>
                </div>
                <div className="en-text" style={{ fontSize: '0.75rem', color: '#8b949e' }}>Model: YOLOv8-Nano</div>
            </div>
            <div className={styles.cvViewport} id="cv-viewport" ref={viewportRef}>
                <div className={styles.cvGrid}></div>
                <div className={styles.scanLine}></div>
            </div>
        </div>
    );
}
