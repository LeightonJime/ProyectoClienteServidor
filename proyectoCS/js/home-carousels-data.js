// Función genérica para cargar un carrusel
async function cargarCarrusel(urlApi, selectorContenedor) {
  try {
    const respuesta = await fetch(urlApi);
    if (!respuesta.ok) {
      console.error("Error al llamar a " + urlApi);
      return;
    }

    const libros = await respuesta.json();
    const contenedor = document.querySelector(selectorContenedor);

    if (!contenedor) {
      console.error("No se encontró el contenedor: " + selectorContenedor);
      return;
    }

    // Limpiamos por si hay algo
    contenedor.innerHTML = "";

    // Creamos las cards
    libros.forEach(libro => {
      const card = document.createElement("div");
      card.className = "deal-card";

      card.innerHTML = `
        <img src="${libro.imagen}" class="deal-image" alt="${libro.titulo}">
        <h4 class="deal-title">${libro.titulo}</h4>
        <p class="deal-sub">${libro.subtitulo}</p>
      `;

      contenedor.appendChild(card);
    });
  } catch (error) {
    console.error("Error cargando " + urlApi, error);
  }
}

document.addEventListener("DOMContentLoaded", function () {
  // Cargar carrusel de Libros Destacados
  cargarCarrusel("api_libros_destacados.php", "#carousel-destacados");

  // Cargar carrusel de Libros Populares
  cargarCarrusel("api_libros_populares.php", "#carousel-populares");
});
