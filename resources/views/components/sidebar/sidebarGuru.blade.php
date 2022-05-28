<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="#" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bolder ms-2">E-Learning</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ ($title === " Dashboard") ? 'active' : '' }}">
            <a href="/dashboard" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        <!-- Kelas -->
        <li class="menu-item {{ ($title === " Kelas") ? 'active' : '' }}">
            <a href="/kelas" class="menu-link">
                <i class="menu-icon tf-icons bx bx-grid"></i>
                <div data-i18n="Analytics">Kelas</div>
            </a>
        </li>
        <!-- Materi Plejaran -->
        {{-- <li class="menu-item {{ ($title === " Materi Pelajaran") ? 'active' : '' }}">
            <a href="/materi" class="menu-link">
                <i class="menu-icon tf-icons bx bx-copy-alt"></i>
                <div data-i18n="Analytics">Materi</div>
            </a>
        </li>
        <!-- Tugas -->
        <li class="menu-item {{ ($title === " Tugas") ? 'active' : '' }}">
            <a href="/tugas" class="menu-link">
                <i class="menu-icon tf-icons bx bx-clipboard"></i>
                <div data-i18n="Analytics">Tugas</div>
            </a>
        </li> --}}

    </ul>
</aside>
