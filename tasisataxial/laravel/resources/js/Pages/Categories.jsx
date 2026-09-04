import { data, useParams } from "react-router-dom";
import CatsContainer from "../components/catergories/CatsContainer";
import Header from "../components/catergories/Header";
import Footer from "../components/Footer";
import Navbar from "../components/Navbar";
import { useEffect } from "react";

export default function Categories () {
    const {maincat, cat}=useParams();

    async function session() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('api/session', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                 'X-CSRF-TOKEN': csrfToken,
            },
            credentials: 'include',
            body: JSON.stringify({ }),
        })
        .then(response => response.json())
        .then(data =>{
            console.log(data)
            if(data.has){
                    Swal.fire({
                    title: 'تراکنش',
                    text: data.msg,
                    icon: data.icon,
                    confirmButtonText: 'باشه'
                })
             }

        })
    }

    // useEffect(()=>{
    //     session()
    // },[])


    return (
        <>
            <Navbar/>
            <Header maincat={maincat}/>
            <CatsContainer maincat={maincat} cat={cat}/>
            <Footer/>
            <div className="h-20"></div>
        </>
    )
}