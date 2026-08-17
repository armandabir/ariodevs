import {Swiper,SwiperSlide}from 'swiper/react';
import 'swiper/css';

import "swiper/css/pagination"
import "swiper/css/navigation"

export default function MySwiper({imgs,sectionCard,className,...props}){
    return (
        <Swiper className={className} {...props}>
                
                {
                   imgs && !sectionCard &&  imgs.map((img,index)=><SwiperSlide key={index}><img src={`./storage/pages/${img}`} alt="" /></SwiperSlide>)
                   
                }

                {
                    !imgs && sectionCard && sectionCard.map((card,index)=><SwiperSlide key={index}>{card}</SwiperSlide>)
                }

    

        </Swiper>
    )
}