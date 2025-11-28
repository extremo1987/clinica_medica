<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Clínica Médica</title>

  <link href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css" rel="stylesheet">

  <style>
    /* ------- SIDEBAR (ID = sidebar) ------- */
    #sidebar {
      width: 250px;
      height: 100vh;
      position: fixed;
      left: 0;
      top: 0;
      padding: 24px;
      background: linear-gradient(180deg,#1565c0 0%,#1e88e5 50%,#42a5f5 100%);
      color: #fff;
      box-shadow: 4px 0 20px rgba(0,0,0,.18);
      z-index: 2000;
      transform: translateX(0);
      transition: transform .28s ease-in-out;
    }

    /* BOTÓN: posición normal dentro del header (no tapa) */
    #toggleMenu {
        position: static !important;
        z-index: 3000;
    }

    /* BOTÓN FLOTANTE cuando el sidebar está abierto (afuera del sidebar) */
    #toggleMenu.menu-floating {
        position: fixed !important;
        top: 18px;
        /* sitúa el botón a la derecha del sidebar: ancho sidebar + 12px */
        left: calc(250px + 12px);
        z-index: 4000;
    }

    /* hide sidebar by default on small screens */
    @media (max-width: 767.98px) {
      #sidebar { transform: translateX(-260px); }
      /* make sidebar visible when opened */
      #sidebar.sidebar-open {
        transform: translateX(0);
        position: fixed;
      }
    }

    /* content area */
    .page-wrapper { margin-left: 250px; transition: margin .28s ease; }
    @media (max-width: 767.98px) { .page-wrapper { margin-left: 0; } }

    /* links */
    .sidebar-link {
      display:block;
      padding:10px 12px;
      color: #fff;
      text-decoration: none;
      border-radius: 8px;
      margin-bottom: 8px;
      transition: background .18s;
      font-size: 15px;
    }
    .sidebar-link:hover { background: rgba(255,255,255,0.18); }
    .sidebar-link.active { background: rgba(255,255,255,0.32); font-weight:700; }

    /* ensure toggle button visible only on small screens */
    .menu-toggle { display:none; }
    @media (max-width: 767.98px) { .menu-toggle { display:inline-flex; } }

    /* small visual tweak: rounded floating button */
    #toggleMenu.menu-floating {
      width: 40px;
      height: 40px;
      border-radius: 999px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
    }
  </style>
</head>
<body>

  <!-- SIDEBAR -->
  @include('components.sidebar')


  <!-- PAGE -->
  <div class="page-wrapper">
    <!-- HEADER -->
    <header class="navbar navbar-light bg-white shadow-sm px-3">
      <div class="container-fluid d-flex align-items-center">

        <!-- Toggle (móvil) -->
        <button id="toggleMenu" class="btn btn-outline-primary menu-toggle me-3" aria-expanded="false" aria-controls="sidebar">☰</button>

        <h2 class="m-0">Panel Clínico</h2>

        <div class="ms-auto d-flex align-items-center">
          <span class="fw-bold me-3">{{ auth()->user()->name }}</span>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-danger btn-sm">Salir</button>
          </form>
        </div>
      </div>
    </header>

    <!-- MAIN CONTENT -->
    <div class="page-body">
      <div class="container-xl">
        @yield('content')
      </div>
    </div>
  </div>

  
  <!-- Tabler JS (opcional) -->
  <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>

  <!-- Script: esperar DOM y luego conectar listeners -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const btn = document.getElementById('toggleMenu');
      const sidebar = document.getElementById('sidebar');

      if (!btn || !sidebar) return;

      function openSidebar() {
        sidebar.classList.add('sidebar-open');
        btn.classList.add('menu-floating');
        btn.innerHTML = '✖';
        btn.setAttribute('aria-expanded','true');
        sidebar.setAttribute('aria-hidden','false');
      }

      function closeSidebar() {
        sidebar.classList.remove('sidebar-open');
        btn.classList.remove('menu-floating');
        btn.innerHTML = '☰';
        btn.setAttribute('aria-expanded','false');
        sidebar.setAttribute('aria-hidden','true');
      }

      // Toggle on button click
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        if (sidebar.classList.contains('sidebar-open')) {
          closeSidebar();
        } else {
          openSidebar();
        }
      });

      // Click outside to close (mobile only)
      document.addEventListener('click', function (e) {
        const isSmall = window.matchMedia('(max-width: 767.98px)').matches;
        if (!isSmall) return;
        if (!sidebar.classList.contains('sidebar-open')) return;
        if (!sidebar.contains(e.target) && !btn.contains(e.target)) {
          closeSidebar();
        }
      });

      // Escape key closes sidebar on mobile
      document.addEventListener('keydown', function(e){
        if (e.key === 'Escape' && sidebar.classList.contains('sidebar-open')) {
          closeSidebar();
        }
      });

      // On resize, ensure consistent state
      window.addEventListener('resize', function () {
        if (window.matchMedia('(min-width: 768px)').matches) {
          // ensure sidebar visible on desktop and button back to normal
          sidebar.classList.remove('sidebar-open');
          btn.classList.remove('menu-floating');
          btn.innerHTML = '☰';
          btn.setAttribute('aria-expanded','false');
          sidebar.setAttribute('aria-hidden','false');
        } else {
          // mobile - keep closed by default
          sidebar.setAttribute('aria-hidden', sidebar.classList.contains('sidebar-open') ? 'false' : 'true');
        }
      });

    });
  </script>
<script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>

<!-- Bootstrap JS necesario para el modal -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')


</body>

</html>
