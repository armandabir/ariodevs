import ParticleText from './ParticleText';
import styles from '../../css/styles/React.module.scss';

const particleColors = ['#4facfe', '#00f2fe', '#8b5cf6'];

export default function React() {
    return (
        <div className={`bento-box bento-medium reveal ${styles.nnBox}`}>
            <div className={styles.nnHeader}>
                <h3>توسعه دهندگان نرم افزار آریو</h3>
                <p className="text-muted mb-0" style={{ fontSize: '0.85rem' }}>Ario DEVS</p>
            </div>
            <div className={styles.canvasContainer}>
                <ParticleText text="ArioDevs" colors={particleColors} height={300} gap={3} />
            </div>
        </div>
    );
}
