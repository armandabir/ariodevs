import { useContext } from "react";
import styles from "./../../../css/styles/cart/cart.module.scss"
import Balance from "./Balance";
import BuyInfo from "./BuyInfo";
import Discount from "./Discount";
import PersonInfo from "./PersonInfo";
import CartContext from "../store/CartContext";
export default function Cart(){
    const {items} = useContext(CartContext);
    return (
        <section className={styles.cart}>
            <div className={styles.shopCart}>
                <Balance items={items} />
                <Discount/>
                <PersonInfo/>
            </div>
            <div className={styles.info}>
                <BuyInfo items={items}/>
            </div>
        </section>
    )
}