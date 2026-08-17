import { BlueWhiteBg } from "../BlueWhiteBg"
import styles from "./../../../css/styles/About/Intro.module.scss"
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faStar } from "@fortawesome/free-solid-svg-icons";
export default function Intro({item}){
    return (
        <section className={styles.Intro}>
            <div className={styles.aboutContent}>
                <div className={styles.media}>
                    <div className={styles.imgContainer}>
                        <img src="assets/about/about-img-1.jpg" alt="" />
                        <img src="assets/about/about-img-3.jpg" alt="" />
                        <img src="assets/about/about-img-2.jpg" alt="" />
                    </div>
                </div>
                <div className={styles.content}>
                    <h2>{item.title}</h2>
                    <p>
                      {
                        item.desc
                      }

                    </p>
                    

                    <div className={styles.score}>
                        <div className={styles.number}>4.9</div>
                        <div className={styles.stars}>
                            <FontAwesomeIcon icon={faStar}/>
                            <FontAwesomeIcon icon={faStar}/>
                            <FontAwesomeIcon icon={faStar}/>
                            <FontAwesomeIcon icon={faStar}/>
                            <FontAwesomeIcon icon={faStar}/>
                        </div>
                        <p className="text-center">
                            میزان رضایت شما 
                        </p>
                    </div>
                </div>
            </div>
            <BlueWhiteBg className="h-[95%] -scale-x-100"/>
        </section>
    )
}