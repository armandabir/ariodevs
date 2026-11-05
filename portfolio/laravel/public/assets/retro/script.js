import Lenis from "https://cdn.jsdelivr.net/npm/lenis@1.3.27/+esm";
import { animate, cancelFrame, frame, inView, scroll } from "https://cdn.jsdelivr.net/npm/motion@14.9.1/+esm";

const year = document.querySelector("#year");
if (year) year.textContent = new Date().getFullYear();

const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)");
const lenis = new Lenis({ autoRaf: false, anchors: true });
const driveLenis = ({ timestamp }) => lenis.raf(timestamp);
frame.setup(driveLenis, true);
window.addEventListener("pagehide", () => {
  cancelFrame(driveLenis);
  lenis.destroy();
}, { once: true });

const progress = document.querySelector(".scroll-progress");
if (progress) scroll(animate(progress, { scaleX: [0, 1] }, { ease: "linear" }));

const hero = document.querySelector(".hero");
if (hero && !reduceMotion.matches) {
  const parallax = animate(hero, {
    "--hero-parallax": ["0px", "130px"],
    "--hero-content-parallax": ["0px", "-26px"],
  }, { ease: "linear" });
  scroll(parallax, { target: hero, offset: ["start start", "end start"] });
}

const revealItems = document.querySelectorAll(
  ".section-tag, .intro-grid > *, .work-title, .work-card, .control-grid > *, .archive-grid > *, .reference-strip, .motion-inner > *, .contact-inner > *"
);
if (!reduceMotion.matches && revealItems.length) {
  inView([...revealItems], (element) => {
    animate(element, { opacity: [0, 1], y: [22, 0] }, {
      duration: 0.72,
      ease: [0.22, 1, 0.36, 1],
    });
  }, { margin: "0px 0px -8% 0px" });
}

const heroVideo = document.querySelector(".hero-video");
const projectVideos = [...document.querySelectorAll(".play-on-view")];
if (projectVideos.length) {
  inView(projectVideos, (video) => {
    if (!reduceMotion.matches) video.play().catch(() => {});
    return () => video.pause();
  }, { margin: "0px 0px -10% 0px" });
}

const syncMotionPreference = () => {
  if (reduceMotion.matches) {
    heroVideo?.pause();
    projectVideos.forEach((video) => video.pause());
  } else {
    heroVideo?.play().catch(() => {});
    projectVideos.forEach((video) => {
      const bounds = video.getBoundingClientRect();
      if (bounds.bottom > 0 && bounds.top < window.innerHeight) video.play().catch(() => {});
    });
  }
};
syncMotionPreference();
reduceMotion.addEventListener?.("change", syncMotionPreference);

