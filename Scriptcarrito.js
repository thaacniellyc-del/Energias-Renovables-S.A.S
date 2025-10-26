const botones = document.querySelectorAll('.producto button');
const listaCarrito = document.querySelector("#lista-carrito");
const totalElement = document.querySelector("#total");

let carrito = [];
let total = 0;

// 🔹 Cargar carrito guardado en LocalStorage
document.addEventListener("DOMContentLoaded", () => {
  const carritoGuardado = JSON.parse(localStorage.getItem("carrito"));
  if (carritoGuardado) {
    carrito = carritoGuardado;
    total = carrito.reduce((acc, item) => acc + item.precio, 0);
    renderCarrito();
  }
});

// 🔹 Agregar producto al carrito
botones.forEach((boton, index) => {
  boton.addEventListener('click', () => {
    const producto = document.querySelectorAll('.producto')[index];
    const nombre = producto.querySelector('.informacion p').textContent;
    const precioTexto = producto.querySelector('.precio').textContent.replace('$', '').replace('.99','');
    const precio = parseFloat(precioTexto);

    const item = { nombre, precio, id: Date.now() };
    carrito.push(item);
    total += precio;

    guardarCarrito();
    renderCarrito();
  });
});

// 🔹 Eliminar producto del carrito
listaCarrito.addEventListener('click', (e) => {
  if (e.target.classList.contains('eliminar')) {
    const id = parseInt(e.target.getAttribute('data-id'));

    const producto = carrito.find(item => item.id === id);
    if (producto) {
      total -= producto.precio;
      carrito = carrito.filter(item => item.id !== id);

      guardarCarrito();
      renderCarrito();
    }
  }
});

// 🔹 Guardar en LocalStorage
function guardarCarrito() {
  localStorage.setItem("carrito", JSON.stringify(carrito));
}

// 🔹 Renderizar carrito en pantalla
function renderCarrito() {
  listaCarrito.innerHTML = "";

  carrito.forEach(item => {
    const li = document.createElement("li");
    li.innerHTML = `
      ${item.nombre} - $${item.precio}
      <button class="eliminar" data-id="${item.id}">❌</button>
    `;
    listaCarrito.appendChild(li);
  });

  totalElement.textContent = `Total: $${total}`;
}