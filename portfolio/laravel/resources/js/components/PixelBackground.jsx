import React, { useEffect, useRef } from 'react';
import styles from '../../css/styles/PixelBackground.module.css';

/**
 * PixelArtBackground
 * Retro 8-bit / 16-bit animated background in the aesthetic of Fan Studio / arcade websites.
 * Features:
 * - Pixel grid dithered stars and twinkling pixel clusters
 * - Retro floating 8-bit pixel clouds / drifting atmospheric pixel blocks
 * - Shooting pixel meteors / pixel dust
 * - Interactive mouse repulsion / pixel ripple trail
 * - Seamless adaptation to dark and light (paper & ink) themes
 */
export default function PixelBackground({ theme = 'light' }) {
    const canvasRef = useRef(null);

    useEffect(() => {
        const canvas = canvasRef.current;
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        if (!ctx) return;

        let animationFrameId;
        let width = 0;
        let height = 0;

        // Pixel scale factor: 1 virtual pixel = 4 screen pixels for authentic retro crunch
        const PIXEL_SIZE = 4;
        let cols = 0;
        let rows = 0;

        // Palette definitions
        const isDark = theme === 'dark';
        const colors = isDark
            ? {
                  star1: 'rgba(199, 255, 0, 0.45)', // Lime
                  star2: 'rgba(216, 81, 16, 0.4)',  // Orange
                  star3: 'rgba(235, 228, 220, 0.3)', // Off-white
                  starDim: 'rgba(160, 164, 134, 0.25)', // Olive
                  cloud: 'rgba(32, 37, 27, 0.5)',
                  cloudHighlight: 'rgba(160, 164, 134, 0.2)',
                  dust: 'rgba(199, 255, 0, 0.3)',
              }
            : {
                  star1: 'rgba(216, 81, 16, 0.35)', // Warm orange
                  star2: 'rgba(160, 164, 134, 0.45)', // Olive
                  star3: 'rgba(17, 20, 16, 0.25)', // Ink
                  starDim: 'rgba(170, 169, 155, 0.35)', // Muted line
                  cloud: 'rgba(210, 204, 192, 0.45)',
                  cloudHighlight: 'rgba(242, 238, 228, 0.65)',
                  dust: 'rgba(201, 40, 43, 0.25)',
              };

        // Twinkling stars / pixel glints
        const starCount = 65;
        const stars = [];

        // 8-bit retro clouds (pixel matrix)
        const cloudCount = 5;
        const clouds = [];

        // Pixel dust / floating particles
        const dustCount = 30;
        const dustParticles = [];

        // Mouse interaction
        let mouseX = -1000;
        let mouseY = -1000;
        const handleMouseMove = (e) => {
            mouseX = Math.floor(e.clientX / PIXEL_SIZE);
            mouseY = Math.floor(e.clientY / PIXEL_SIZE);
        };
        const handleMouseLeave = () => {
            mouseX = -1000;
            mouseY = -1000;
        };

        window.addEventListener('mousemove', handleMouseMove, { passive: true });
        window.addEventListener('mouseleave', handleMouseLeave);

        const initScene = () => {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
            cols = Math.ceil(width / PIXEL_SIZE);
            rows = Math.ceil(height / PIXEL_SIZE);

            // Seed stars
            stars.length = 0;
            for (let i = 0; i < starCount; i++) {
                stars.push({
                    x: Math.floor(Math.random() * cols),
                    y: Math.floor(Math.random() * rows),
                    baseColor: [colors.star1, colors.star2, colors.star3, colors.starDim][
                        Math.floor(Math.random() * 4)
                    ],
                    twinkleSpeed: 0.02 + Math.random() * 0.04,
                    phase: Math.random() * Math.PI * 2,
                    isCross: Math.random() > 0.7, // 4-pointed 8-bit star
                });
            }

            // Seed pixel clouds (procedural 8-bit horizontal pixel chunks)
            clouds.length = 0;
            for (let i = 0; i < cloudCount; i++) {
                const cloudWidth = 14 + Math.floor(Math.random() * 18);
                const cloudHeight = 4 + Math.floor(Math.random() * 4);
                // Create pixel mask for cloud
                const grid = [];
                for (let cy = 0; cy < cloudHeight; cy++) {
                    const row = [];
                    for (let cx = 0; cx < cloudWidth; cx++) {
                        // Oval shaped probability
                        const dx = (cx - cloudWidth / 2) / (cloudWidth / 2);
                        const dy = (cy - cloudHeight / 2) / (cloudHeight / 2);
                        const dist = dx * dx + dy * dy;
                        row.push(dist < 0.75 ? 1 : 0);
                    }
                    grid.push(row);
                }

                clouds.push({
                    x: Math.random() * cols,
                    y: Math.floor(Math.random() * (rows * 0.75)),
                    speed: 0.05 + Math.random() * 0.08,
                    grid,
                    width: cloudWidth,
                    height: cloudHeight,
                });
            }

            // Seed dust particles
            dustParticles.length = 0;
            for (let i = 0; i < dustCount; i++) {
                dustParticles.push({
                    x: Math.random() * cols,
                    y: Math.random() * rows,
                    vx: (Math.random() - 0.5) * 0.15,
                    vy: 0.05 + Math.random() * 0.15,
                    size: Math.random() > 0.85 ? 2 : 1,
                });
            }
        };

        const handleResize = () => {
            initScene();
        };

        initScene();
        window.addEventListener('resize', handleResize);

        let tick = 0;

        const render = () => {
            tick++;
            ctx.clearRect(0, 0, width, height);

            // 1. Draw animated pixel clouds
            for (let c of clouds) {
                c.x += c.speed;
                if (c.x > cols + c.width) {
                    c.x = -c.width;
                    c.y = Math.floor(Math.random() * (rows * 0.75));
                }

                const startX = Math.floor(c.x);
                const startY = Math.floor(c.y);

                for (let cy = 0; cy < c.height; cy++) {
                    for (let cx = 0; cx < c.width; cx++) {
                        if (c.grid[cy][cx] === 1) {
                            const px = startX + cx;
                            const py = startY + cy;
                            if (px >= 0 && px < cols && py >= 0 && py < rows) {
                                ctx.fillStyle = cy === 0 ? colors.cloudHighlight : colors.cloud;
                                ctx.fillRect(
                                    px * PIXEL_SIZE,
                                    py * PIXEL_SIZE,
                                    PIXEL_SIZE,
                                    PIXEL_SIZE
                                );
                            }
                        }
                    }
                }
            }

            // 2. Draw Twinkling Retro 8-bit Stars
            for (let star of stars) {
                const brightness = Math.sin(tick * star.twinkleSpeed + star.phase);
                if (brightness > -0.3) {
                    ctx.fillStyle = star.baseColor;
                    const sx = star.x * PIXEL_SIZE;
                    const sy = star.y * PIXEL_SIZE;

                    // Draw primary pixel
                    ctx.fillRect(sx, sy, PIXEL_SIZE, PIXEL_SIZE);

                    // If it's a shiny cross star and bright, render 4-directional sparkles
                    if (star.isCross && brightness > 0.6) {
                        ctx.fillStyle = colors.star3;
                        ctx.fillRect(sx - PIXEL_SIZE, sy, PIXEL_SIZE, PIXEL_SIZE);
                        ctx.fillRect(sx + PIXEL_SIZE, sy, PIXEL_SIZE, PIXEL_SIZE);
                        ctx.fillRect(sx, sy - PIXEL_SIZE, PIXEL_SIZE, PIXEL_SIZE);
                        ctx.fillRect(sx, sy + PIXEL_SIZE, PIXEL_SIZE, PIXEL_SIZE);
                    }
                }
            }

            // 3. Draw drifting pixel dust with mouse interaction
            ctx.fillStyle = colors.dust;
            for (let p of dustParticles) {
                p.x += p.vx;
                p.y += p.vy;

                // Gentle mouse repulsion
                const dx = p.x - mouseX;
                const dy = p.y - mouseY;
                const distSq = dx * dx + dy * dy;
                if (distSq < 1600 && distSq > 0) {
                    const force = 0.5 / Math.sqrt(distSq);
                    p.x += dx * force;
                    p.y += dy * force;
                }

                // Wrap around edges
                if (p.y > rows) {
                    p.y = 0;
                    p.x = Math.random() * cols;
                }
                if (p.x < 0) p.x = cols;
                if (p.x > cols) p.x = 0;

                const px = Math.floor(p.x) * PIXEL_SIZE;
                const py = Math.floor(p.y) * PIXEL_SIZE;
                const s = p.size * PIXEL_SIZE;
                ctx.fillRect(px, py, s, s);
            }

            animationFrameId = requestAnimationFrame(render);
        };

        render();

        return () => {
            cancelAnimationFrame(animationFrameId);
            window.removeEventListener('resize', handleResize);
            window.removeEventListener('mousemove', handleMouseMove);
            window.removeEventListener('mouseleave', handleMouseLeave);
        };
    }, [theme]);

    return (
        <canvas
            ref={canvasRef}
            className={styles.pixelBackgroundCanvas}
            aria-hidden="true"
        />
    );
}
