import styles from "./../../../css/styles/About/goals.module.scss"
import { BlueWhiteBg } from "./../../components/BlueWhiteBg";

export default function Goals ({mission,goals}){
    return (
        <section className={styles.Goals}>
            <div className={styles.content}>
                <div className={styles.imgContainer}>
                    <img src="assets/about/our-process.jpg" alt="" />
                </div>
                <div className={styles.textContent}>
                    <h2>{mission.title}</h2>
                    <p>
                        {
                            mission.desc
                        }
                    </p>

                    <div className={styles.cards}>
                        
                        {
                            goals.map((goal,index)=>
                               <div key={index} className={styles.card}>
                                    <div className={styles.number}>{index+1}</div>
                                    <div className={styles.CardContent} >
                                        <h3>{goal.title}</h3>
                                        <p>
                                            {goal.desc}
                                        </p>
                                    </div>
                                </div>
                            )
                        }



                
                    </div>
                </div>
            </div>
            <BlueWhiteBg className="md:h-2/3 h-[33%] w-full absolute md:bottom-10 top-1/4 -translate-y-1/3 md:translate-y-0 -z-10 "/>
        </section>
    )

}