import styles from "./../../css/styles/apps.module.scss"
import img0 from "./../../assets/ASHRAE_0.png"
import img1 from "./../../assets/revit.png"
import img2 from "./../../assets/ASHRAE_2.png"
import img3 from "./../../assets/ASHRAE_3.png"
import img4 from "./../../assets/ASHRAE_4.png"

export default function Apps(){
    return (
        <section className={styles.Apps}>
            <div className={styles.container}>
                <img src={img0} alt="" />
                <img src={img1} alt="" />
                <img src={img2} alt="" />
                <img src={img3} alt="" />
                <img src={img4} alt="" />
            </div>
        </section>
    )
}