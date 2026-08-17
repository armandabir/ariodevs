import Cart from "../components/cartPage/Cart";
import Footer from "../components/Footer";
import Navbar from "../components/Navbar";
import Headers from "../Headers";
import img from "./../../assets/cart.jpg"
export default function CardPage(){
    return (
        <>
        <Navbar/>
        <Headers img={img} dark title="سبد خرید"/>
        <Cart/>
        <Footer/>
        </>
    )
}