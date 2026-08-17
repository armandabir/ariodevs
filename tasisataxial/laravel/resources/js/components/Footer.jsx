import styles from "./../../css/styles/footer.module.scss"
import logo from "./../../assets/logo.png"
// import cert from "./../../assets/cert.png"
import cert1 from "./../../assets/footer/cert1.jpg"
import cert2 from "./../../assets/footer/cert2.jpg"
import cert3 from "./../../assets/footer/cert3.jpg"


import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faWhatsapp } from "@fortawesome/free-brands-svg-icons";
import { faLinkedin } from "@fortawesome/free-brands-svg-icons";
import { faInstagram } from "@fortawesome/free-brands-svg-icons";
export default function Footer(){
    return (
        <footer className={styles.Footer}>
           <div className={styles.upside}>
                <div className={styles.address}>
                    <div>
                        <img src={logo} alt="" />
                    </div>
                    <div className="text-justify">
                        <p>
                            آدرس : رشت - بلوار نماز - ابتدای پل صابرین - نبش خیابان سوگند - طبقه اول
                        </p>
                    </div>
                    <div className={styles.map}>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d222.66351052174983!2d49.58324921153576!3d37.29679896473633!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sus!4v1756239083999!5m2!1sen!2sus" className="w-full" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div className={styles.quickAccess}>
                    <h3>دسترسی سریع</h3>
                    <ul>
                        <li>محصولات</li>
                        <li>تماس با ما</li>
                        <li>درباره ما</li>
                        <li>اخبار و مقالات</li>
                    </ul>
                </div>
                <div className={styles.contact}>
                    <h3>تلفن تماس</h3>
                    <ul>
                        <li>
                             <span>09106742601</span>
                        </li>
                        <li>
                             <span>09113343989</span>
                        </li>
                        <li>
                             <span>09113847982</span>
                        </li>
                    </ul>
                </div>
                <div className={styles.certs}>
                    <h3>مجوز ها</h3>
                    <div className="flex justify-around" >
                        <div>
                            <img src={cert1} alt="" />
                        </div>
                        <div>
                            <img src={cert2} alt="" />
                        </div>
                        <div>
                            <img src={cert3} alt="" />
                        </div>
                    </div>
                </div>
           </div>
           <hr />
           <div className={styles.downside}>
               <div className={styles.social}>
                    <div>
                        <FontAwesomeIcon icon={faWhatsapp}/>
                    </div>
                    <div>
                        <FontAwesomeIcon icon={faLinkedin}/>
                    </div>
                    <div>
                        <FontAwesomeIcon icon={faInstagram}/>
                    </div>
               </div>
               <div>
                    <p>تمامی حقوق مادی و معنوی برای وبسایت محفوظ است</p>
               </div>
           </div>

        </footer>
    )
}