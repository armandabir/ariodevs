import React, { useEffect, useRef } from 'react';
import { spring } from 'motion';
import {
    MOTION_MARK_PATH,
    MARK_WIDTH,
    MARK_HEIGHT,
    MARK_SCALE,
    DEFAULT_SETTINGS,
    MARK_CORE_TUNE,
    PALETTES,
    GRADE_COLOURS,
} from './sphereConfig';
import { sphereVertexShader, sphereFragmentShader } from './sphereShader';

function fract(x) {
    return x - Math.floor(x);
}

// Generates uniform Fibonacci sphere distribution
function fibonacciSphere(index, total) {
    const y = 1 - 2 * (index + 0.5) / total;
    const radius = Math.sqrt(Math.max(0, 1 - y * y));
    const goldenAngle = index * 2.39996323;
    return [Math.cos(goldenAngle) * radius, y, Math.sin(goldenAngle) * radius];
}

// 2D Mark Path sampling cache
let markPathTester = null;
function isInsideMark(x, y) {
    if (!markPathTester && typeof document !== 'undefined') {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        const path = new Path2D(MOTION_MARK_PATH);
        const scaleY = (MARK_SCALE * MARK_HEIGHT) / MARK_WIDTH;
        markPathTester = (px, py) => {
            return ctx.isPointInPath(
                path,
                ((px + MARK_SCALE / 2) / MARK_SCALE) * MARK_WIDTH,
                ((scaleY / 2 - py) / scaleY) * MARK_HEIGHT
            );
        };
    }
    return markPathTester ? markPathTester(x, y) : false;
}

let sampledMarkPoints = null;
function getMarkPoints(depthExtent = 0.12) {
    if (!sampledMarkPoints) {
        sampledMarkPoints = [];
        for (let r = 0; sampledMarkPoints.length < 16000 && r < 600000; r++) {
            const rx = (fract(Math.sin(r * 12.9898) * 43758.5453) * 2 - 1) * (MARK_SCALE / 2);
            const ry = (fract(Math.sin(r * 78.233) * 12345.678) * 2 - 1) * 0.32;
            if (isInsideMark(rx, ry)) {
                const rz = (fract(Math.sin(r * 39.425) * 24634.6345) * 2 - 1) * depthExtent;
                sampledMarkPoints.push([rx, ry, rz]);
            }
        }
    }
    return sampledMarkPoints;
}

// Point distribution for outer sphere + markCore
function samplePoint(index, sphereTotal, tune) {
    if (index < sphereTotal) {
        return fibonacciSphere(index, sphereTotal);
    }
    const markPts = getMarkPoints(0.12);
    const [mx, my, mz] = markPts[(index - sphereTotal) % markPts.length];
    const s = mx * tune.size;
    const p = my * tune.size;
    const h = Math.sqrt(Math.max(0, 0.92 - s * s - p * p));
    const y = mz * h * tune.depth;
    const tiltRad = (tune.tilt * Math.PI) / 180;
    const cosT = Math.cos(tiltRad);
    const sinT = Math.sin(tiltRad);
    return [s, cosT * p - sinT * y, sinT * p + cosT * y];
}

export default function SphereScene({ isReducedMotion = false, tone = 'gold' }) {
    const canvasRef = useRef(null);

    useEffect(() => {
        const canvas = canvasRef.current;
        if (!canvas) return;

        const gl = canvas.getContext('webgl', {
            alpha: true,
            premultipliedAlpha: true,
            antialias: false,
            powerPreference: 'high-performance',
        });
        if (!gl) return;

        function compileShader(type, src) {
            const shader = gl.createShader(type);
            gl.shaderSource(shader, src);
            gl.compileShader(shader);
            if (!gl.getShaderParameter(shader, gl.COMPILE_STATUS)) {
                console.error('Shader compile error:', gl.getShaderInfoLog(shader));
                gl.deleteShader(shader);
                return null;
            }
            return shader;
        }

        const vs = compileShader(gl.VERTEX_SHADER, sphereVertexShader);
        const fs = compileShader(gl.FRAGMENT_SHADER, sphereFragmentShader);
        if (!vs || !fs) return;

        const program = gl.createProgram();
        gl.attachShader(program, vs);
        gl.attachShader(program, fs);
        gl.linkProgram(program);

        if (!gl.getProgramParameter(program, gl.LINK_STATUS)) {
            console.error('Program link error:', gl.getProgramInfoLog(program));
            return;
        }
        gl.useProgram(program);

        // Build vertex attributes: 12000 sphere points + 5800 markCore points
        const SPHERE_POINTS = 12000;
        const LOGO_POINTS = Math.round(MARK_CORE_TUNE.logoPoints);
        const TOTAL_POINTS = SPHERE_POINTS + LOGO_POINTS;

        const posTipBuffer = [];
        for (let i = 0; i < TOTAL_POINTS; i++) {
            const [x, y, z] = samplePoint(i, SPHERE_POINTS, MARK_CORE_TUNE);
            for (const tip of [0, 1 / 3, 1 / 3, 2 / 3, 2 / 3, 1]) {
                posTipBuffer.push(x, y, z, tip);
            }
        }

        const vbo = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, vbo);
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(posTipBuffer), gl.STATIC_DRAW);

        const aPositionLoc = gl.getAttribLocation(program, 'aPosition');
        const aTipLoc = gl.getAttribLocation(program, 'aTip');
        const aColourLoc = gl.getAttribLocation(program, 'aColour');

        gl.enableVertexAttribArray(aPositionLoc);
        gl.vertexAttribPointer(aPositionLoc, 3, gl.FLOAT, false, 16, 0);

        gl.enableVertexAttribArray(aTipLoc);
        gl.vertexAttribPointer(aTipLoc, 1, gl.FLOAT, false, 16, 12);

        gl.disableVertexAttribArray(aColourLoc);
        gl.vertexAttrib4f(aColourLoc, 0, 0, 0, 0);

        // Uniforms lookup
        const uniformNames = [
            'uOrdered',
            'uSpringWave[0]',
            'uBurstSpin',
            'uCloud',
            'uEnter',
            'uBurst',
            'uBurstDirection',
            'uBurstRotation',
            'uOuterPulse',
            'uDebris',
            'uHitDirections[0]',
            'uSettings',
            'uBlur',
            'uNoisePulse',
            'uShell',
            'uSize',
            'uRotation',
            'uPointer',
            'uImpacts[0]',
            'uTime',
            'uOrb',
            'uLines',
            'uDpr',
            'uShade',
            'uLight',
            'uImpact',
            'uSweepShade',
            'uSweepLight',
            'uSweep',
            'uDotSize',
            'uDotBrightness',
            'uGrades',
            'uGradeColours[0]',
            'uZoom',
            'uGradeMap',
            'uFrames',
            'uFrameState[0]',
            'uFramePulse',
            'uBurstFrame',
            'uSheet',
        ];

        const uniforms = {};
        for (const name of uniformNames) {
            uniforms[name] = gl.getUniformLocation(program, name);
        }

        // Palette setup
        const activePalette = PALETTES[tone] || PALETTES.gold;
        gl.uniform3fv(uniforms.uShade, activePalette[0]);
        gl.uniform3fv(uniforms.uLight, activePalette[1]);
        gl.uniform3fv(uniforms.uImpact, activePalette[2]);

        gl.uniform1f(uniforms.uSweep, 0);
        gl.uniform3fv(uniforms.uSweepShade, activePalette[0]);
        gl.uniform3fv(uniforms.uSweepLight, activePalette[1]);

        gl.uniform1f(uniforms.uOrdered, 0);
        gl.uniform1f(uniforms.uDotSize, MARK_CORE_TUNE.dotSize);
        gl.uniform1f(uniforms.uDotBrightness, MARK_CORE_TUNE.brightness);
        gl.uniform1f(uniforms.uGrades, 0);
        gl.uniform3fv(uniforms['uGradeColours[0]'], GRADE_COLOURS.flat());
        gl.uniform3fv(uniforms.uGradeMap, [0, 0, 1]);
        gl.uniform1f(uniforms.uFrames, 0);
        gl.uniform1f(uniforms.uSheet, 0);

        // Precompute spring wave (64 samples) matching Motion spring physics
        const springGenerator = spring({
            keyframes: [0, 0],
            velocity: 12,
            stiffness: 100,
            damping: 8,
            restDelta: 0.001,
        });
        const springWaveValues = new Float32Array(64);
        for (let i = 0; i < 64; i++) {
            springWaveValues[i] = springGenerator.next((i / 24) * 1000).value;
        }
        gl.uniform1fv(uniforms['uSpringWave[0]'], springWaveValues);

        gl.enable(gl.BLEND);
        gl.blendFunc(gl.ONE, gl.ONE_MINUS_SRC_ALPHA);

        // Sizing & viewport tracking
        let width = 1;
        let height = 1;
        let left = 0;
        let top = 0;
        let dpr = 1;

        const updateSize = () => {
            const rect = canvas.getBoundingClientRect();
            width = rect.width;
            height = rect.height;
            left = rect.left;
            top = rect.top;
            dpr = Math.min(window.devicePixelRatio || 1, 2);

            const displayW = Math.round(width * dpr);
            const displayH = Math.round(height * dpr);

            if (canvas.width !== displayW || canvas.height !== displayH) {
                canvas.width = displayW;
                canvas.height = displayH;
            }

            gl.viewport(0, 0, canvas.width, canvas.height);
            gl.uniform2f(uniforms.uSize, width, height);
            gl.uniform1f(uniforms.uDpr, dpr);
            gl.uniform1f(uniforms.uZoom, 1.0);
        };

        updateSize();
        const resizeObserver = new ResizeObserver(updateSize);
        resizeObserver.observe(canvas);

        let isVisible = true;
        const intersectionObserver = new IntersectionObserver(([entry]) => {
            isVisible = entry.isIntersecting;
        });
        intersectionObserver.observe(canvas);

        // State & Physics
        let time = 0;
        let enterElapsed = 0;
        let yaw = -Math.PI / 2;
        let pitch = (MARK_CORE_TUNE.tilt * Math.PI) / 180;
        let targetYaw = yaw;
        let targetPitch = pitch;
        let yawVelocity = MARK_CORE_TUNE.spin;
        let pitchVelocity = 0;
        let isRevealing = true;

        let pointerX = -1000;
        let pointerY = -1000;
        let targetPointerX = pointerX;
        let targetPointerY = pointerY;
        let pointerActive = 0;
        let pointerInteracting = 0;

        let isDragging = false;
        let dragStartX = 0;
        let dragStartY = 0;
        let dragStartTime = 0;
        let prevDragX = 0;
        let prevDragY = 0;
        let prevDragTime = 0;
        let hasMovedSignificantly = false;

        const impactTimes = new Float32Array(16);
        const hitDirections = new Float32Array(12);
        let nextImpactIdx = 0;
        const bursts = [];

        // Launch impact shockwave & radial debris
        const triggerImpact = (clientX, clientY, strength = 1, spin = [0, 0]) => {
            const orbRadius = Math.min(width * 0.29, height * 0.275);
            let nx = (clientX - width * 0.53) / orbRadius;
            let ny = -(clientY - height * 0.47) / orbRadius;
            const dist = Math.hypot(nx, ny);
            if (dist > 1) {
                nx /= dist;
                ny /= dist;
            }
            const nz = Math.sqrt(Math.max(0, 1 - nx * nx - ny * ny));
            const rotY = Math.cos(pitch) * ny - Math.sin(pitch) * nz;
            const rotZ = Math.sin(pitch) * ny + Math.cos(pitch) * nz;
            const dir = [
                Math.cos(yaw) * nx - Math.sin(yaw) * rotZ,
                rotY,
                Math.sin(yaw) * nx + Math.cos(yaw) * rotZ,
            ];

            bursts.push({
                time,
                seed: Math.random(),
                life: strength ? 3 + Math.random() : 2,
                power: strength ? 1 : 0.45,
                direction: dir,
                rotation: [yaw, pitch],
                spin,
            });

            if (strength) {
                hitDirections.set(dir, nextImpactIdx * 3);
                impactTimes.set([clientX, clientY, time, strength], nextImpactIdx * 4);
                nextImpactIdx = (nextImpactIdx + 1) % 4;
            }
        };

        // Pointer event listeners
        const handlePointerMove = (e) => {
            targetPointerX = e.clientX - left;
            targetPointerY = e.clientY - top;
            if (!pointerActive && pointerInteracting < 0.01) {
                pointerX = targetPointerX;
                pointerY = targetPointerY;
            }
            pointerActive = 1;

            if (isDragging) {
                if (Math.hypot(e.clientX - dragStartX, e.clientY - dragStartY) > 6) {
                    hasMovedSignificantly = true;
                }
                const dx = e.clientX - prevDragX;
                const dy = e.clientY - prevDragY;
                const dt = Math.max(0.008, (e.timeStamp - prevDragTime) / 1000);

                targetYaw += dx * 0.003;
                targetPitch -= dy * 0.003;

                const blend = 1 - Math.exp(-dt / 0.04);
                yawVelocity += (Math.max(-3, Math.min(3, (dx * 0.003) / dt)) - yawVelocity) * blend;
                pitchVelocity += (Math.max(-3, Math.min(3, (-dy * 0.003) / dt)) - pitchVelocity) * blend;

                prevDragX = e.clientX;
                prevDragY = e.clientY;
                prevDragTime = e.timeStamp;
            }
        };

        const handlePointerDown = (e) => {
            if (e.button !== 0) return;
            isDragging = true;
            isRevealing = false;
            yawVelocity = 0;
            pitchVelocity = 0;
            handlePointerMove(e);
            dragStartX = e.clientX;
            dragStartY = e.clientY;
            dragStartTime = e.timeStamp;
            hasMovedSignificantly = false;
            prevDragX = e.clientX;
            prevDragY = e.clientY;
            prevDragTime = e.timeStamp;
            if (canvas.setPointerCapture) {
                try { canvas.setPointerCapture(e.pointerId); } catch {}
            }
        };

        const handlePointerUp = (e) => {
            if (!isDragging) return;
            if (
                e.type === 'pointerup' &&
                e.button === 0 &&
                !hasMovedSignificantly &&
                Math.hypot(e.clientX - dragStartX, e.clientY - dragStartY) <= 6
            ) {
                const pressDuration = Math.max(0, e.timeStamp - dragStartTime);
                const strength = 0.15 + 0.85 * Math.exp(-Math.max(0, pressDuration - 80) / 350);
                triggerImpact(e.clientX - left, e.clientY - top, strength);
            }
            const decay = Math.exp(-Math.max(0, e.timeStamp - prevDragTime) / 90);
            yawVelocity *= decay;
            pitchVelocity *= decay;
            isDragging = false;
            if (canvas.hasPointerCapture && canvas.hasPointerCapture(e.pointerId)) {
                try { canvas.releasePointerCapture(e.pointerId); } catch {}
            }
        };

        const handlePointerLeave = () => {
            if (!isDragging) {
                pointerActive = 0;
            }
        };

        canvas.addEventListener('pointermove', handlePointerMove);
        canvas.addEventListener('pointerdown', handlePointerDown);
        window.addEventListener('pointerup', handlePointerUp);
        window.addEventListener('pointercancel', handlePointerUp);
        canvas.addEventListener('pointerleave', handlePointerLeave);

        // Initial burst on mount
        const initialTimer = setTimeout(() => {
            triggerImpact(width * 0.53, height * 0.47, 0.85);
        }, 300);

        // Render loop
        let animationFrameId;
        let lastTimestamp = performance.now();

        const render = (now) => {
            animationFrameId = requestAnimationFrame(render);
            if (!isVisible || document.hidden) {
                lastTimestamp = now;
                return;
            }

            const dt = Math.min((now - lastTimestamp) / 1000, 0.05);
            lastTimestamp = now;
            enterElapsed += dt;

            // Entrance reveal easing
            const enterU0 = isReducedMotion
                ? 1
                : 1 - Math.pow(1 - Math.min(1, enterElapsed / 1.4), 3);
            const enterU1 = isReducedMotion
                ? 1
                : 1 - Math.pow(1 - Math.min(1, Math.max(0, enterElapsed - 0.16) / 1.4), 3);
            gl.uniform2f(uniforms.uEnter, enterU0, enterU1);

            // Pointer interpolation
            const pointerSpeed = 1 - Math.exp(-dt / 0.045);
            pointerX += (targetPointerX - pointerX) * pointerSpeed;
            pointerY += (targetPointerY - pointerY) * pointerSpeed;
            pointerInteracting += (pointerActive - pointerInteracting) * (1 - Math.exp(-dt / 0.1));

            // Continuous rotation
            if (!isReducedMotion) {
                time += dt;
                if (!isDragging && isRevealing) {
                    const rev = Math.min(1, time / MARK_CORE_TUNE.reveal);
                    targetYaw = -Math.PI / 2 + (Math.PI / 2) * (1 - Math.pow(1 - rev, 3)) + MARK_CORE_TUNE.spin * time;
                    if (rev === 1) isRevealing = false;
                } else if (!isDragging) {
                    targetYaw += yawVelocity * dt;
                    targetPitch += pitchVelocity * dt;
                    yawVelocity = MARK_CORE_TUNE.spin + (yawVelocity - MARK_CORE_TUNE.spin) * Math.exp(-dt / 1.6);
                    pitchVelocity *= Math.exp(-dt / 1.6);

                    const swayFactor = 1 - Math.exp(-dt / 2.4);
                    targetYaw += (Math.sin(time * 0.3) * 0.22 - targetYaw) * swayFactor * 0.1;
                }
                yaw += (targetYaw - yaw) * pointerSpeed;
                pitch += (targetPitch - pitch) * pointerSpeed;
            }

            // Uniforms
            gl.uniform1f(uniforms.uCloud, 0);
            gl.uniform4f(
                uniforms.uSettings,
                DEFAULT_SETTINGS.brightness,
                DEFAULT_SETTINGS.noise,
                DEFAULT_SETTINGS.shell,
                DEFAULT_SETTINGS.spread
            );
            gl.uniform1f(uniforms.uBlur, DEFAULT_SETTINGS.blur);
            gl.uniform1f(uniforms.uNoisePulse, 0);
            gl.uniform1f(uniforms.uOuterPulse, 0);
            gl.uniform1f(uniforms.uShell, 0);
            gl.uniform1f(uniforms.uDebris, 0);
            gl.uniform3fv(uniforms['uHitDirections[0]'], hitDirections);

            gl.clearColor(0, 0, 0, 0);
            gl.clear(gl.COLOR_BUFFER_BIT);

            gl.uniform1f(uniforms.uTime, time);
            gl.uniform1f(uniforms.uOrb, 1.0);
            gl.uniform2f(uniforms.uRotation, yaw, pitch);
            gl.uniform3f(uniforms.uPointer, pointerX, pointerY, isReducedMotion ? 0 : pointerInteracting);
            gl.uniform4fv(uniforms['uImpacts[0]'], impactTimes);

            // Pass 1: Outer Shell Strands
            gl.vertexAttribPointer(aPositionLoc, 3, gl.FLOAT, false, 96, 80);
            gl.vertexAttribPointer(aTipLoc, 1, gl.FLOAT, false, 96, 92);
            gl.uniform1f(uniforms.uLines, 0);
            gl.uniform1f(uniforms.uShell, 1.0);
            gl.drawArrays(gl.POINTS, 0, posTipBuffer.length / 24);

            // Pass 2: Core Strands
            gl.uniform1f(uniforms.uShell, 0.0);
            gl.uniform1f(uniforms.uLines, 0.0);
            gl.drawArrays(gl.POINTS, 0, posTipBuffer.length / 24);

            // Pass 3: Interactive Hover Cloud
            if (pointerInteracting > 0.01 && !isReducedMotion) {
                gl.uniform1f(uniforms.uCloud, 1.0);
                gl.drawArrays(gl.POINTS, 0, posTipBuffer.length / 24);
                gl.uniform1f(uniforms.uCloud, 0.0);
            }

            // Pass 4: Debris Bursts
            if (!isReducedMotion && bursts.length > 0) {
                gl.uniform1f(uniforms.uDebris, 1.0);
                for (let i = bursts.length - 1; i >= 0; i--) {
                    const b = bursts[i];
                    if (time - b.time >= b.life) {
                        bursts.splice(i, 1);
                        continue;
                    }
                    gl.uniform4f(uniforms.uBurst, b.time, b.seed, b.life, b.power);
                    gl.uniform3f(uniforms.uBurstDirection, b.direction[0], b.direction[1], b.direction[2]);
                    gl.uniform2f(uniforms.uBurstRotation, b.rotation[0], b.rotation[1]);
                    gl.uniform2f(uniforms.uBurstSpin, b.spin[0], b.spin[1]);
                    gl.uniform1f(uniforms.uBurstFrame, -1);
                    gl.drawArrays(gl.POINTS, 0, posTipBuffer.length / 24);
                }
            }
        };

        animationFrameId = requestAnimationFrame(render);

        return () => {
            clearTimeout(initialTimer);
            cancelAnimationFrame(animationFrameId);
            resizeObserver.disconnect();
            intersectionObserver.disconnect();
            canvas.removeEventListener('pointermove', handlePointerMove);
            canvas.removeEventListener('pointerdown', handlePointerDown);
            window.removeEventListener('pointerup', handlePointerUp);
            window.removeEventListener('pointercancel', handlePointerUp);
            canvas.removeEventListener('pointerleave', handlePointerLeave);

            gl.deleteBuffer(vbo);
            gl.deleteProgram(program);
            gl.deleteShader(vs);
            gl.deleteShader(fs);
        };
    }, [isReducedMotion, tone]);

    return (
        <canvas
            ref={canvasRef}
            aria-hidden="true"
            style={{
                width: '100%',
                height: '100%',
                display: 'block',
                cursor: 'grab',
                touchAction: 'none',
            }}
        />
    );
}
