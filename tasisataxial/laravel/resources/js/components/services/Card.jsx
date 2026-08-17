import styles from "./../../../css/styles/services/card.module.scss"
export default function Card ({title,desc,tags,img,index}){
     function rndNumber(){
        return Math.trunc(Math.random() * 4)
    }

    const mystyles = [styles.bg1,styles.bg2,styles.bg3,styles.bg4]
    return (
        <div className={`${styles.card} ${mystyles[rndNumber()]}`}>
            <div className={`${styles.imgContainer} ${index % 2 == 0 ? styles.order :""}`}>
                <img src={`./storage/pages/${img}`} alt="" />
            </div>
            <div className={styles.content}>
                {/* {
                    tags.map((tag)=><span>{tag.title}</span>)
                } */}
                
                <div className={styles.container}>
                    <h2>{title}</h2>
                    <p>
                        {desc}
                    </p>
                    <button>جزییات بیشتر</button>
                </div>
            </div>
        </div>
    )
}