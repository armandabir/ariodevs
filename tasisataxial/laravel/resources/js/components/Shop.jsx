import styles from "./../../css/styles/shop.module.scss"
import Button from "./Button"

export default function Shop(){
    function handleShopClick(){
        window.location.href="/cats/2";
    }
    return (
        <section className={styles.shop}>
            <div className={styles.banner}></div>
            <div className={styles.content}>
                <div className="md:w-1/2 w-10/12">
                    <Button className= "md:w-1/2 w-full h-full bg-orange-400" onclick={handleShopClick}>مشاهده فروشگاه</Button>
                </div>
                <div className="order-first md:order-last md:w-1/2 w-full ">
                    <h2>فروشگاه اینترنتی آکسیال</h2>
                    <h3>بهترین محصولات را با تجربه کنید</h3>
                </div>
               
            </div>
        </section>
    )
}