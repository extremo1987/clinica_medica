<div id="sidebar" aria-hidden="false">
    <h3 class="fw-bold mb-4">Clínica Médica</h3>
    
    {{-- DASHBOARD --}}
    <a href="{{ url('/dashboard') }}"
       class="sidebar-link {{ request()->is('dashboard') ? 'active' : '' }}">
        Dashboard
    </a>

    {{-- PACIENTES --}}
    <a href="{{ route('pacientes.index') }}"
       class="sidebar-link {{ request()->is('pacientes*') ? 'active' : '' }}">
        Pacientes
    </a>

    {{-- EXÁMENES (próximo módulo) --}}
    <a href="#" class="sidebar-link">
        Exámenes
    </a>

    {{-- REPORTES (próximo módulo) --}}
    <a href="#" class="sidebar-link">
        Reportes
    </a>

    {{-- CONFIGURACIÓN (solo Admin) --}}
    @if(auth()->check() && auth()->user()->hasRole('admin'))
        <a href="{{ route('settings.index') }}"
           class="sidebar-link {{ request()->is('configuracion') ? 'active' : '' }}">
            Configuración
        </a>
    @endif

    {{-- ===================================== --}}
    {{--    MÓDULO USUARIOS, ROLES Y PERMISOS   --}}
    {{-- ===================================== --}}
    @if(auth()->check() && (
        auth()->user()->hasRole('admin') ||
        auth()->user()->hasPermission('users.view') ||
        auth()->user()->hasPermission('users.manage')
    ))

        {{-- USUARIOS --}}
        <a href="{{ route('users.index') }}"
           class="sidebar-link {{ request()->is('users*') ? 'active' : '' }}">
            Usuarios
        </a>

        {{-- ROLES --}}
        @if(auth()->user()->hasRole('admin') ||
            auth()->user()->hasPermission('roles.view') ||
            auth()->user()->hasPermission('roles.manage'))
            
            <a href="{{ route('roles.index') }}"
               class="sidebar-link sub-link {{ request()->is('roles*') ? 'active' : '' }}"
               style="margin-left:18px;">
                • Roles
            </a>
        @endif

        {{-- PERMISOS --}}
        @if(auth()->user()->hasRole('admin') ||
            auth()->user()->hasPermission('permissions.view') ||
            auth()->user()->hasPermission('permissions.manage'))

            <a href="{{ route('permissions.index') }}"
               class="sidebar-link sub-link {{ request()->is('permissions*') ? 'active' : '' }}"
               style="margin-left:18px;">
                • Permisos
            </a>
        @endif

    @endif

</div>
