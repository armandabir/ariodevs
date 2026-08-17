import Button from "../Button"
import style from "./../../../css/styles/cart/discount.module.scss"
export default function Discount(){
    return (
        <div className={style.discount}>
            <h2>کوپن تخفیف</h2>
            <form action="">
                <div className={style.container}>
                    <input type="text" />
                    <Button className="bg-orange-400">اعمال تخفیف</Button>
                </div>
            </form>
        </div>

    )
}