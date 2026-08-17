import { useEffect, useState } from "react";
import Features from "../components/About/Features";
import Goals from "../components/About/goals";
import Intro from "../components/About/Intro";
import Footer from "../components/Footer";
import Navbar from "../components/Navbar";
import Headers from "../Headers";
export default function About(){

       
        const [data,setData]=useState({introItem:null,featuresItem:null,missionItem:null,goalsItem:null});
        const[Loading,setLoading]=useState(true)
        const[error,setError]=useState(null)
    
        async function intro() {
            const res =await fetch('api/pages/listItems/3/1')
            const data = await res.json();
            return data
        }
    
       async function features() {
                const res =await fetch('api/pages/listItems/3/2')
                const data = await res.json();
    
                return data
                
    
          }
    
    
       async function mission() {
                const res =await fetch('api/pages/listItems/3/3')
                const data = await res.json();
                
                return data
    
          }

        
        async function goals() {
                const res =await fetch('api/pages/listItems/3/4')
                const data = await res.json();
                
                return data
    
          }
    
        
        async function fetchAll(){
             try{
                const [introItem,featuresItem,missionItem,goalsItem] = await Promise.all([
                   intro(),
                   features(),
                   mission(),
                   goals()
                ]);
    
                setData({introItem,featuresItem,missionItem,goalsItem})
                
             }catch (error){
                setError(error)
             }finally{
                setLoading(false)
             }
        }
    
        useEffect(()=>{
            fetchAll();
        },[])
        
        
        if(Loading) return <div>loading...</div>
        if(error) return <div>{error.message}</div>
    
    
        // console.log(data)

    return (
        <>
        <Navbar/>
        <Headers img="assets/1.jpg" title="درباره ما"/>
        <Intro item={data.introItem[0]}/>
        <Features items={data.featuresItem}/>
        <Goals mission={data.missionItem[0]} goals={data.goalsItem}/>
        <Footer/>
        </>
    )
}