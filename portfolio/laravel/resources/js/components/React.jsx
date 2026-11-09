import { motion } from 'motion/react';
import ParticleText from './ParticleText';
import styles from '../../css/styles/React.module.scss';
import { useLocale } from '../lib/LocaleContext';

const particleColors = ['#4facfe', '#00f2fe', '#8b5cf6'];

const cardMotionProps = {
    whileHover: {
        x: -4,
        y: -4,
        transition: { type: 'spring', stiffness: 400, damping: 25 }
    },
    whileTap: {
        x: 2,
        y: 2,
        transition: { type: 'spring', stiffness: 500, damping: 30 }
    }
};

export default function React() {
    const { t } = useLocale();
    return (
        <motion.div
            className={`bento-box bento-medium reveal ${styles.nnBox}`}
            {...cardMotionProps}
        >
            <div className={styles.nnHeader}>
                <h3>{t('توسعه دهندگان نرم افزار آریو')}</h3>
                <p className="text-muted mb-0" style={{ fontSize: '0.85rem' }}>Ario DEVS</p>
            </div>
            <div className={styles.canvasContainer}>
                <ParticleText text="ArioDevs" colors={particleColors} height={300} gap={3} />
            </div>
        </motion.div>
    );
}
