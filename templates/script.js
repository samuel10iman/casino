function redirectTo(page) {
    window.location.href = page;
}

function login(event) {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    // Aquí puedes agregar la lógica de autenticación

    // Si la autenticación es exitosa, muestra el contenedor "PROBANDO"
    const barraLateral = document.getElementById('BarraLateral');
    barraLateral.classList.remove('hidden');
    const loginContainer = document.getElementById('login');
    loginContainer.classList.add('hidden');
}