function toggleMenu() {
  const menu = document.getElementById("menu");
  menu.classList.toggle("active");
}


window.addEventListener("load", () => {
  gsap.registerPlugin(ScrollTrigger);

  // animações aqui dentro
});


gsap.registerPlugin(ScrollTrigger);