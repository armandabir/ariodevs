import styles from "./../../../css/styles/product/button.module.scss"
export default function Button({img,setImg}){
    return (
        <button onClick={setImg}>
            <img src={`./storage/products/${img}`} alt="" />
        </button>
    )
}