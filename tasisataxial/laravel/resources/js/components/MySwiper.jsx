import {Swiper,SwiperSlide}from 'swiper/react';
import 'swiper/css';

import "swiper/css/pagination"
import "swiper/css/navigation"
import {storageUrlPath} from "../config/urls.js"

export default function MySwiper({imgs,sectionCard,className,...props}){
    return (
        <Swiper className={className} {...props}>
                
                {
                   imgs && !sectionCard &&  imgs.map((img,index)=><SwiperSlide key={index}><img src={storageUrlPath(`pages/${img}`)} alt="" /></SwiperSlide>)
                   
                }

                {
                    !imgs && sectionCard && sectionCard.map((card,index)=><SwiperSlide key={index}>{card}</SwiperSlide>)
                }

    

        </Swiper>
    )
}