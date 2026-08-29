import { useEffect, useState } from "react"
import { BlueWhiteBg } from "../BlueWhiteBg"
import Button from "../Button"
import Card2 from "../Card2"
import styles from "./../../../css/styles/categories/categories.module.scss"
import Card3 from "../Card3"
import Pagination from "../pagination"
import { faInstalod } from "@fortawesome/free-brands-svg-icons"


export default function CatsContainer({maincat}){
    const [cats,setCats]=useState([])
    const [data,setData]=useState([])
    const [current_page,setCurrent_page]=useState(1);
    const [last_page,setLast_page]=useState(1);
    const [error,setError]=useState(null)
    const [loading,setLoading]=useState(true)


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
    


    function handleCatBt(cat){

        

        if(maincat==2){
            fetchProducts(cat)
        }

        if(maincat==1){
            fetchAricles(cat)
        }

        if(maincat==3){
            fetchProjects(cat)
        }

    }

    async function fetchCats(maincat) {
        const res = await fetch(`../api/getcats/${maincat}`)
        // console.log( await res.json())
        return await res.json()
    }  

    async function fetchProducts(cat=0) {
        const res =await fetch(`../api/getProducts/${cat}`)
        return await res.json()
    }

    async function fetchAricles(cat=0) {
        const res =await fetch(`../api/getArticles/${cat}/?page=${current_page}`)
        return await res.json()
    }


        async function fetchProjects(cat=0) {
        const res =await fetch(`../api/getProjects/${cat}`)
        return await res.json()
    }
    
    async function fetchAll(maincat){
        try{
            const [cats,articles,projects,products] = await Promise.all([
                fetchCats(maincat),
                fetchAricles(0),
                fetchProjects(0),
                fetchProducts(0)
            ]);

            setCats(cats)

            const result = maincat == 1 ? articles : maincat == 2 ? products : projects
            setData(result.data || result)

        } catch (error) {
            console.error("Error fetching data:", error);
            setError(error);
        } finally {
            setLoading(false);
        }
    }

    useEffect(()=>{
        fetchAll(maincat)

    },[maincat])



    if (loading) return <div>loading...</div>
    if (error) return <div>{error.message}</div>
    console.log(cats)
    return (
        <section className={styles.categories}>
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
                        (data.articles || data.products || data.projects).map((card)=>{
                            if(maincat==2){
                                return <Card2 key={card.id} img={`/tasisataxial/storage/products/${JSON.parse(card.pic)[0]}`} tilte={card.name} initLikes={25} price={card.price} onclick={()=>handleCartClick(card.id)}/>
                            }

                              if(maincat==3){
                                return <Card2 key={card.id} img={`/tasisataxial/storage/projects/${card.pic}`} tilte={card.title} initLikes={25} onclick={()=>handleCartClick(card.id)}/>
                             }

                            if(maincat==1){
                                return  <Card3 
                                            key={card.id}  
                                            img={`/tasisataxial/storage/articles/${card.pic}`} 
                                            tilte={card.title} 
                                            date={card.updated_at ? card.updated_at.split('T')[0] : ''} // Only date part
                                            onclick={()=>handleCartClick(card.id)}
                                        />
                            }
                        })
                        
                    }
                      

                </div>

                {data?.pagination && data.pagination.last_page > 1 && (
                    <Pagination current_page={data.pagination?.current_page || 1} last_page={data.pagination?.last_page || 1} cat={maincat} />
                )}
                <Button className="w-1/3 bg-orange-400 my-5 mx-auto">مشاهده بیشتر</Button>

            </div>

            <BlueWhiteBg className="md:h-4/5 -scale-y-100 w-full min-h-96 -z-10"/>

        </section>
    )
}