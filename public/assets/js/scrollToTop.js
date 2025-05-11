// Seleccionar el botón
const scrollToTopBtn = document.getElementById("scrollToTopBtn");

// Mostrar u ocultar el botón dependiendo de la posición del scroll
window.onscroll = function () {
    if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
        scrollToTopBtn.style.display = "block"; // Mostrar
    } else {
        scrollToTopBtn.style.display = "none"; // Ocultar
    }
};

// Función para subir al inicio
scrollToTopBtn.onclick = function () {
    window.scrollTo({
        top: 0,
        behavior: "smooth" // Efecto suave
    });
};

