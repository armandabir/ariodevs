import React from "react"
import img from "./../../assets/blue-white-bg.png"
import appimgbg from "./../../assets/appsbg.png"
import mobileimg from "./../../assets/bgwbMobile.png"
import styles from "./../../css/styles/BlueWhiteBg.module.scss"

export function BlueWhiteBg({ className = "", appimg = false, minHeight, alt = "" }) {
    const defaultSrc = appimg ? appimgbg : img
    const minHeightStyle= minHeight ? {minHeight} : {}
  return (
    <div className={`${styles.container} ${className}`} style={minHeightStyle}>
      <picture>
          <source media="(max-width:639px)" srcSet={mobileimg} />
          <img src={defaultSrc} alt={alt} className={styles.img} />
      </picture>
    </div>
  )
}