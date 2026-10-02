import React from 'react';

const projects = [
    {
        image: '/assets/images/pic_asar.jpg',
        alt: 'AI Chatbot',
        category: 'NLP & LLM',
        name: 'ParsLLM: دستیار هوشمند سازمانی',
        desc: 'Fine-tune کردن مدل Llama-3 روی دیتاسِت‌های اختصاصی بانکی برای پاسخگویی به مشتریان با پیاده‌سازی معماری RAG. کاهش ۴۰٪ در زمان پاسخ‌دهی اپراتورهای انسانی.',
        tech: ['PyTorch', 'LangChain'],
        delay: '',
    },
    {
        image: '/assets/images/pic_asar.jpg',
        alt: 'Computer Vision',
        category: 'Computer Vision',
        name: 'سیستم تشخیص تومور مغزی',
        desc: 'مدل Image Segmentation با استفاده از معماری U-Net برای تشخیص دقیق مرز تومورها در تصاویر MRI. دقت ۹۷٪ روی دیتاسِت BraTS2023 و تأیید شده توسط متخصصان رادیولوژی.',
        tech: ['TensorFlow', 'OpenCV'],
        delay: 'reveal-delay-1',
    },
];

export default function Projects() {
    return (
        <section id="projects" className="section projects-section">
            <div className="container">
                <h2 className="section-title reveal">آثار <span className="gradient-text">برگزیده</span></h2>

                <div className="modern-projects-grid">
                    {projects.map((project) => (
                        <div className={`modern-project-card reveal ${project.delay}`} key={project.name}>
                            <div className="project-image-box">
                                <img src={project.image} alt={project.alt} />
                                <div className="project-overlay">
                                    <a href="#" className="project-btn round-btn"><i className="fas fa-arrow-up-right-from-square"></i></a>
                                </div>
                            </div>
                            <div className="project-details">
                                <div className="project-category en-text">{project.category}</div>
                                <h3 className="project-name">{project.name}</h3>
                                <p className="project-desc">{project.desc}</p>
                                <div className="project-footer">
                                    {project.tech.map((t) => (
                                        <div className="tech-pill en-text" key={t}>{t}</div>
                                    ))}
                                    <a href="#" className="github-link"><i className="fab fa-github"></i> Source</a>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}
