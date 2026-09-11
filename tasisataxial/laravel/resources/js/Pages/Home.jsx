import Approch from "../components/Approch";
import Apps from "../components/Apps";
import Blog from "../components/Blog";
import EngServices from "../components/EngServices";
import Footer from "../components/Footer";
import SaleAgency from "../components/SaleAgency";
import Shop from "../components/Shop";
import Navbar from "../components/Navbar";
import Slider from "../components/Slider";
import { useEffect, useState } from "react";
import {apiFetch} from "../config/urls.js";
export default function Home(){

   
    const [data,setData]=useState({sliderImgs:null,cards:null,branches:null});
    const[Loading,setLoading]=useState(true)
    const[error,setError]=useState(null)

    async function fetchSliderimgs() {
        const res =await apiFetch('/pages/listItems/1/1')
        let data = await res
        return JSON.parse(data[0].pic)
    }

   async function fetchengCards() {
            const res =await apiFetch('/pages/listItems/1/2')
            const data = await res;

            return data
            

      }


   async function fetchbranches() {
            const res =await apiFetch('/pages/listItems/1/3')
            const data = await res;
            return data

      }

    
    async function fetchAll(){
         try{
            const [sliderImgs,cards,branches] = await Promise.all([
               fetchSliderimgs(),
               fetchengCards(),
               fetchbranches()
            ]);

           

            setData({sliderImgs,cards,branches})
            
         }catch (error){
            setError(error)
         }finally{
            setLoading(false)
         }
    }

    useEffect(()=>{
        fetchAll();
    },[])
    
    console.log(data);

    if(Loading) return <div>loading...</div>
    if(error) return <div>{error.message}</div>


    return(
       <>
          <Navbar/>
          <Slider imgs={data.sliderImgs}/>
          <EngServices cards={data.cards}/>
          <SaleAgency branches={data.branches}/>
          <Shop/>
          <Approch/>
          <Blog/>
          <Apps/>
          <Footer/>
          <div className="h-20 text-center pt-5">
             <a className="block w-50" href="tel:+989113847982">طراح و برنامه نویس : آرمان دبیرمقدم</a>
          </div>
       </>
    )
}