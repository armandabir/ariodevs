import { useEffect, useState } from "react"
import { BlueWhiteBg } from "../BlueWhiteBg"
import Button from "../Button"
import Card2 from "../Card2"
import styles from "./../../../css/styles/categories/categories.module.scss"
import Card3 from "../Card3"
import Pagination from "../pagination"
import { faInstalod } from "@fortawesome/free-brands-svg-icons"
import { set } from "lodash"
import {apiFetch,storageUrlPath} from "../../config/urls.js"

export default function CatsContainer({maincat, cat}){
    const [cats,setCats]=useState([])
    const [data,setData]=useState([])
    const [selectedCat,setSelectedCat]=useState(cat || 0)
    
    const [current_page,setCurrent_page]=useState(1);
    const [last_page,setLast_page]=useState(1);
    const [error,setError]=useState(null)
    const [loading,setLoading]=useState(true)
    const contentFetcher = maincat == 1 ? fetchAricles : maincat == 2 ? fetchProducts : fetchProjects
    
    // 0 means all cats, 1 means maincat 1, 2 means maincat 2, 3 means maincat 3 
    function handleCartClick(id){

         if(maincat==3){
            window.location.href=`../projects/${id}/?page=1`
        }


        if(maincat==2){
            window.location.href=`../product/${id}/?page=1`
        }

        if(maincat==1){
            window.location.href=`../article/${id}/?page=1`    
        }
    }
    


    function handleCatBt(categoryId){
        setSelectedCat(categoryId)
        setCurrent_page(1)
    }

    async function fetchCats(maincat=1,cat=0, current_page=1) {
        const res = await apiFetch(`getcats/${maincat}/${cat}`)
        return res
    }  
    
    async function fetchAricles(maincat=1,cat=0, current_page=1) {
        
        const res =await apiFetch(`getArticles/${maincat}/${cat}/?page=${current_page}`)
        console.log( res)
        return await res
        
    }
    
    async function fetchProducts(maincat=1,cat=0, current_page=1) {
        
        const res =await apiFetch(`../api/getProducts/${maincat}/${cat}/?page=${current_page}`)
        return await res
        
    }

    async function fetchProjects(maincat=1,cat=0, current_page=1) {

        const res =await apiFetch(`../api/getProjects/${maincat}/${cat}/?page=${current_page}`)
        return await res

    }

    // 0 means all cats, 1 means maincat 1, 2 means maincat 2, 3 means maincat 3   

    async function fetchAll(maincat, cat=0, current_page=1){
        
        try{
           
            const [cats, content] = await Promise.all([
                fetchCats(maincat,cat, current_page),
                contentFetcher(maincat,cat, current_page),
            ]);

            setCats(cats)
            setData(content.data || content)

        } catch (error) {
            console.error("Error fetching data:", error);
            setError(error);
        } finally {
            setLoading(false);
        }
    }

    useEffect(()=>{
        console.log("fetchAll called with maincat:", maincat, "cat:", selectedCat, "current_page:", current_page);
        fetchAll(maincat, selectedCat, current_page)

    },[maincat,selectedCat,current_page])



    if (loading) return <div>loading...</div>
    if (error) return <div>{error.message}</div>
  
    return (
        <section id="tag" className={styles.categories}>
            <div className={styles.catsMenu}>
                <nav>
                    <h3>{maincat==2?"دسته بندی محصولات":"دسته بندی مقالات"}</h3>
                    <ul>
                        {
                            cats.map((cat)=><li onClick={()=>handleCatBt(cat.id)} key={cat.id}>{cat.name}</li>)
                        }
                    </ul>
                </nav>
            </div>

            <div className="flex flex-col items-center md:w-10/12 md:min-h-96">
            
                <div className={styles.catsCards}>
                   
                    {
                        (data ? data.articles || data.products || data.projects : []).map((card)=>{
                            if(maincat==2){
                                return <Card2 key={card.id} img={storageUrlPath(`products/${JSON.parse(card.pic)[0]}`)} tilte={card.name} initLikes={25} price={card.price} onclick={()=>handleCartClick(card.id)}/>
                            }

                              if(maincat==3){
                                return <Card2 key={card.id} img={storageUrlPath(`projects/${card.pic}`)} tilte={card.title} initLikes={25} onclick={()=>handleCartClick(card.id)}/>
                             }

                            if(maincat==1){
                                return  <Card3 
                                            key={card.id}  
                                            img={storageUrlPath(`articles/${card.pic}`)} 
                                            tilte={card.title} 
                                            date={card.updated_at ? card.updated_at.split('T')[0] : ''} // Only date part
                                            onclick={()=>handleCartClick(card.id)}
                                        />
                            }
                        })
                        
                    }
                      

                </div>

                {data?.pagination && data.pagination.last_page > 1 && (
                    <Pagination 
                    current_page={data.pagination?.current_page}
                    last_page={data.pagination?.last_page || 1} 
                    maincat={maincat} cat={selectedCat}
                    contentFetcher={contentFetcher}
                    setCurrent_page={setCurrent_page}
                    />
                )}
                {/* <Button className="w-1/3 bg-orange-400 my-5 h-12 mx-auto">مشاهده بیشتر</Button> */}

                <br className="w-10/12 border-2 border-slate-400 my-5"/>

            </div>

            <BlueWhiteBg className="md:h-4/5 -scale-y-100 w-full min-h-96 -z-10"/>

        </section>
    )
}