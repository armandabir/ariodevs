import styles from "./../../../css/styles/cart/personInfo.module.scss"
export default function personInfo(){
    return (
       <div className={styles.personInfo}>
            <h2>اطلاعات فردی</h2>
            <form action="" className={styles.formInfo}>
                <div>
                    <div>
                        <input type="text" placeholder="نام" />
                        <input type="text" placeholder="نام خانوادگی"/>
                    </div>
                    <div>
                        <input type="text" placeholder="استان" />
                        <input type="text" placeholder=" شهر"/>
                    </div> 
                    <div>
                        <input type="text" placeholder="پلاک" />
                        <input type="text" placeholder="تلفن تماس"/>
                    </div>
                </div>
                <textarea name="description" placeholder="آدرس دقیق" id="" rows="10"></textarea>
            </form>
       </div>
    )
}