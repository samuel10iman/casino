function redirectTo(page) {
    window.location.href = page;
}

document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById('loginForm');
    loginForm.addEventListener('submit', login);
});

function login(event) {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    // Aquí puedes agregar la lógica de autenticación
    console.log('Intento de inicio de sesión:', { username, password });

    // Simulación de autenticación
    if (username === 'admin' && password === 'password') {
        alert('Inicio de sesión exitoso');
        const loginContainer = document.getElementById('login');
        loginContainer.classList.add('hidden');
        const infoBox = document.getElementById('info');
        infoBox.classList.remove('hidden');
    } else {
        alert('Usuario o contraseña incorrectos');
    }
}

function showContent(title) {
    document.getElementById('content-title').innerText = title;
    document.getElementById('content').classList.remove('hidden');
    document.getElementById('content-options').classList.remove('hidden');
    hideAllForms();
}

function hideAllForms() {
    document.getElementById('add-form').classList.add('hidden');
    document.getElementById('delete-form').classList.add('hidden');
    document.getElementById('search-form').classList.add('hidden');
    document.getElementById('search-results').innerText = '';
}

function showAddForm() {
    hideAllForms();
    document.getElementById('add-form').classList.remove('hidden');
}

function showDeleteForm() {
    hideAllForms();
    document.getElementById('delete-form').classList.remove('hidden');
}

function showSearchForm() {
    hideAllForms();
    document.getElementById('search-form').classList.remove('hidden');
}

function addData(event) {
    event.preventDefault();
    const data = document.getElementById('add-data').value;
    // Lógica para añadir datos a la base de datos
    console.log('Datos añadidos:', data);
    alert('Datos añadidos: ' + data);
    document.getElementById('add-data').value = '';
}

function deleteData(event) {
    event.preventDefault();
    const data = document.getElementById('delete-data').value;
    // Lógica para eliminar datos de la base de datos
    console.log('Datos eliminados:', data);
    alert('Datos eliminados: ' + data);
    document.getElementById('delete-data').value = '';
}

function searchData(event) {
    event.preventDefault();
    const data = document.getElementById('search-data').value;
    // Lógica para buscar datos en la base de datos
    console.log('Datos buscados:', data);
    const results = 'Resultados de búsqueda para: ' + data;
    document.getElementById('search-results').innerText = results;
    document.getElementById('search-data').value = '';
}
