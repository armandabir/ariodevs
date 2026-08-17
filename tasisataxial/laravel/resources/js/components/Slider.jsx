
import styles from "./../../css/styles/slider.module.scss"
import MySwiper from "./MySwiper"
import {Autoplay, Navigation, Pagination, Scrollbar } from 'swiper/modules';
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome"
import { faChevronLeft } from "@fortawesome/free-solid-svg-icons";
import { faChevronRight } from "@fortawesome/free-solid-svg-icons";

import img1 from "./../../assets/1.jpg"
import img2 from "./../../assets/1.jpg"
import img3 from "./../../assets/1.jpg"
import img4 from "./../../assets/1.jpg"
import img5 from "./../../assets/1.jpg"
import mouseShape from "./../../assets/mouse.png"
import { useEffect, useState } from "react";
export default function Slider({imgs}){


    // console.log(imgs)

    // let imgs=JSON.parse(data[0].pic);



    return (
        <div className={styles.slider}>
            <MySwiper imgs={imgs} className="h-full" 
                    modules={[Autoplay,Navigation, Pagination, Scrollbar]}
                    autoplay={{
                        delay:3000,
                        disableOnInteraction:true,
                    }}
                   
                    spaceBetween={50}
                    slidesPerView={1}
                    pagination={{
                        clickable: true,
                        el: `.${styles.customPagination}`,
                        renderBullet: function (index, className) {   
                            return `<span class="${className} ${styles.customBullet}"></span>`;
                          }
                      
                    }}
                    onSlideChange={(swiper)=>{
                        // console.log(swiper)
                        const bullets = document.querySelectorAll(`.${styles.customBullet}`);
                        bullets.forEach((bullet, index) => {
                            if (index === swiper.activeIndex) {
                                bullet.classList.add(styles.bulletActive);
                            } else {
                                bullet.classList.remove(styles.bulletActive);
                            }
                        });
                    }}
                    navigation={{
                        nextEl:`.${styles.customNext}`,
                        prevEl:`.${styles.customPrv}`
                    }}
            />
            <div className={styles.swiperControls}>
                    
                <div className={styles.emptySpace}>
                </div>
                <div className={styles.navigationButtons}>
                    <button className={styles.customPrv}><FontAwesomeIcon icon={faChevronRight}/></button>
                    <button className={styles.customNext}><FontAwesomeIcon icon={faChevronLeft}/></button>
                </div>
                <div className={styles.customPagination}></div>
                <div className={styles.mouseShape}>
                    <div>
                        <img src={mouseShape} alt="" />
                    </div>
                </div>
                <div className={styles.socialMedia}>
                    <div className={styles.btContainer}>
                        <a href=""> </a>
                        <a href=""> </a>
                        <a href=""> </a>
                    </div>
                    
                </div>
            </div>
            <div className={styles.transitonColor}></div>
        </div>
    )
}