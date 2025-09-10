<aside class="main-sidebar p-0">
    <!-- sidebar: modern flat design structure -->
    
    <section class="sidebar">

        @if (config('admin.enable_menu_search'))
            <!-- Modern search form -->
            <form class="sidebar-form" style="overflow: initial;" onsubmit="return false;">
                <div class="input-group">
                    <input type="text" autocomplete="off" class="form-control autocomplete" placeholder="Search menu...">
                    <span class="input-group-btn">
                        <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                            <i class="fas fa-search"></i>
                        </button>
                    </span>
                    <ul class="dropdown-menu search-results" role="menu" style="min-width: 210px;max-height: 300px;overflow: auto;">
                        @foreach (Admin::menuLinks() as $link)
                            <li>
                                <a href="{{ admin_url($link['uri']) }}">
                                    <i class="fas fa-{{ str_replace('fa-', '', $link['icon'] ?? 'circle') }}"></i>
                                    {{ admin_trans($link['title']) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </form>
            <!-- /.search form -->
        @endif

        <!-- Modern Sidebar Menu with proper AdminLTE attributes -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column sidebar-menu" data-widget="treeview" role="menu" data-accordion="false">
                @each('admin::partials.menu', Admin::menu(), 'item')
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>

<!-- JavaScript to ensure treeview functionality and auto-expand active parents -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-expand parent menus if a submenu item is active
    function autoExpandActiveParents() {
        const activeSubmenus = document.querySelectorAll('.nav-treeview .nav-link.active');
        activeSubmenus.forEach(function(activeSubmenu) {
            const parentNavItem = activeSubmenu.closest('.nav-item').parentElement.closest('.nav-item');
            if (parentNavItem) {
                parentNavItem.classList.add('menu-open');
                const submenu = parentNavItem.querySelector('.nav-treeview');
                const arrow = parentNavItem.querySelector('.fa-angle-left, .right');
                if (submenu) submenu.style.display = 'block';
                if (arrow) arrow.style.transform = 'rotate(-90deg)';
            }
        });
    }
    
    // Initialize AdminLTE treeview if not already initialized
    if (typeof $.fn.Treeview !== 'undefined') {
        $('[data-widget="treeview"]').Treeview();
        // Auto-expand after AdminLTE initialization
        setTimeout(autoExpandActiveParents, 100);
    } else {
        // Fallback: manual treeview toggle
        document.querySelectorAll('.nav-link[data-widget="treeview"]').forEach(function(element) {
            element.addEventListener('click', function(e) {
                e.preventDefault();
                const parent = this.closest('.nav-item');
                const submenu = parent.querySelector('.nav-treeview');
                const arrow = this.querySelector('.fa-angle-left, .right');
                
                if (submenu) {
                    parent.classList.toggle('menu-open');
                    if (parent.classList.contains('menu-open')) {
                        submenu.style.display = 'block';
                        if (arrow) arrow.style.transform = 'rotate(-90deg)';
                    } else {
                        submenu.style.display = 'none';
                        if (arrow) arrow.style.transform = 'rotate(0deg)';
                    }
                }
            });
        });
        
        // Auto-expand immediately for fallback
        autoExpandActiveParents();
    }
});
</script>
