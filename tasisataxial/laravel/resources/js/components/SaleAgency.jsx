import styles from "./../../css/styles/saleAgency.module.scss"
import MySwiper from "./MySwiper"
import {Autoplay, Navigation, Pagination, Scrollbar } from 'swiper/modules';
import Button from "./Button";
import Card2 from "./Card2";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faChevronLeft } from "@fortawesome/free-solid-svg-icons/faChevronLeft";
import { faChevronRight } from "@fortawesome/free-solid-svg-icons/faChevronRight";
import { map } from "lodash";
import { useEffect, useState } from "react";
export default function SaleAgency({branches}){

  

    return(
        <section className={styles.container}>
            <div className="relative z-30 flex md:flex-row flex-col md:px-20">
                <MySwiper 
                className="h-full md:w-3/5 mx-0 md:mb-[10vh] md:mt-0 my-[10vh]" 
                modules={[Autoplay,Navigation, Pagination, Scrollbar]}
                autoplay={{
                    delay:4000,
                    disableOnInteraction:true,
                }}
               
                breakpoints={{
                        640:{
                            spaceBetween:0,
                            slidesPerView:2
                        },
                        1024:{
                            spaceBetween:20,
                            slidesPerView:3
                        }
                    }}

                navigation={{
                    nextEl:`.${styles.mynextBt}`,
                    prevEl:`.${styles.myprevBt}`
                }}

                sectionCard={
                     branches.map((card)=>[ <Card2 img={`./storage/pages/${card.pic}`} tilte={card.title} initLikes={25}/>,])
                     }
                />
                <button className={styles.mynextBt}><FontAwesomeIcon icon={faChevronLeft}/></button>
                <button className={styles.myprevBt}><FontAwesomeIcon icon={faChevronRight} /></button>
                
                <div className="md:w-2/5 mx-auto text-center md:order-last order-first md:mt-[10vh] mt-[20vh]">
                    <h2 className="text-3xl my-[10%] font-iranSansBold">نمایندگی فروش تجهیزات</h2>
                    <Button className="w-2/4 my-[5%] bg-orange-400 xl:p-3">مشاهده نمایندگی</Button>
                </div>
            </div>
           
        </section>
    )
}