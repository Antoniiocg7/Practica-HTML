document.addEventListener('DOMContentLoaded', function() {
    console.log('Nav.js - DOM cargado');
    cargarNavbar();
});

function cargarNavbar() {
    fetch('nav.html')
        .then(response => response.text())
        .then(html => {
            // Insertar el navbar
            document.body.insertAdjacentHTML('afterbegin', html);
            
            // Resaltar página actual
            const currentPage = window.location.pathname.split('/').pop() || 'index.html';
            console.log('Página actual:', currentPage);
            
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => {
                const href = item.getAttribute('href');
                if (href === currentPage) {
                    item.style.backgroundColor = '#4CAF50';
                    item.style.color = 'white';
                    item.style.fontWeight = 'bold';
                }
            });
        })
        .catch(error => console.error('Error cargando navbar:', error));
}