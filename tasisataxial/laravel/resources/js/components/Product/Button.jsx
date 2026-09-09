import styles from "./../../../css/styles/product/button.module.scss"
import { storageUrlPath } from "../../config/urls";
export default function Button({img,setImg}){
    return (
        <button onClick={setImg}>
            <img src={storageUrlPath(`products/${img}`)} alt="" />
        </button>
    )
}