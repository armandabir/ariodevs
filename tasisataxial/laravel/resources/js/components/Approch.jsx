import { BlueWhiteBg } from "./BlueWhiteBg";
import styles from "./../../css/styles/approch.module.scss"
import logo from "./../../assets/logo2.jpg"
export default function Approch(){
    return(
        <div className={styles.Approch}>
            <div className={styles.banner}>
                <div className={styles.slogan}>
                    <img className={styles.logo} src={logo} alt="" />
                    <h2 className={styles.title}>راه حل بودن، تعهد ماست</h2>
                    <div  className={styles.steps}>
                       <div className="w-2/3 md:w-full flex flex-col order-last md:order-first md:flex-row justify-around">
                            <h3>
                                پیش از اجرا
                                (مشاوره و طراحی)
                            </h3>
                            <h3 className="md:transform md:-translate-x-6">
                                حین اجرا
                                (اجرا و نظارت)
                            </h3>
                            <h3>
                                پس از اجرا
                                <div>
                                (گارانتی و تعمیر و نگهداری)
                                </div>
                            </h3>
                       </div>
                       <div className="w-1/3 md:w-full">
                            <div className={styles.progress}>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                       </div>
                    </div>
                </div>
            </div>
            <BlueWhiteBg className="h-4/5 w-full absolute left-1/2 transform -translate-x-1/2 z-10"/>
        </div>
    )
}