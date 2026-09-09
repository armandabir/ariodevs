import { BlueWhiteBg } from "../BlueWhiteBg"
import styles from "./../../../css/styles/projects/head.module.scss"
import { storageUrlPath } from "../../config/urls";
export default function Head({img,article}) {
    return (
        <div className={styles.head}>
            <div className={styles.imgContainer}>
                {article ? (<img src={storageUrlPath(`articles/${img}`)} alt="" />):
                (<img src={img} alt="" />)
                    
                }
            </div>
            <BlueWhiteBg className="absolute top-0 left-0 w-full h-5/6 -scale-x-100"/>
        </div>
    )
}