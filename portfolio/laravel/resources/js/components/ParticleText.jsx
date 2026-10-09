import { useEffect, useRef } from 'react';

export default function ParticleText({
    text = 'ARIODEVS',
    colors = ['#3b82f6', '#8b5cf6', '#00f2fe'],
    fontFamily = 'Inter, Arial, sans-serif',
    fontWeight = 800,
    gap = 4,
    particleSize = 1.6,
    mouseRadius = 30,
    mouseForce = 10,
    ease = 0.08,
    friction = 0.50,
    drift = 1.3,
    height = 280,
    className = '',
}) {
    const canvasRef = useRef(null);

    useEffect(() => {
        const canvas = canvasRef.current;
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        const dpr = Math.min(window.devicePixelRatio || 1, 2);
        const mouse = { x: -9999, y: -9999 };
        let particles = [];
        let width = 0;
        let rafId;

        function build() {
            width = canvas.parentElement.clientWidth;
            canvas.width = width * dpr;
            canvas.height = height * dpr;
            canvas.style.width = `${width}px`;
            canvas.style.height = `${height}px`;
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);

            const off = document.createElement('canvas');
            off.width = width;
            off.height = height;
            const octx = off.getContext('2d');
            let fontSize = height * 0.7;
            octx.font = `${fontWeight} ${fontSize}px ${fontFamily}`;
            const measured = octx.measureText(text).width;
            if (measured > width * 0.95) {
                fontSize *= (width * 0.95) / measured;
                octx.font = `${fontWeight} ${fontSize}px ${fontFamily}`;
            }
            octx.textAlign = 'center';
            octx.textBaseline = 'middle';
            octx.fillStyle = '#fff';
            octx.fillText(text, width / 2, height / 2);

            const data = octx.getImageData(0, 0, width, height).data;
            particles = [];
            for (let y = 0; y < height; y += gap) {
                for (let x = 0; x < width; x += gap) {
                    if (data[(y * width + x) * 4 + 3] > 128) {
                        particles.push({
                            x: Math.random() * width,
                            y: Math.random() * height,
                            hx: x,
                            hy: y,
                            vx: 0,
                            vy: 0,
                            phase: Math.random() * Math.PI * 2,
                            speed: 0.0006 + Math.random() * 0.0008,
                            color: colors[Math.floor(Math.random() * colors.length)],
                        });
                    }
                }
            }
        }

        function animate(now = 0) {
            ctx.clearRect(0, 0, width, height);
            for (const p of particles) {
                const t = now * p.speed + p.phase;
                const tx = p.hx + Math.sin(t) * drift;
                const ty = p.hy + Math.cos(t * 1.3) * drift;
                const dx = mouse.x - p.x;
                const dy = mouse.y - p.y;
                const dist = Math.hypot(dx, dy);
                if (dist < mouseRadius && dist > 0) {
                    const f = (1 - dist / mouseRadius) * mouseForce;
                    p.vx -= (dx / dist) * f;
                    p.vy -= (dy / dist) * f;
                }
                p.vx += (tx - p.x) * ease;
                p.vy += (ty - p.y) * ease;
                p.vx *= friction;
                p.vy *= friction;
                p.x += p.vx;
                p.y += p.vy;
                ctx.fillStyle = p.color;
                ctx.beginPath();
                ctx.arc(p.x, p.y, particleSize, 0, Math.PI * 2);
                ctx.fill();
            }
            rafId = requestAnimationFrame(animate);
        }

        function onMove(e) {
            const rect = canvas.getBoundingClientRect();
            const point = e.touches ? e.touches[0] : e;
            mouse.x = point.clientX - rect.left;
            mouse.y = point.clientY - rect.top;
        }
        function onLeave() {
            mouse.x = mouse.y = -9999;
        }

        build();
        animate();
        window.addEventListener('resize', build);
        canvas.addEventListener('mousemove', onMove);
        canvas.addEventListener('touchmove', onMove, { passive: true });
        canvas.addEventListener('mouseleave', onLeave);
        canvas.addEventListener('touchend', onLeave);

        return () => {
            cancelAnimationFrame(rafId);
            window.removeEventListener('resize', build);
            canvas.removeEventListener('mousemove', onMove);
            canvas.removeEventListener('touchmove', onMove);
            canvas.removeEventListener('mouseleave', onLeave);
            canvas.removeEventListener('touchend', onLeave);
        };
    }, [text, colors, fontFamily, fontWeight, gap, particleSize, mouseRadius, mouseForce, ease, friction, drift, height]);

    return (
        <div className={className} style={{ width: '100%' }}>
            <canvas ref={canvasRef} aria-label={text} role="img" />
        </div>
    );
}
