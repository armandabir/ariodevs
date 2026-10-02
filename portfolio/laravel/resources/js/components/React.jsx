import React, { useEffect, useRef } from 'react';
import styles from '../../css/styles/React.module.scss';

export default function React() {
    const canvasRef = useRef(null);

    useEffect(() => {
        const canvas = canvasRef.current;
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        let width, height;
        let animationId;

        const colors = {
            node: '#4facfe',
            nodeGlow: 'rgba(79, 172, 254, 0.5)',
            line: 'rgba(255, 255, 255, 0.05)',
            signal: '#00f2fe',
        };

        const layerStructure = [3, 4, 4, 2];
        let nodes = [];
        let links = [];
        let signals = [];

        function resizeCanvas() {
            const parent = canvas.parentElement;
            width = parent.clientWidth;
            height = parent.clientHeight;
            canvas.width = width * window.devicePixelRatio;
            canvas.height = height * window.devicePixelRatio;
            ctx.scale(window.devicePixelRatio, window.devicePixelRatio);
            initNetwork();
        }

        window.addEventListener('resize', resizeCanvas);

        function initNetwork() {
            nodes = [];
            links = [];
            signals = [];

            const layerCount = layerStructure.length;
            const paddingX = 40;
            const layerSpacing = (width - paddingX * 2) / (layerCount - 1);

            layerStructure.forEach((nodeCount, layerIndex) => {
                const x = paddingX + layerIndex * layerSpacing;
                const paddingY = 20;
                const nodeSpacing = (height - paddingY * 2) / (nodeCount === 1 ? 1 : nodeCount - 1);

                for (let i = 0; i < nodeCount; i++) {
                    const y = nodeCount === 1 ? height / 2 : paddingY + i * nodeSpacing;
                    nodes.push({ id: `${layerIndex}-${i}`, x, y, layer: layerIndex });
                }
            });

            for (let i = 0; i < layerCount - 1; i++) {
                const currentLayerNodes = nodes.filter((n) => n.layer === i);
                const nextLayerNodes = nodes.filter((n) => n.layer === i + 1);

                currentLayerNodes.forEach((source) => {
                    nextLayerNodes.forEach((target) => {
                        links.push({ source, target });
                    });
                });
            }
        }

        class Signal {
            constructor(link) {
                this.link = link;
                this.progress = 0;
                this.speed = 0.01 + Math.random() * 0.015;
                this.size = 2 + Math.random() * 1.5;
            }

            update() {
                this.progress += this.speed;
                return this.progress >= 1;
            }

            draw(ctx) {
                const x = this.link.source.x + (this.link.target.x - this.link.source.x) * this.progress;
                const y = this.link.source.y + (this.link.target.y - this.link.source.y) * this.progress;

                ctx.beginPath();
                ctx.arc(x, y, this.size, 0, Math.PI * 2);
                ctx.fillStyle = colors.signal;
                ctx.shadowBlur = 10;
                ctx.shadowColor = colors.signal;
                ctx.fill();
                ctx.shadowBlur = 0;
            }
        }

        function spawnSignals() {
            if (Math.random() > 0.85) {
                const randomLink = links[Math.floor(Math.random() * links.length)];
                signals.push(new Signal(randomLink));
            }
        }

        function animate() {
            ctx.clearRect(0, 0, width, height);

            ctx.lineWidth = 1;
            links.forEach((link) => {
                ctx.beginPath();
                ctx.moveTo(link.source.x, link.source.y);
                ctx.lineTo(link.target.x, link.target.y);
                ctx.strokeStyle = colors.line;
                ctx.stroke();
            });

            spawnSignals();
            for (let i = signals.length - 1; i >= 0; i--) {
                const signal = signals[i];
                if (signal.update()) {
                    signals.splice(i, 1);
                } else {
                    signal.draw(ctx);
                }
            }

            nodes.forEach((node) => {
                ctx.beginPath();
                ctx.arc(node.x, node.y, 4, 0, Math.PI * 2);
                ctx.fillStyle = colors.node;

                ctx.shadowBlur = 8;
                ctx.shadowColor = colors.nodeGlow;
                ctx.fill();

                ctx.beginPath();
                ctx.arc(node.x, node.y, 8, 0, Math.PI * 2);
                ctx.strokeStyle = 'rgba(79, 172, 254, 0.2)';
                ctx.stroke();
                ctx.shadowBlur = 0;
            });

            animationId = requestAnimationFrame(animate);
        }

        resizeCanvas();
        animate();

        return () => {
            window.removeEventListener('resize', resizeCanvas);
            cancelAnimationFrame(animationId);
        };
    }, []);

    return (
        <div className={`bento-box bento-medium reveal ${styles.nnBox}`}>
            <div className={styles.nnHeader}>
                <h3>شبکه‌عصبی زنده</h3>
                <p className="text-muted" style={{ fontSize: '0.85rem' }}>Data Processing</p>
            </div>
            <div className={styles.canvasContainer}>
                <canvas id="neural-canvas" ref={canvasRef}></canvas>
            </div>
        </div>
    );
}
