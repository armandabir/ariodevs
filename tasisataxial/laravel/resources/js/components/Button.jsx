import styles from "./../../css/styles/button.module.scss"
export default function Button ({children,className,onclick}){
    
    return (
        <button className={className} onClick={onclick}>{children}</button>
    )
}