import styles from "./../../css/styles/Card3.module.scss";
import arrowLeft from "./../../assets/ArrowLeft.png"
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faCalendarDays } from "@fortawesome/free-solid-svg-icons";
export default function Card3({img,tilte,date,onclick}){
    return (
        <article className={styles.card3} onClick={onclick}>
            <div className="h-60 rounded-xl overflow-hidden">
                <img src={img} alt="" />
            </div>
            <div className={styles.date}>
                <span>{date}</span>
                <FontAwesomeIcon className="mr-2" icon={faCalendarDays}/>
            </div>
            <div>
                <h3 className="my-2 text-xl text-center">{tilte}</h3>
           
                <div className={styles.readMore}>
                    <span>مطالعه بیشتر</span>
                    <img src={arrowLeft} alt="" />
                </div>
            </div>
        </article>
    )
}   