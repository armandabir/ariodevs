import Button from "../Button"
import Head from "../projects/head"
import styles from "./../../../css/styles/projects/projectsMain.module.scss"

export default function Content({content}){
    return (
        <section className={styles.projects}>
                <Head img={content.pic} article/>
                <div className={styles.content}>
                    {content.content && (
                        <div dangerouslySetInnerHTML={{ __html: content.content }} />
                    )}
                </div>
            
        </section>
    )


}