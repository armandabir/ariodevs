import { useEffect, useState } from "react";
import Footer from "../components/Footer";
import Navbar from "../components/Navbar";
import Cards from "../components/services/Cards";
import Headers from "../Headers";

export default function Services (){

    const [items,setItems]=useState([]);

    async function fetchcards() {
        const res = await fetch(`api/pages/listItems/2/0`)
        const data = await res.json();
        setItems(data);
       
    }  

    useEffect(()=>{
        fetchcards()
    },[])


    return (
        <>
            <Navbar/>
            <Headers img="assets/services.jpg" title="خدمات" dark/>
            <Cards cards={items}/>
            <Footer/>
        </>
    )
}