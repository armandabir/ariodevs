import styles from "./../../css/styles/card1.module.scss"
export default function Card1 ({icon,title,desc,className}){
    return(
        <div className={`${styles.card} ${className}`}>
            <div>
                <img src={icon} alt="" />                
            </div>
            <h3>{title}</h3>
            <p>
                {desc}
            </p>
        </div>
    )
}