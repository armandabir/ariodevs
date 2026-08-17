import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { fas } from "@fortawesome/free-solid-svg-icons";
import { far } from "@fortawesome/free-regular-svg-icons"
import styles from "./../../css/styles/Card2.module.scss";
import { useState } from "react";
import { library } from "@fortawesome/fontawesome-svg-core";

library.add(far,fas);

export default function Card2({img,tilte,initLikes,price,like,onclick}){

    const [heart,seHeart]=useState(like);
    const [likes,setLikes]=useState(initLikes)
    function handleLike(){
        setLikes((prvLikes)=>{
            heart ? prvLikes-- :prvLikes++
            return prvLikes
        })
        seHeart((prvHeart)=>!prvHeart)

    }

    return (
        <article className={styles.card2} onClick={onclick}>
            <div className="h-60 rounded-xl overflow-hidden">
                <img src={img} alt="" />
            </div>
            <div>
                <h3 className="my-2">{tilte}</h3>
                <div className="w-1/2 mr-auto text-left" onClick={handleLike}>
                    <span className="ml-2">{likes}</span>
                    {
                        heart ?<FontAwesomeIcon icon="fas fa-heart" />:<FontAwesomeIcon icon="far fa-heart" />
                        
                    }
                    
                </div>
                
                {
                    (price)?( 
                        <>
                        <hr />  
                        <div className="flex justify-between my-2">
                            <span>قیمت</span> <span>{`${price} هزار تومان`}</span>
                        </div>
                        </>
                    ):""
                }
               
            </div>
        </article>
    )
}