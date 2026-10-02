import React from 'react';

const testimonials = [
    {
        text: '"آریا یک درک فوق‌العاده از الگوریتم‌های پیچیده دارد. کدهای او بسیار تمیز است و مدلی که برای خط تولید ما آموزش داد، فراتر از انتظار عمل کرد. همکاری با او یک تجربه حرفه‌ای واقعی بود."',
        image: '/assets/images/image.jpg',
        alt: 'Client 1',
        name: 'مهندس احمدی',
        role: 'مدیر فنی TechVision',
        delay: '',
    },
    {
        text: '"سیستم توصیه‌گری که آریا برای پلتفرم ما ساخت، نرخ تبدیل کاربر به خریدار را ظرف یک ماه ۲۵٪ افزایش داد. علاوه بر مهارت فنی، توانایی توضیح مفاهیم پیچیده به تیم غیرفنی ما واقعاً ارزشمند بود."',
        image: '/assets/images/image(1).jpg',
        alt: 'Client 2',
        name: 'حسین محمدی',
        role: 'مدیر محصول DataPulse',
        delay: 'reveal-delay-1',
    },
];

export default function Testimonials() {
    return (
        <section id="testimonials" className="section testimonials-section">
            <div className="container">
                <h2 className="section-title reveal">اعتماد <span className="gradient-text">همکاران</span></h2>

                <div className="testimonials-grid">
                    {testimonials.map((item) => (
                        <div className={`testimonial-card glass-card reveal ${item.delay}`} key={item.name}>
                            <i className="fas fa-quote-left quote-icon"></i>
                            <p className="testimonial-text">{item.text}</p>
                            <div className="client-info">
                                <img src={item.image} alt={item.alt} />
                                <div>
                                    <h4>{item.name}</h4>
                                    <span className="text-muted">{item.role}</span>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}
