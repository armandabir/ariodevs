import styles from "./../../css/styles/engServices.module.scss"
import { BlueWhiteBg } from "./BlueWhiteBg"
import bolt1 from "./../../assets/bolt1.png"
import bolt2 from "./../../assets/bolt2.png"
import bolt3 from "./../../assets/bolt3.png"
import bolt4 from "./../../assets/bolt4.png"
import Card1 from "./Card1"
import TransitionSection from "./TransitionSection"
import Card2 from "./Card2"
import { useEffect, useState } from "react"
export default function EngServices({cards}){

    return (
        <section className={styles.container}>
            <h2 className="font-iranSansBold text-3xl text-center">ارائه خدمات مهندسی</h2>
            <BlueWhiteBg className="md:h-4/5 -scale-y-100 w-full z-10"/>
            <div className={styles.cards}>
               {
                   cards.map((card)=> <Card1 key={card.id} className="bg-[url('resources/assets/rectangle1.jpg')] bg-auto" icon={bolt1} title={card.title} desc={card.desc}/>) 

               } 
            </div>
            <TransitionSection className="h-1/4 bottom-0 z-30"/>    
        </section>
    )
}       