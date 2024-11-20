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
    
    datos.forEach((usuario, index) => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${usuario.nombre}</td>
            <td>${usuario.apellidos}</td>
            <td>${usuario.telefono}</td>
            <td>${usuario.email}</td>
            <td>${usuario.sexo}</td>
            <td>
                <button onclick="editarUsuario(${index})">Editar</button>
                <button onclick="eliminarFila(this)">Eliminar</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function eliminarFila(boton) {
    const fila = boton.parentNode.parentNode;
    fila.remove();
}

function editarUsuario(index) {
    const usuario = usuarios[index];
    
    // Crear formulario de edición
    const formHTML = `
        <div id="formEdicion" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); 
                                   background: white; padding: 20px; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0,0,0,0.5);">
            <h3>Editar Usuario</h3>
            <input type="text" id="editNombre" value="${usuario.nombre}" placeholder="Nombre"><br>
            <input type="text" id="editApellidos" value="${usuario.apellidos}" placeholder="Apellidos"><br>
            <input type="text" id="editTelefono" value="${usuario.telefono}" placeholder="Teléfono"><br>
            <input type="email" id="editEmail" value="${usuario.email}" placeholder="Email"><br>
            <select id="editSexo">
                <option value="Hombre" ${usuario.sexo === 'Hombre' ? 'selected' : ''}>Hombre</option>
                <option value="Mujer" ${usuario.sexo === 'Mujer' ? 'selected' : ''}>Mujer</option>
            </select><br>
            <button onclick="guardarCambios(${index})">Guardar</button>
            <button onclick="cerrarFormulario()">Cancelar</button>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', formHTML);
}

function guardarCambios(index) {
    usuarios[index] = {
        nombre: document.getElementById('editNombre').value,
        apellidos: document.getElementById('editApellidos').value,
        telefono: document.getElementById('editTelefono').value,
        email: document.getElementById('editEmail').value,
        sexo: document.getElementById('editSexo').value
    };
    
    cargarTabla(usuarios);
    cerrarFormulario();
}

function cerrarFormulario() {
    const form = document.getElementById('formEdicion');
    if (form) form.remove();
}
