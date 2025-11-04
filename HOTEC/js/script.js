// Guardar nuevo usuario
function registrar(e) {
  e.preventDefault();
  const usuarios = JSON.parse(localStorage.getItem("usuarios")) || [];

  const nuevo = {
    id: Date.now(),
    nombre: document.getElementById("nombre").value,
    apellido: document.getElementById("apellido").value,
    correo: document.getElementById("correo").value,
    password: document.getElementById("password").value
  };

  if (usuarios.find(u => u.correo === nuevo.correo)) {
    alert("El correo ya está registrado.");
    return;
  }

  usuarios.push(nuevo);
  localStorage.setItem("usuarios", JSON.stringify(usuarios));
  alert("Registro exitoso. Ahora inicia sesión.");
  window.location.href = "login.html";
}

// Login
function login(e) {
  e.preventDefault();
  const correo = document.getElementById("correo").value;
  const password = document.getElementById("password").value;
  const usuarios = JSON.parse(localStorage.getItem("usuarios")) || [];

  const user = usuarios.find(u => u.correo === correo && u.password === password);

  if (user) {
    localStorage.setItem("usuarioActivo", JSON.stringify(user));
    alert("Bienvenido " + user.nombre);
    window.location.href = "reserva.html";
  } else {
    alert("Correo o contraseña incorrectos.");
  }
}

// Reservar
function reservar(e) {
  e.preventDefault();
  const user = JSON.parse(localStorage.getItem("usuarioActivo"));
  if (!user) {
    alert("No has iniciado sesión.");
    return;
  }

  const reserva = {
    id_usuario: user.id,
    nombre: user.nombre,
    apellido: user.apellido,
    checkin: document.getElementById("checkin").value,
    checkout: document.getElementById("checkout").value,
    nacionalidad: document.getElementById("pais").value,
    habitacion: document.getElementById("habitacion").value
  };

  const reservas = JSON.parse(localStorage.getItem("reservas")) || [];
  reservas.push(reserva);
  localStorage.setItem("reservas", JSON.stringify(reservas));
  alert("Reserva registrada correctamente.");
}
