document.addEventListener("DOMContentLoaded", () => {
    
    // --- 1. Background Particles Network ---
    const canvas = document.getElementById('network-bg');
    const ctx = canvas.getContext('2d');
    
    let width = canvas.width = window.innerWidth;
    let height = canvas.height = window.innerHeight;
    
    const particles = [];
    const particleCount = window.innerWidth < 768 ? 40 : 90; // کاهش ذرات در موبایل برای پرفورمنس
    const connectionDistance = window.innerWidth < 768 ? 100 : 140;
    
    class Particle {
        constructor() {
            this.x = Math.random() * width;
            this.y = Math.random() * height;
            this.vx = (Math.random() - 0.5) * 1;
            this.vy = (Math.random() - 0.5) * 1;
            this.radius = Math.random() * 2 + 1;
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
            ctx.fillStyle = 'rgba(189, 147, 249, 0.4)';
            ctx.fill();
        }
    }
    
    for (let i = 0; i < particleCount; i++) { particles.push(new Particle()); }
    
    let mouse = { x: null, y: null };
    window.addEventListener('mousemove', (e) => { mouse.x = e.x; mouse.y = e.y; });
    // پشتیبانی از لمس در موبایل
    window.addEventListener('touchstart', (e) => { mouse.x = e.touches[0].clientX; mouse.y = e.touches[0].clientY; });
    window.addEventListener('touchmove', (e) => { mouse.x = e.touches[0].clientX; mouse.y = e.touches[0].clientY; });
    window.addEventListener('touchend', () => { mouse.x = null; mouse.y = null; });
    
    function animateParticles() {
        ctx.clearRect(0, 0, width, height);
        for (let i = 0; i < particles.length; i++) {
            particles[i].update();
            particles[i].draw();
            
            if (mouse.x && mouse.y) {
                let dx = mouse.x - particles[i].x;
                let dy = mouse.y - particles[i].y;
                let distance = Math.sqrt(dx * dx + dy * dy);
                if (distance < connectionDistance) {
                    ctx.beginPath();
                    ctx.strokeStyle = `rgba(0, 255, 65, ${1 - distance/connectionDistance})`;
                    ctx.lineWidth = 1;
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(mouse.x, mouse.y);
                    ctx.stroke();
                }
            }
            
            for (let j = i + 1; j < particles.length; j++) {
                let dx = particles[i].x - particles[j].x;
                let dy = particles[i].y - particles[j].y;
                let distance = Math.sqrt(dx * dx + dy * dy);
                if (distance < connectionDistance) {
                    ctx.beginPath();
                    ctx.strokeStyle = `rgba(98, 114, 164, ${0.2 - distance/connectionDistance})`;
                    ctx.lineWidth = 0.5;
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.stroke();
                }
            }
        }
        requestAnimationFrame(animateParticles);
    }
    animateParticles();

    // --- 2. Hero Terminal Boot Sequence ---
    const heroOutput = document.getElementById('hero-output');
    const bootSequence = [
        { text: "[*] Reading bio.txt...", type: "en" },
        { text: "من به ماشین‌ها یاد می‌دهم که ببینند، بفهمند و خلق کنند.", type: "fa" },
        { text: "با بیش از ۵ سال تجربه در مرزهای هوش مصنوعی، تمرکز من روی توسعه سیستم‌های هوشمند با استفاده از LLMs، Computer Vision و MLOps است.", type: "fa" },
        { text: "[*] Fetching statistics...", type: "en" }
    ];
    
    let lineIndex = 0;
    setTimeout(() => {
        let interval = setInterval(() => {
            if (lineIndex < bootSequence.length) {
                let div = document.createElement('div');
                div.className = bootSequence[lineIndex].type === 'fa' ? 'out-line fa-text' : 'out-line en-text';
                div.textContent = bootSequence[lineIndex].text;
                heroOutput.appendChild(div);
                lineIndex++;
            } else {
                clearInterval(interval);
                setTimeout(() => {
                    let statsDiv = document.createElement('div');
                    statsDiv.className = 'out-line stats';
                    statsDiv.innerHTML = `
                        <div>[Proj: 40+]</div>
                        <div>[Exp: 5+ Yrs]</div>
                        <div>[Deploy: 15+]</div>
                    `;
                    heroOutput.appendChild(statsDiv);
                }, 500);
            }
        }, 600);
    }, 1000);

    // --- 3. Live Training Terminal ---
    const trainConsole = document.getElementById('training-console');
    let epoch = 1;
    let loss = 1.950;
    
    setInterval(() => {
        if (epoch > 500) epoch = 1;
        loss = loss * 0.97 + (Math.random() * 0.04);
        let accuracy = (100 - (loss * 15)).toFixed(2);
        if (accuracy > 99.9) accuracy = 99.9;
        
        let logLine = document.createElement('div');
        logLine.textContent = `Ep ${epoch.toString().padStart(3, '0')} | Loss: ${loss.toFixed(3)} | Acc: ${accuracy}%`;
        trainConsole.appendChild(logLine);
        
        trainConsole.scrollTop = trainConsole.scrollHeight;
        epoch++;
    }, 800);

    // --- 4. Mini Neural Graph Animation (Responsive) ---
    const miniCanvas = document.getElementById('mini-neural-canvas');
    const mCtx = miniCanvas.getContext('2d');
    const container = document.getElementById('canvas-container');
    
    function resizeMiniCanvas() {
        miniCanvas.width = container.clientWidth - 30; // minus padding
        miniCanvas.height = 150;
    }
    resizeMiniCanvas();
    
    let time = 0;
    function drawNeuralGraph() {
        mCtx.clearRect(0, 0, miniCanvas.width, miniCanvas.height);
        time += 0.05;
        
        const layers = [3, 4, 3, 2]; // کمتر کردن نودها برای زیبایی در موبایل
        const nodes = [];
        const layerWidth = miniCanvas.width / (layers.length + 1);
        
        for(let i = 0; i < layers.length; i++) {
            let numNodes = layers[i];
            let spacing = miniCanvas.height / (numNodes + 1);
            for(let j = 0; j < numNodes; j++) {
                let offsetY = Math.sin(time + i + j) * 2;
                nodes.push({ x: layerWidth * (i + 1), y: spacing * (j + 1) + offsetY, layer: i });
            }
        }
        
        mCtx.lineWidth = 1;
        for(let i=0; i < nodes.length; i++) {
            for(let j=0; j < nodes.length; j++) {
                if(nodes[j].layer === nodes[i].layer + 1) {
                    let pulse = (Math.sin(time * 2 - nodes[i].layer) + 1) / 2; 
                    mCtx.strokeStyle = `rgba(80, 250, 123, ${0.1 + pulse * 0.4})`;
                    mCtx.beginPath();
                    mCtx.moveTo(nodes[i].x, nodes[i].y);
                    mCtx.lineTo(nodes[j].x, nodes[j].y);
                    mCtx.stroke();
                }
            }
        }
        
        nodes.forEach(node => {
            mCtx.beginPath();
            mCtx.arc(node.x, node.y, 4, 0, Math.PI * 2);
            mCtx.fillStyle = '#ff79c6';
            mCtx.fill();
        });
        
        requestAnimationFrame(drawNeuralGraph);
    }
    drawNeuralGraph();

    // Event Listeners for Resize
    window.addEventListener('resize', () => {
        width = canvas.width = window.innerWidth; 
        height = canvas.height = window.innerHeight;
        resizeMiniCanvas();
    });

    // Form Submit
    document.getElementById('cyber-form').addEventListener('submit', (e) => {
        e.preventDefault();
        const btn = e.target.querySelector('button');
        btn.textContent = "EXECUTING... [OK]";
        btn.style.background = "var(--primary-neon)";
        btn.style.color = "var(--bg-color)";
        setTimeout(() => {
            btn.textContent = "EXECUTE ./SEND";
            btn.style.background = "transparent";
            btn.style.color = "var(--primary-neon)";
            e.target.reset();
        }, 2000);
    });
});
