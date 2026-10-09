import React from 'react';
import styles from '../../css/styles/Projects.module.scss';

const projects = [
    {
        image: '/assets/images/project_facilities.jpg',
        alt: 'Tasisat Axial',
        category: 'Corporate & E-commerce',
        name: 'تاسیسات آکسیال',
        desc: 'وب‌سایت شرکتی و فروشگاهی برای خدمات تاسیسات و ساختمانی شامل معرفی خدمات، محاسبات و برآورد پروژه، سبد خرید و ورود/ثبت‌نام کاربران.',
        tech: ['Laravel', 'React'],
        url: 'https://facilities.ariodevs.com',
        delay: '',
    },
    {
        image: '/assets/images/project_pastry.jpg',
        alt: 'Ghandoon Pastry',
        category: 'E-commerce',
        name: 'شیرینی قندون',
        desc: 'فروشگاه آنلاین شیرینی و کیک با دسته‌بندی محصولات، جستجو، سبد خرید و سیستم عضویت کاربران.',
        tech: ['Laravel', 'Bootstrap'],
        url: 'https://pastry.ariodevs.com',
        delay: 'reveal-delay-1',
    },
    {
        image: '/assets/images/project_ptsafety.jpg',
        alt: 'Patient Safety',
        category: 'Healthcare Management',
        name: 'سامانه مدیریت خطای پزشکی و ایمنی بیمار',
        desc: 'سامانه ثبت و مدیریت گزارش خطاهای پزشکی برای ارتقای ایمنی بیمار، همراه با محتوای آموزشی و آمار رضایت مراجعین.',
        tech: ['PHP', 'Bootstrap'],
        url: 'https://ptsafety.ariodevs.com',
        delay: '',
    },
    {
        image: '/assets/images/project_dietary.jpg',
        alt: 'Zanjebil Diet',
        category: 'Health & Nutrition',
        name: 'زنجبیل دایت',
        desc: 'وب‌سایت کلینیک رژیم‌درمانی و تناسب اندام با پکیج‌های رژیم، فروشگاه، مقالات و پنل کاربری.',
        tech: ['PHP', 'JavaScript'],
        url: 'https://dietary.ariodevs.com',
        delay: 'reveal-delay-1',
    },
];

export default function Projects() {
    return (
        <section id="projects" className="section projects-section">
            <div className="container">
                <h2 className="section-title reveal">پروژه‌های  <span className="gradient-text">برگزیده</span></h2>

                <div className={styles.modernProjectsGrid}>
                    {projects.map((project) => (
                        <div className={`${styles.modernProjectCard} reveal ${project.delay}`} key={project.name}>
                            <div className={styles.projectImageBox}>
                                <img src={project.image} alt={project.alt} />
                                <div className={styles.projectOverlay}>
                                    <a href={project.url} target="_blank" rel="noopener noreferrer" className={styles.roundBtn} aria-label={project.name}><i className="fas fa-arrow-up-right-from-square"></i></a>
                                </div>
                            </div>
                            <div className={styles.projectDetails}>
                                <div className={`en-text`} style={{ color: 'var(--accent-2)', fontSize: '0.875rem' }}>{project.category}</div>
                                <h3 className={styles.projectName}>{project.name}</h3>
                                <p className={styles.projectDesc}>{project.desc}</p>
                                <div className={styles.projectFooter}>
                                    {project.tech.map((t) => (
                                        <div className={`${styles.techPill} en-text`} key={t}>{t}</div>
                                    ))}
                                    <a href={project.url} target="_blank" rel="noopener noreferrer" className={styles.githubLink}><i className="fas fa-globe"></i> Live</a>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}
