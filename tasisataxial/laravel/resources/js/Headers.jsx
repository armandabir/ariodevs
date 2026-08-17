import styles from "./../css/styles/Headers.module.scss"
import TransitionSection from "./components/TransitionSection"
export default function Headers ({img,dark,title = ""}) {
    return (
        <header className={`${styles.Header} ${dark ? styles.dark:""  }` }>
             <div className={styles.content}>
                <h3>{title}</h3>
                <ul>
                    <li>خانه . </li>
                    <li>{title}</li>
                </ul>  
             </div>
             <div className={styles.imgContainer}>
                 <img src={img} alt="" />
             </div>
            <TransitionSection className="h-20 bottom-0"/>
        </header>
    )
}