import styles from "./../../../css/styles/product/productdesc.module.scss"
import {BlueWhiteBg} from "./../BlueWhiteBg"
export default function ProductDesc({product}){
    return (
        <section className={styles.productDesk} >
            <h1>{product.name}</h1>
            <h2 className={styles.title}>{product.slug}</h2>
            <div className={styles.general}>
                <p>
                    {product.content}
                </p>
                <BlueWhiteBg className="md:h-auto h-900 w-full absolute md:scale-x-110 md:top-0 -top-40 -scale-x-100 -rotate-4 -z-10" appimg/>
            </div>
        </section>
    )
}