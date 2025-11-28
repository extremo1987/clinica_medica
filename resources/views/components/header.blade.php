<header class="navbar navbar-light bg-white shadow-sm px-3">

    <div class="container-fluid">

        <!-- BOTÓN PARA ABRIR SIDEBAR EN MÓVIL -->
        <button id="toggleMenu" class="btn btn-outline-primary d-md-none me-3">
            ☰
        </button>

        <h2 class="m-0">Panel Clínico</h2>

        <div class="ms-auto">
            <span class="fw-bold me-3">{{ auth()->user()->name }}</span>

            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-danger btn-sm">Salir</button>
            </form>
        </div>

    </div>

</header>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const btn = document.getElementById('toggleMenu');
    const sidebar = document.getElementById('sidebar');

    btn.addEventListener('click', function () {

        // toggle sidebar
        sidebar.classList.toggle('sidebar-open');

        // toggle floating button
        if (sidebar.classList.contains('sidebar-open')) {
            btn.classList.add('menu-floating');
            btn.innerHTML = "✖";   // cambiar a X
        } else {
            btn.classList.remove('menu-floating');
            btn.innerHTML = "☰";   // regresar a hamburguesa
        }

    });

    // CERRAR si se toca fuera del menú (solo móvil)
    document.addEventListener('click', function (e) {

        const isMobile = window.matchMedia("(max-width: 767px)").matches;

        if (!isMobile) return;

        if (!sidebar.classList.contains("sidebar-open")) return;

        if (!sidebar.contains(e.target) && !btn.contains(e.target)) {
            sidebar.classList.remove("sidebar-open");
            btn.classList.remove("menu-floating");
            btn.innerHTML = "☰";
        }
    });

});
</script>

