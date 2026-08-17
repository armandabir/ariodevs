import styles from "./../../css/styles/navbar.module.scss"
import logo from  "./../../assets/logo.png"
import Button from "./Button"
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome"
import { faShoppingCart } from "@fortawesome/free-solid-svg-icons";
import { faCalculator } from "@fortawesome/free-solid-svg-icons";
import { faUser } from "@fortawesome/free-solid-svg-icons";
import { faHouse } from "@fortawesome/free-solid-svg-icons";
import { Link } from "react-router-dom";
import { useContext, useEffect, useRef, useState } from "react";
import CartContext from "./store/CartContext";

export default function Navbar(){
    const {items} = useContext(CartContext);
    const [showCartPopup, setShowCartPopup] = useState(false);
    const previousTotalCartRef = useRef(0);
    const totalCart=items.reduce((totalItems,item)=>{
        return totalItems + item.qty;
    },0)

    useEffect(() => {
        if (previousTotalCartRef.current !== totalCart) {
            if (totalCart > previousTotalCartRef.current && totalCart > 0) {
                setShowCartPopup(true);
                const timer = window.setTimeout(() => setShowCartPopup(false), 1400);
                return () => window.clearTimeout(timer);
            }
        }

        previousTotalCartRef.current = totalCart;
    }, [totalCart]);

    // console.log(items)

    function handleLoginBt(){
        window.location.href = "/admin/dashboard";
    }
    return ( 
        <nav className={styles.navbar}>
            <li className="hidden md:block">
                <div className="w-10/12 mx-auto text-center">
                    <img src={logo} alt="" />
                </div>
            </li>
            <li className={`${styles.navMid} hidden md:block`}>
                <ul>
                    <li>
                        <Link to="/home">صفحه اصلی</Link>
                    </li>
                    <li>
                        <Link to="/services">خدمات</Link>
                    </li>
                    <li>
                        <Link to="/about">درباره ما</Link>
                    </li>
                    <li>محاسبات و براورد</li>
                    <li>
                        <Link to="/cats/3">پروژه ها</Link>
                    </li>
                </ul>
            </li>
            <li className={`${styles.buttons} hidden md:block`}>
                <div className="w-10/12  mx-auto text-center relative">
                    <Link to="/cart" className="w-1/4 h-2/3 m-1">
                        <Button className="h-full text-md bg-zinc-500 ml-2 relative">
                            <div className="relative inline-flex">
                                <FontAwesomeIcon icon={faShoppingCart}></FontAwesomeIcon>
                                <span className="absolute -bottom-4 left-3 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                    {totalCart}
                                </span>
                                {showCartPopup && (
                                    <span className={styles.cartPopup} aria-live="polite">
                                        به سبد خرید اضافه شد
                                    </span>
                                )}
                            </div>
                        </Button>
                    </Link>
                    <Button className="w-3/4 h-3/5 bg-orange-400 xl:p-3 sm:text-xs" onclick={handleLoginBt}>ورود / ثبت نام</Button>
                </div>
            </li>
            <div className={styles.callBt}>
                <a className="block w-20 h-20" href="tel:09113847982"></a>
            </div>
            <ul className={`${styles.mobileMenu} md:hidden`}>
                <li>
                    <ul>
                        <li>
                            <Link to="/home">
                                <FontAwesomeIcon icon={faHouse}/>
                                <p>خانه</p>    
                            </Link>
                        </li>
                      
                        <li>
                            <a href="/admin/dashboard">
                                <FontAwesomeIcon icon={faUser} />
                                <p>ورود</p>
                            </a>
                        </li>
                    </ul>
                </li>
               
                <li>
                    <ul>
                        <li>
                            <a href="">
                                <FontAwesomeIcon icon={faCalculator}/>
                                <p>محاسبات</p>
                            </a>
                        </li>
                        <li className="relative">
                            <Link to="/cart" className="relative inline-flex flex-col items-center">
                                <FontAwesomeIcon icon={faShoppingCart}/>
                                <span className="absolute -top-3 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                 {totalCart}
                                </span>
                                {showCartPopup && (
                                    <span className={styles.cartPopup} aria-live="polite">
                                        به سبد خرید اضافه شد
                                    </span>
                                )}
                                <p>سبد خرید</p>
                            </Link>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    )
}