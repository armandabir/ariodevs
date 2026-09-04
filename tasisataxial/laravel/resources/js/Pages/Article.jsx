import Content from "../components/article/Content";
import Footer from "../components/Footer";
import Navbar from "../components/Navbar";
import Headers from "../Headers";
import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";

export default function Article(){
    const {id}=useParams();
    const [article,setArticle]=useState();
    
    async function fetchAricle() {
        const res = await fetch(`../api/article/${id}`);
        const data = await res.json();
        setArticle(data);
       
    }

    useEffect(()=>{
        fetchAricle()
    },[id])



    return(
        <>
        <Navbar/>
        {!article?(<div>Loading...</div>):

        (
        <>
            <Headers title={article.title} img={`/tasisataxial/storage/articles/${article.pic}`} dark/>
            <Content content={article}/>
        </>
        )

        }
        <Footer/>
        </>
    )
    
}