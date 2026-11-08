import React from 'react';

export default function ParticleText({
    height = 280,
    className = '',
}) {
    return (
        <div className={className} style={{ width: '100%', height: `${height}px`, overflow: 'hidden' }}>
            <video 
                src="/assets/retro/background-line.mp4" 
                autoPlay 
                loop 
                muted 
                playsInline 
                style={{ width: '100%', height: '100%', objectFit: 'cover' }}
            />
        </div>
    );
}

