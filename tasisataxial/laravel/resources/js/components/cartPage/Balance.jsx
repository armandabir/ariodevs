import styles from "./../../../css/styles/cart/balance.module.scss"
import delImg from "./../../../assets/cart/XCircle.png"
import { useContext } from "react"
import CartContext from "../store/CartContext"
export default function Balance({items}){
    const {addItem,removeItem,deleteItem}=useContext(CartContext)

       function HandleAddtoCart(item){
            addItem(item)
        }

        function HandleRemoveCart(item){
            removeItem(item)
        }

        function handleDeleteItem(item){
            deleteItem(item)
        }
    return (
        <div className={styles.balance}>
            <h2>موجودی سبد خرید</h2>
            <ul className={styles.balanceNav}>
                <li>نام محصول</li>
                <li>قیمت</li>
                <li>تعداد</li>
                <li>حذف</li>
            </ul>
            <ul className={styles.balanceInfo}>
                {

                     items.map((item)=>
                        <li key={item.id}>
                            <ul>
                                <li>{item.name}</li>
                                <li>{item.price} تومان</li>
                                <li>
                                    <div className={styles.inputWrapper}>
                                        <span onClick={()=>HandleRemoveCart(item)} className={styles.minus}>-</span>
                                        <input type="number" value={item.qty} readOnly />
                                        <span onClick={()=>HandleAddtoCart(item)} className={styles.plus}>+</span>
                                    </div>
                                </li>
                                <li>
                                    <img src={delImg} onClick={()=>handleDeleteItem(item)} alt="" />
                                </li>
                            </ul>
                        </li>
                    )
                }
            </ul>
        </div>
    )
}