import Button from "../Button"
import styles from "./../../../css/styles/projects/projectsMain.module.scss"
import Head from "./head"
export default function ProjectMain ({project}){
    console.log(project.content.props.children)
    return (
        <section className={styles.projects}>
            <Head img={project.pic}/>
            <div className={styles.content}>
                {project.content && (
                      <div dangerouslySetInnerHTML={{ __html: project.content.props.children }} />

                )}
            </div>
            <Button className="bg-orange-400 w-1/4 mx-auto my-5">تماس باما</Button>
        </section>
    )
}