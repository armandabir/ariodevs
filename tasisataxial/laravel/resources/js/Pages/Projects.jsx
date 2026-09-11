import Footer from "../components/Footer";
import Navbar from "../components/Navbar";
import Headers from "../Headers";
import ProjectMain from "../components/projects/ProjectMain";
import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import {storageUrlPath} from "../config/urls.js"
export default function Projects(){

     const {id}=useParams();
     const [project,setProject]=useState();
         async function fetchProject() {
             const res = await fetch(`/api/fetchProject/${id}`);
             const data = await res.json();
             console.log("Fetched project data:", data);
             setProject(data);
           
         }
     
         useEffect(()=>{
              fetchProject()
         },[id])

    return(
        <>
        <Navbar/>

         {!project ? (
                <div>Loading...</div>
             ):(
                <>
        <Headers title={project.title} img={storageUrlPath(`projects/${project.pic}`)} dark/>
        <ProjectMain project={{
              "pic": storageUrlPath(`projects/${project.pic}`),
              "content":
                <>
                {
                    project.content
                }
             
                </>
              
        }
          

        }

        />
        </>
        )}
        <Footer/>
        </>
    )
}