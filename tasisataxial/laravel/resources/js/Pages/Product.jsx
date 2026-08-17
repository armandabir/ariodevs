import { useParams } from "react-router-dom";
import Footer from "../components/Footer";
import Navbar from "../components/Navbar";
import ProductDesc from "../components/Product/ProductDesc";
import ProductDetails from "../components/Product/ProductDetails";
import ProductSlide from "../components/Product/ProductSlide";
import Button from "../components/Button";
import { useContext, useEffect, useState } from "react";
import CartContext from "../components/store/CartContext";

export default function Product(){
    const {id}=useParams();
    
    const {addItem}=useContext(CartContext);
    const [product,setPorduct]=useState();

    
    function HandleAddtoCart(item){
        const {id,name,price}=item;
        addItem({
            id,
            name,
            price
        })
    }

    async function fetchProduct() {
        const res = await fetch(`/api/fetchProduct/${id}`);
        const data = await res.json();
        setPorduct(data);
        console.log("Test")
    }

    useEffect(()=>{
         fetchProduct()
    },[id])

    return (
        <>
            <Navbar/>
             {!product ? (
                <div>Loading...</div>
             ):(
                <>
                    <ProductSlide items={JSON.parse(product.pic)}/>
                    <ProductDesc product={product}/>
                    <ProductDetails/>
                </>
             )}
            <Button className="bg-orange-400 md:w-1/4 w-4/5 md:mx-[38%] mx-[10%]" onclick={()=>HandleAddtoCart(product)}>خرید محصول</Button>
            <Footer/>
        </>
    )
}