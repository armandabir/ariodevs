import React, { useEffect, useRef } from 'react';

export default function VectorSpace() {
    const canvasRef = useRef(null);

    useEffect(() => {
        const canvas = canvasRef.current;
        if (!canvas) return;
        const ctx = canvas.getContext('2d');

        let width, height;
        let particles = [];
        const numParticles = 40;
        const connectionDistance = 80;
        let animationId;
        let intervalId;

        function resize() {
            const parent = canvas.parentElement;
            width = parent.clientWidth;
            height = parent.clientHeight;
            canvas.width = width * window.devicePixelRatio;
            canvas.height = height * window.devicePixelRatio;
            ctx.scale(window.devicePixelRatio, window.devicePixelRatio);
        }

        window.addEventListener('resize', resize);
        resize();

        class Particle {
            constructor(isQuery = false) {
                this.x = Math.random() * width;
                this.y = Math.random() * height;
                this.vx = (Math.random() - 0.5) * 0.5;
                this.vy = (Math.random() - 0.5) * 0.5;
                this.isQuery = isQuery;
                this.radius = isQuery ? 4 : 2;
                this.color = isQuery ? '#a855f7' : '#4b5563';
            }

            update() {
                this.x += this.vx;
                this.y += this.vy;

                if (this.x < 0 || this.x > width) this.vx *= -1;
                if (this.y < 0 || this.y > height) this.vy *= -1;
            }

            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                ctx.fillStyle = this.color;
                if (this.isQuery) {
                    ctx.shadowBlur = 10;
                    ctx.shadowColor = this.color;
                }
                ctx.fill();
                ctx.shadowBlur = 0;
            }
        }

        for (let i = 0; i < numParticles; i++) {
            particles.push(new Particle());
        }

        let queryParticle = new Particle(true);
        particles.push(queryParticle);

        let pulseRadius = 0;
        let pulseActive = false;
        let pulseX, pulseY;

        function drawPulse(x, y) {
            pulseActive = true;
            pulseRadius = 0;
            pulseX = x;
            pulseY = y;
        }

        intervalId = setInterval(() => {
            queryParticle.x = Math.random() * width;
            queryParticle.y = Math.random() * height;
            drawPulse(queryParticle.x, queryParticle.y);
        }, 4000);

        function animate() {
            ctx.clearRect(0, 0, width, height);

            if (pulseActive) {
                ctx.beginPath();
                ctx.arc(pulseX, pulseY, pulseRadius, 0, Math.PI * 2);
                ctx.strokeStyle = `rgba(168, 85, 247, ${1 - pulseRadius / 100})`;
                ctx.lineWidth = 2;
                ctx.stroke();
                pulseRadius += 2;
                if (pulseRadius > 100) pulseActive = false;
            }

            particles.forEach((p) => p.update());

            for (let i = 0; i < particles.length; i++) {
                for (let j = i + 1; j < particles.length; j++) {
                    let dx = particles[i].x - particles[j].x;
                    let dy = particles[i].y - particles[j].y;
                    let distance = Math.sqrt(dx * dx + dy * dy);

                    if (distance < connectionDistance) {
                        ctx.beginPath();
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y);

                        let isQueryConnection = particles[i].isQuery || particles[j].isQuery;
                        let opacity = 1 - distance / connectionDistance;

                        ctx.strokeStyle = isQueryConnection
                            ? `rgba(168, 85, 247, ${opacity})`
                            : `rgba(100, 116, 139, ${opacity * 0.3})`;

                        ctx.lineWidth = isQueryConnection ? 1.5 : 0.5;
                        ctx.stroke();
                    }
                }
            }

            particles.forEach((p) => p.draw());
            animationId = requestAnimationFrame(animate);
        }

        animate();

        return () => {
            window.removeEventListener('resize', resize);
            clearInterval(intervalId);
            cancelAnimationFrame(animationId);
        };
    }, []);

    return (
        <div className="bento-box bento-medium reveal vector-box">
            <div className="vector-header">
                <span className="en-text" style={{ color: '#a855f7', fontWeight: 'bold' }}>VECTOR DB</span>
                <span className="en-text" style={{ fontSize: '0.75rem', color: '#8b949e' }}>Semantic Clustering</span>
            </div>
            <div className="canvas-container" id="vector-container">
                <canvas id="vector-canvas" ref={canvasRef}></canvas>
            </div>
        </div>
    );
}
