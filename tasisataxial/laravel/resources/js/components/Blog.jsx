import styles from "./../../css/styles/blog.module.scss"
import Button from "./Button"
import Card3 from "./Card3"
import MySwiper from "./MySwiper"
import {Autoplay, Navigation, Pagination, Scrollbar } from 'swiper/modules';
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faChevronLeft } from "@fortawesome/free-solid-svg-icons/faChevronLeft";
import { faChevronRight } from "@fortawesome/free-solid-svg-icons/faChevronRight";
import { useEffect, useState } from "react";

export default function Blog(){
    const [data,setData]=useState([])
    
    async function fetchAricles(cat=0) {
        const res =await fetch(`api/getArticles/${cat}`)
        const data = await res.json();
        console.log(data);
        setData(data)
    }

    function handleOnclick(){
        window.location.href="./cats/1"
    }

      function handleCartClick(id){
        window.location.href=`./article/${id}`    
    }
    

    useEffect(()=>{
        fetchAricles()
    },[])
    return(
        <section className={styles.Blog}>
            <div className={styles.container}>
                <div className="md:w-1/4 md:h-full w-full md h-2/5 px-10 text-center flex flex-col">
                    <h2 className="font-iranSansBold text-3xl mt-[30%] mb-[20%]">وبلاگ و اخبار</h2>
                    <Button onclick={handleOnclick} className= "w-full bg-orange-400">مشاهده وبلاگ</Button>
                </div>
                <div className="md:w-3/4 md:h-full w-full h-3/5 relative">
                     <MySwiper 
                            className="h-full md:w-full mx-0 md:mb-[10vh] md:mt-0 md:my-[10vh]" 
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

                                data.map((article)=> (
                                    <Card3 
                                        key={article.id}  
                                        img={`/tasisataxial/storage/articles/${article.pic}`} 
                                        tilte={article.title} 
                                        date={article.updated_at ? article.updated_at.split('T')[0] : ''} // Only date part
                                        onclick={()=>handleCartClick(article.id)}
                                    />
                                ))
                            }
                            />
                    <button className={styles.mynextBt}><FontAwesomeIcon icon={faChevronLeft}/></button>
                    <button className={styles.myprevBt}><FontAwesomeIcon icon={faChevronRight} /></button>
                            
                   
                </div>
            </div>
        </section>
    )
}