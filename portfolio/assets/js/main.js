document.addEventListener('DOMContentLoaded', () => {

    /* ==========================================
       Scroll Progress Bar
       ========================================== */
    const scrollProgress = document.getElementById('scroll-progress');
    window.addEventListener('scroll', () => {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const scrollPercent = (scrollTop / docHeight) * 100;
        if(scrollProgress) {
            scrollProgress.style.width = `${scrollPercent}%`;
        }
    });

    /* ==========================================
       Mobile Drawer Menu Logic
       ========================================== */
    const mobileMenuBtn = document.getElementById('open-menu');
    const closeMenuBtn = document.getElementById('close-menu');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileOverlay = document.getElementById('mobile-overlay');
    const mobileNavItems = document.querySelectorAll('.mobile-nav-item');

    function openMobileMenu() {
        mobileMenu.classList.add('active');
        mobileOverlay.classList.add('active');
        document.body.style.overflow = 'hidden'; // Stop background scrolling
    }

    function closeMobileMenu() {
        mobileMenu.classList.remove('active');
        mobileOverlay.classList.remove('active');
        document.body.style.overflow = 'auto';
        document.body.style.overflowX = 'hidden'; // Ensure X remains hidden
    }

    if(mobileMenuBtn) mobileMenuBtn.addEventListener('click', openMobileMenu);
    if(closeMenuBtn) closeMenuBtn.addEventListener('click', closeMobileMenu);
    if(mobileOverlay) mobileOverlay.addEventListener('click', closeMobileMenu);

    mobileNavItems.forEach(item => {
        item.addEventListener('click', closeMobileMenu);
    });

    /* ==========================================
       Custom Cursor Logic (Desktop Only)
       ========================================== */
    const cursorDot = document.getElementById('cursor-dot');
    const cursorOutline = document.getElementById('cursor-outline');
    const isTouchDevice = !window.matchMedia("(pointer: fine)").matches;

    if (!isTouchDevice && cursorDot && cursorOutline) {
        window.addEventListener('mousemove', (e) => {
            const posX = e.clientX;
            const posY = e.clientY;

            cursorDot.style.left = `${posX}px`;
            cursorDot.style.top = `${posY}px`;

            cursorOutline.animate({
                left: `${posX}px`,
                top: `${posY}px`
            }, { duration: 500, fill: "forwards" });
        });

        const hoverTargets = document.querySelectorAll('a, button, .bento-box, .modern-project-card, .service-card, .testimonial-card');
        hoverTargets.forEach(target => {
            target.addEventListener('mouseenter', () => {
                cursorOutline.style.width = '60px';
                cursorOutline.style.height = '60px';
                cursorOutline.style.backgroundColor = 'rgba(255, 255, 255, 0.1)';
            });
            target.addEventListener('mouseleave', () => {
                cursorOutline.style.width = '40px';
                cursorOutline.style.height = '40px';
                cursorOutline.style.backgroundColor = 'transparent';
            });
        });
    } else {
        if(cursorDot) cursorDot.style.display = 'none';
        if(cursorOutline) cursorOutline.style.display = 'none';
    }

    /* ==========================================
       Typing Effect
       ========================================== */
    const typedTextSpan = document.getElementById("typed-text");
    const textArray = ["توسعه‌دهنده AI", "محقق دیپ‌لرنینگ", "مهندس داده", "متخصص NLP"];
    const typingDelay = 100;
    const erasingDelay = 50;
    const newTextDelay = 2000;
    let textArrayIndex = 0;
    let charIndex = 0;

    function type() {
        if (!typedTextSpan) return;
        if (charIndex < textArray[textArrayIndex].length) {
            typedTextSpan.textContent += textArray[textArrayIndex].charAt(charIndex);
            charIndex++;
            setTimeout(type, typingDelay);
        } else {
            setTimeout(erase, newTextDelay);
        }
    }

    function erase() {
        if (!typedTextSpan) return;
        if (charIndex > 0) {
            typedTextSpan.textContent = textArray[textArrayIndex].substring(0, charIndex - 1);
            charIndex--;
            setTimeout(erase, erasingDelay);
        } else {
            textArrayIndex++;
            if (textArrayIndex >= textArray.length) textArrayIndex = 0;
            setTimeout(type, typingDelay + 1100);
        }
    }

    if (textArray.length && typedTextSpan) setTimeout(type, newTextDelay + 250);

    /* ==========================================
       Dark/Light Theme Toggle
       ========================================== */
    const themeToggleBtn = document.getElementById('theme-toggle');
    const body = document.body;
    
    if(themeToggleBtn) {
        const themeIcon = themeToggleBtn.querySelector('i');
        const savedTheme = localStorage.getItem('modern-portfolio-theme');
        
        if (savedTheme) {
            body.setAttribute('data-theme', savedTheme);
            updateThemeIcon(savedTheme);
        }

        themeToggleBtn.addEventListener('click', () => {
            const currentTheme = body.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            body.setAttribute('data-theme', newTheme);
            localStorage.setItem('modern-portfolio-theme', newTheme);
            
            updateThemeIcon(newTheme);
        });

        function updateThemeIcon(theme) {
            if (theme === 'dark') {
                themeIcon.className = 'fas fa-sun';
            } else {
                themeIcon.className = 'fas fa-moon';
            }
        }
    }

    /* ==========================================
       Scroll Reveal & Skills Progress Animation
       ========================================== */
    const progressBars = document.querySelectorAll('.progress-bar');
    
    function reveal() {
        const reveals = document.querySelectorAll(".reveal");
        const windowHeight = window.innerHeight;

        // Reveal basic elements
        for (let i = 0; i < reveals.length; i++) {
            const elementTop = reveals[i].getBoundingClientRect().top;
            const elementVisible = 100;
            if (elementTop < windowHeight - elementVisible) {
                reveals[i].classList.add("active");
            }
        }

        // Animate Skills Progress Bars when in view
        progressBars.forEach(bar => {
            const barPosition = bar.getBoundingClientRect().top;
            if (barPosition < windowHeight - 50) {
                const targetWidth = bar.getAttribute('data-width');
                bar.style.width = targetWidth;
            }
        });
    }
    window.addEventListener("scroll", reveal);
    reveal();

    /* ==========================================
       Smooth Scroll for Nav Links
       ========================================== */
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                window.scrollTo({
                    top: targetElement.offsetTop - 90,
                    behavior: 'smooth'
                });
            }
        });
    });

    /* ==========================================
       Contact Form Handling
       ========================================== */
    const contactForm = document.getElementById('contact-form');
    if(contactForm) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const btn = contactForm.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            
            btn.innerHTML = 'در حال ارسال... <i class="fas fa-spinner fa-spin"></i>';
            btn.style.pointerEvents = 'none';

            setTimeout(() => {
                btn.innerHTML = 'پیام با موفقیت ارسال شد <i class="fas fa-check"></i>';
                btn.style.background = '#10b981';
                btn.style.color = '#fff';
                contactForm.reset();

                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.style.background = '';
                    btn.style.color = '';
                    btn.style.pointerEvents = 'auto';
                }, 3000);
            }, 1500);
        });
    }

});

// نورون
// =========================================
//   Neural Network Canvas Animation
// =========================================
document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('neural-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width, height;
    
    // رنگ‌ها برگرفته از تم سیستم شما
    const colors = {
        node: '#4facfe',
        nodeGlow: 'rgba(79, 172, 254, 0.5)',
        line: 'rgba(255, 255, 255, 0.05)',
        signal: '#00f2fe'
    };

    // ساختار شبکه عصبی (تعداد نورون در هر لایه)
    const layerStructure = [3, 4, 4, 2];
    let nodes = [];
    let links = [];
    let signals = [];

    // تنظیم اندازه بوم
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

    // ساخت نورون‌ها و اتصالات
    function initNetwork() {
        nodes = [];
        links = [];
        signals = [];

        const layerCount = layerStructure.length;
        const paddingX = 40; // فاصله از لبه‌های افقی
        const layerSpacing = (width - paddingX * 2) / (layerCount - 1);

        // تولید نورون‌ها
        layerStructure.forEach((nodeCount, layerIndex) => {
            const x = paddingX + layerIndex * layerSpacing;
            const paddingY = 20;
            const nodeSpacing = (height - paddingY * 2) / (nodeCount === 1 ? 1 : nodeCount - 1);
            
            for (let i = 0; i < nodeCount; i++) {
                const y = nodeCount === 1 ? height / 2 : paddingY + i * nodeSpacing;
                nodes.push({ id: `${layerIndex}-${i}`, x, y, layer: layerIndex });
            }
        });

        // تولید اتصالات (سیناپس‌ها) بین لایه‌های مجاور
        for (let i = 0; i < layerCount - 1; i++) {
            const currentLayerNodes = nodes.filter(n => n.layer === i);
            const nextLayerNodes = nodes.filter(n => n.layer === i + 1);
            
            currentLayerNodes.forEach(source => {
                nextLayerNodes.forEach(target => {
                    links.push({ source, target });
                });
            });
        }
    }

    // کلاس سیگنال برای نمایش جریان داده
    class Signal {
        constructor(link) {
            this.link = link;
            this.progress = 0;
            // سرعت تصادفی برای طبیعی‌تر شدن
            this.speed = 0.01 + Math.random() * 0.015; 
            this.size = 2 + Math.random() * 1.5;
        }

        update() {
            this.progress += this.speed;
            return this.progress >= 1; // اگر به مقصد رسید true برمی‌گرداند
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
            ctx.shadowBlur = 0; // ریست کردن سایه برای المان‌های دیگر
        }
    }

    // تولید تصادفی سیگنال‌ها
    function spawnSignals() {
        if (Math.random() > 0.85) { // احتمال تولید سیگنال در هر فریم
            const randomLink = links[Math.floor(Math.random() * links.length)];
            signals.push(new Signal(randomLink));
        }
    }

    // حلقه اصلی انیمیشن
    function animate() {
        ctx.clearRect(0, 0, width, height);

        // رسم خطوط اتصال
        ctx.lineWidth = 1;
        links.forEach(link => {
            ctx.beginPath();
            ctx.moveTo(link.source.x, link.source.y);
            ctx.lineTo(link.target.x, link.target.y);
            ctx.strokeStyle = colors.line;
            ctx.stroke();
        });

        // به‌روزرسانی و رسم سیگنال‌ها
        spawnSignals();
        for (let i = signals.length - 1; i >= 0; i--) {
            const signal = signals[i];
            if (signal.update()) {
                // حذف سیگنالی که به مقصد رسیده
                signals.splice(i, 1); 
            } else {
                signal.draw(ctx);
            }
        }

        // رسم نورون‌ها
        nodes.forEach(node => {
            ctx.beginPath();
            ctx.arc(node.x, node.y, 4, 0, Math.PI * 2);
            ctx.fillStyle = colors.node;
            
            // افکت درخشش نورون‌ها
            ctx.shadowBlur = 8;
            ctx.shadowColor = colors.nodeGlow;
            ctx.fill();
            
            // یک هاله خارجی برای نورون
            ctx.beginPath();
            ctx.arc(node.x, node.y, 8, 0, Math.PI * 2);
            ctx.strokeStyle = 'rgba(79, 172, 254, 0.2)';
            ctx.stroke();
            ctx.shadowBlur = 0;
        });

        requestAnimationFrame(animate);
    }

    // راه‌اندازی اولیه
    resizeCanvas();
    animate();
});


// =========================================
//   Live Terminal Simulation
// =========================================
document.addEventListener('DOMContentLoaded', () => {
    const terminalBody = document.getElementById('live-terminal');
    if (!terminalBody) return;

    let epoch = 1;
    const totalEpochs = 50;
    let loss = 2.453;
    let accuracy = 0.45;

    // مجموعه‌ای از پیام‌های واقعی که در MLOps دیده می‌شود
    const logMessages = [
        () => `[INFO] Loading dataset 'banking-conversations-v2'...`,
        () => `[INFO] Initializing distributed training across 4 GPUs...`,
        () => `[WARN] <span class="warning">VRAM usage at 88%. Enabling gradient checkpointing.</span>`,
        () => `Epoch ${epoch}/${totalEpochs} - <span class="keyword">Loss:</span> <span class="value">${loss.toFixed(4)}</span> - <span class="keyword">Accuracy:</span> <span class="value">${accuracy.toFixed(2)}</span>`,
        () => `[INFO] Running validation step...`,
        () => `[SUCCESS] <span class="success">Checkpoint saved to ./weights/llama3-finetuned-step-800.pt</span>`,
        () => `[INFO] Adjusting learning rate to 2e-5 with Cosine Annealing...`,
        () => `[INFO] Garbage collection freed 1.2GB of memory.`
    ];

    // تابع برای ایجاد نوسان تصادفی در اعداد
    function updateMetrics() {
        epoch = epoch >= totalEpochs ? 1 : epoch + 1;
        loss = Math.max(0.1, loss - (Math.random() * 0.15));
        accuracy = Math.min(0.99, accuracy + (Math.random() * 0.05));
        if (epoch === 1) { loss = 2.5; accuracy = 0.4; } // ریست کردن وقتی به آخر رسید
    }

    let lineCount = 0;
    const maxLines = 8; // حداکثر خطوطی که در باکس جا می‌شود

    function addLogLine() {
        if (lineCount >= maxLines) {
            // حذف اولین خط (قدیمی‌ترین)
            terminalBody.removeChild(terminalBody.firstChild);
        } else {
            lineCount++;
        }

        // انتخاب یک پیام تصادفی (اما Epoch همیشه شانس بیشتری دارد)
        let msgFunc = Math.random() > 0.4 ? logMessages[3] : logMessages[Math.floor(Math.random() * logMessages.length)];
        
        if (msgFunc === logMessages[3]) {
            updateMetrics();
        }

        const newLine = document.createElement('div');
        newLine.className = 'term-line';
        // اضافه کردن زمان به ابتدای لاگ
        const time = new Date().toISOString().split('T')[1].substring(0, 8);
        newLine.innerHTML = `<span style="color:#8b949e">[${time}]</span> ${msgFunc()}`;
        
        // قرار دادن کرسر بعد از خط جدید
        const cursor = document.createElement('span');
        cursor.className = 'term-cursor';
        newLine.appendChild(cursor);

        // حذف کرسر از خط قبلی
        const oldCursor = terminalBody.querySelector('.term-cursor');
        if (oldCursor) oldCursor.remove();

        terminalBody.appendChild(newLine);

        // سرعت تایپ تصادفی بین 800 میلی‌ثانیه تا 2.5 ثانیه برای طبیعی‌تر شدن
        const nextTick = 800 + Math.random() * 1700;
        setTimeout(addLogLine, nextTick);
    }

    // شروع انیمیشن
    setTimeout(addLogLine, 1000);
});


// =========================================
//   Live Computer Vision Simulation
// =========================================
document.addEventListener('DOMContentLoaded', () => {
    const viewport = document.getElementById('cv-viewport');
    if (!viewport) return;

    // کلاس‌ها و رنگ‌های رایج در دیتاست COCO
    const cocoClasses = [
        { name: 'person', color: '#00ff00' },
        { name: 'vehicle', color: '#00f2fe' },
        { name: 'traffic light', color: '#ffbd2e' },
        { name: 'laptop', color: '#d2a8ff' },
        { name: 'cup', color: '#ff7b72' }
    ];

    function createBoundingBox() {
        // ایجاد یک عنصر جدید
        const box = document.createElement('div');
        box.className = 'bounding-box';

        // انتخاب تصادفی یک کلاس
        const objClass = cocoClasses[Math.floor(Math.random() * cocoClasses.length)];
        
        // تولید مختصات و ابعاد تصادفی (به درصد برای ریسپانسیو بودن)
        const width = 15 + Math.random() * 25; // عرض بین 15 تا 40 درصد
        const height = 20 + Math.random() * 40; // ارتفاع بین 20 تا 60 درصد
        const left = Math.random() * (100 - width);
        const top = 10 + Math.random() * (80 - height); // جلوگیری از بیرون زدن از بالا و پایین

        // تولید درصد اطمینان (Confidence Score)
        const confidence = (0.75 + Math.random() * 0.24).toFixed(2);

        // اعمال استایل‌ها
        box.style.width = `${width}%`;
        box.style.height = `${height}%`;
        box.style.left = `${left}%`;
        box.style.top = `${top}%`;
        box.style.borderColor = objClass.color;
        box.style.boxShadow = `inset 0 0 10px rgba(255,255,255,0.1), 0 0 8px ${objClass.color}`;

        // ساخت لیبل بالای مربع
        const label = document.createElement('div');
        label.className = 'bb-label';
        label.style.backgroundColor = objClass.color;
        label.innerHTML = `${objClass.name} ${confidence}`;

        box.appendChild(label);
        viewport.appendChild(box);

        // حذف باکس بعد از یک زمان تصادفی (بین 1.5 تا 3 ثانیه)
        const displayTime = 1500 + Math.random() * 1500;
        setTimeout(() => {
            box.style.opacity = '0'; // افکت محو شدن
            setTimeout(() => {
                if (viewport.contains(box)) viewport.removeChild(box);
            }, 300); // صبر برای اتمام ترانزیشن CSS
        }, displayTime);
    }

    // تولید مستمر باکس‌ها با فواصل زمانی نامنظم (برای طبیعی‌تر شدن)
    function detectionLoop() {
        // در هر لحظه حداکثر 3 شیء در صفحه باشد تا شلوغ نشود
        const currentBoxes = viewport.querySelectorAll('.bounding-box').length;
        if (currentBoxes < 3 && Math.random() > 0.3) {
            createBoundingBox();
        }
        
        const nextTick = 400 + Math.random() * 1000;
        setTimeout(detectionLoop, nextTick);
    }

    // شروع شبیه‌سازی
    setTimeout(detectionLoop, 1000);
});

// =========================================
//   Live Vector Space / Embeddings Simulation
// =========================================
document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('vector-canvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    
    let width, height;
    let particles = [];
    const numParticles = 40;
    const connectionDistance = 80; // حداکثر فاصله برای اتصال نقاط

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
            this.color = isQuery ? '#a855f7' : '#4b5563'; // رنگ بنفش برای جستجو
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

    // ساخت نقاط اولیه (دیتاست)
    for (let i = 0; i < numParticles; i++) {
        particles.push(new Particle());
    }

    // اضافه کردن یک نقطه جستجو (Query)
    let queryParticle = new Particle(true);
    particles.push(queryParticle);

    // تغییر موقعیت تصادفی نقطه جستجو هر چند ثانیه
    setInterval(() => {
        queryParticle.x = Math.random() * width;
        queryParticle.y = Math.random() * height;
        // افکت موج هنگام ورود کوئری جدید
        drawPulse(queryParticle.x, queryParticle.y);
    }, 4000);

    let pulseRadius = 0;
    let pulseActive = false;
    let pulseX, pulseY;

    function drawPulse(x, y) {
        pulseActive = true;
        pulseRadius = 0;
        pulseX = x;
        pulseY = y;
    }

    function animate() {
        ctx.clearRect(0, 0, width, height);

        // رسم موج
        if (pulseActive) {
            ctx.beginPath();
            ctx.arc(pulseX, pulseY, pulseRadius, 0, Math.PI * 2);
            ctx.strokeStyle = `rgba(168, 85, 247, ${1 - pulseRadius/100})`;
            ctx.lineWidth = 2;
            ctx.stroke();
            pulseRadius += 2;
            if (pulseRadius > 100) pulseActive = false;
        }

        // بروزرسانی و رسم نقاط
        particles.forEach(p => p.update());

        // رسم خطوط اتصال بر اساس فرمول فاصله اقلیدسی
        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                let dx = particles[i].x - particles[j].x;
                let dy = particles[i].y - particles[j].y;
                let distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < connectionDistance) {
                    ctx.beginPath();
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    
                    // اگر یکی از نقاط کوئری باشد، خط روشن‌تر می‌شود
                    let isQueryConnection = particles[i].isQuery || particles[j].isQuery;
                    let opacity = 1 - (distance / connectionDistance);
                    
                    ctx.strokeStyle = isQueryConnection 
                        ? `rgba(168, 85, 247, ${opacity})` 
                        : `rgba(100, 116, 139, ${opacity * 0.3})`;
                    
                    ctx.lineWidth = isQueryConnection ? 1.5 : 0.5;
                    ctx.stroke();
                }
            }
        }

        particles.forEach(p => p.draw());
        requestAnimationFrame(animate);
    }

    animate();
});
