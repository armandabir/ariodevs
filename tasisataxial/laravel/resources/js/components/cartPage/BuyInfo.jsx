import Button from "../Button"
import styles from "./../../../css/styles/cart/buyinfo.module.scss"
export default function BuyInfo({items}){
    const totalPrice=items.reduce((price,item)=>{
        return price + item.price * item.qty;
    },0)
    
    function handleOnClick(){
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/api/cart/payment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                 'X-CSRF-TOKEN': csrfToken,
            },
            credentials: 'include',
            body: JSON.stringify({ items }),
        })
        .then(response => response.json())
        .then(data => {
            window.location.href="/payment"
            console.log('Success:', data);
        })
        .catch(error => {
            // handle error
            console.error('Error:', error);
        });
    }
    
    return (
        <div className={styles.buyinfo}>
            <h2>اطلاعات خرید</h2>
            <div className={styles.table}>
                <div>
                    <div>مجموع خرید</div>
                    <div>{totalPrice} تومان</div>
                </div>
                <div>
                    <div>تخفیف</div>
                    <div></div>
                </div>
                <div>
                    <div>مالیات بر ارزش افزوده</div>
                    <div></div>
                </div>
                <hr />
                <div>
                    <div>مبلغ قابل پرداخت</div>
                    <div>{totalPrice} تومان</div>
                </div>
               <div>
                 <Button onclick={handleOnClick} className="w-1/2 bg-orange-400 h-10 mx-auto my-5">تکمیل پرداخت</Button>
               </div>
            </div>
        </div>
    )
}