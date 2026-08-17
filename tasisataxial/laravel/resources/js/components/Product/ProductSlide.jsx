import { useState } from "react"
import styles from "./../../../css/styles/product/productSlide.module.scss"
import TransitionSection from "../TransitionSection"
import Button from "./Button"
export default function ProductSlide({items}){
   const [imgs,setImage]=useState(items);


    return(
       <section className={styles.productSlide}>
            <img src={`/storage/products/${imgs[0]}`} alt=""/>
            <div className={styles.btContainer}>

                  {
                     items.map((img,index)=><Button key={index} img={img} setImg={()=>setImage([img])}/>)
                  }
             
                
            </div>

          <TransitionSection className="z-40 bottom-0 md:h-28 h-10"/>            
       </section> 
    )
}