// Array de usuarios de ejemplo
const usuarios = [
    {
        nombre: "Antonio",
        apellidos: "Cañizares Gamarra",
        telefono: "123456789",
        email: "antonio@gmail.com",
        sexo: "Hombre"
    },
    {
        nombre: "Fermín",
        apellidos: "López García",
        telefono: "987654321",
        email: "maria@gmail.com",
        sexo: "Mujer"
    },
    {
        nombre: "Manuel",
        apellidos: "Hernández Pérez",
        telefono: "456789123",
        email: "pedro@gmail.com",
        sexo: "Hombre"
    }
];

window.onload = function() {
    // Cargar la tabla inicial
    cargarTabla(usuarios);
    
    // Configurar el buscador
    document.getElementById('buscador').addEventListener('input', function(e) {
        const busqueda = e.target.value.toLowerCase();
        
        if (busqueda.length >= 3) {
            const usuariosFiltrados = usuarios.filter(usuario => 
                usuario.nombre.toLowerCase().includes(busqueda) || 
                usuario.apellidos.toLowerCase().includes(busqueda)
            );
            cargarTabla(usuariosFiltrados);
        } else if (busqueda.length === 0) {
            cargarTabla(usuarios);
        }
    });

};

function cargarTabla(datos) {
    const tbody = document.getElementById('tablaBody');
    tbody.innerHTML = '';
    
    datos.forEach(usuario => {
        const tr = document.createElement('tr');
        
        // Crear celdas para cada campo
        tr.innerHTML = `
            <td>${usuario.nombre}</td>
            <td>${usuario.apellidos}</td>
            <td>${usuario.telefono}</td>
            <td>${usuario.email}</td>
            <td>${usuario.sexo}</td>
            <td><button onclick="eliminarFila(this)">X</button></td>
        `;
        
        tbody.appendChild(tr);
    });
}

function eliminarFila(boton) {
    const fila = boton.parentNode.parentNode;
    fila.remove();
}
