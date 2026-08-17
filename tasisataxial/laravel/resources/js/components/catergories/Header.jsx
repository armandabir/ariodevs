import styles from "./../../../css/styles/categories/header.module.scss"
export default function Header({maincat}){
    return (
       <>
        <header className={styles.Header}>
            <div className={styles.content}>
                 <h3>دسته بندی</h3>
                 <ul>
                    <li>خانه . </li>
                    <li>
                        {maincat==1?'وبلاگ':""}
                        {maincat==2?'فروشگاه':""}
                        {maincat==3?'پروژه ها':""}
                    </li>
                 </ul>

               
            </div>

             <div className={styles.searchBox}>
                <h4>
                    <span>دنبال</span>
                    
                
                     {maincat==1?'وبلاگ':" "}
                    {maincat==2?'فروشگاه':" "}
                    {maincat==3?'پروژه ':" "}
                    
                
                    خاصی هستین ؟</h4>
                <div className={styles.search}>
                    <input type="text" />
                </div>
            </div>

            <div className={styles.headerBg}></div>
        </header>
       </>
    )   
}