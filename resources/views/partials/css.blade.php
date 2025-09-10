@foreach ($css as $c)
    <link rel="stylesheet" href="{{ admin_asset("$c") }}">
@endforeach

<?php 
    // Dynamic Primary Color Configuration
    // This will override all Bootstrap 5 primary color variables
    
    // Map old AdminLTE skin names to modern hex colors
    $skin_color_map = [
        'skin-blue' => '#007bff',
        'skin-blue-light' => '#0d6efd',
        'skin-green' => '#198754',
        'skin-green-light' => '#20c997',
        'skin-yellow' => '#ffc107',
        'skin-yellow-light' => '#ffeb3b',
        'skin-purple' => '#6f42c1',
        'skin-purple-light' => '#9c27b0',
        'skin-red' => '#dc3545',
        'skin-red-light' => '#e57373',
        'skin-black' => '#343a40',
        'skin-black-light' => '#6c757d',
    ];
    
    // Get primary color from config, with fallback to skin mapping
    $configured_color = config('admin.primary_color');
    $admin_skin = config('admin.skin', 'skin-green');
    
    // If primary_color is not set, map from skin
    if (!$configured_color && isset($skin_color_map[$admin_skin])) {
        $primary_color = $skin_color_map[$admin_skin];
    } else {
        $primary_color = $configured_color ?: '#198754'; // Default green
    }
        //override $primary_active and make it red colour
    $primary_active = '#dc3545'; // Red color for active state
    
    // Calculate hover and active shades (darker)
    $primary_rgb = sscanf($primary_color, "#%02x%02x%02x");
    $primary_hover = sprintf("#%02x%02x%02x", 
        max(0, $primary_rgb[0] - 25), 
        max(0, $primary_rgb[1] - 25), 
        max(0, $primary_rgb[2] - 25)
    );
    $primary_active = sprintf("#%02x%02x%02x", 
        max(0, $primary_rgb[0] - 35), 
        max(0, $primary_rgb[1] - 35), 
        max(0, $primary_rgb[2] - 35)
    );


    
    // Convert to RGB for focus shadows
    $focus_rgb = implode(', ', $primary_rgb);
?>
<style>
    :root {
        /* Bootstrap 5 Primary Color Variables Override */
        --bs-primary: <?php echo $primary_color; ?> !important;
        --bs-primary-rgb: <?php echo $focus_rgb; ?> !important;
        --bs-btn-color: #fff !important;
        --bs-btn-bg: <?php echo $primary_color; ?> !important;
        --bs-btn-border-color: <?php echo $primary_color; ?> !important;
        --bs-btn-hover-color: #fff !important;
        --bs-btn-hover-bg: <?php echo $primary_hover; ?> !important;
        --bs-btn-hover-border-color: <?php echo $primary_hover; ?> !important;
        --bs-btn-focus-shadow-rgb: <?php echo $focus_rgb; ?> !important;
        --bs-btn-active-color: #fff !important;
        --bs-btn-active-bg: <?php echo $primary_active; ?> !important;
        --bs-btn-active-border-color: <?php echo $primary_active; ?> !important;
        --bs-btn-disabled-color: #fff !important;
        --bs-btn-disabled-bg: <?php echo $primary_color; ?> !important;
        --bs-btn-disabled-border-color: <?php echo $primary_color; ?> !important;
        
        /* Muhindo Admin Design System Primary Color Override */
        --primary-color: <?php echo $primary_color; ?> !important;
        --accent-color: <?php echo $primary_color; ?> !important;
    }
    
    /* STRONGEST POSSIBLE BOOTSTRAP 5 BUTTON PRIMARY OVERRIDES */
    .btn-primary,
    .btn.btn-primary,
    button.btn-primary,
    input[type="submit"].btn-primary,
    .btn-primary:not(.btn-outline-primary) {
        background-color: <?php echo $primary_color; ?> !important;
        border-color: <?php echo $primary_color; ?> !important;
        color: #fff !important;
    }
    
    .btn-primary:hover,
    .btn.btn-primary:hover,
    .btn-primary:focus,
    .btn.btn-primary:focus,
    .btn-primary.focus,
    .btn.btn-primary.focus {
        background-color: <?php echo $primary_hover; ?> !important;
        border-color: <?php echo $primary_hover; ?> !important;
        color: #fff !important;
    }
    
    .btn-primary:active,
    .btn.btn-primary:active,
    .btn-primary.active,
    .btn.btn-primary.active,
    .show > .btn-primary.dropdown-toggle,
    .show > .btn.btn-primary.dropdown-toggle {
        background-color: <?php echo $primary_active; ?> !important;
        border-color: <?php echo $primary_active; ?> !important;
        color: #fff !important;
    }
    
    .btn-primary:disabled,
    .btn.btn-primary:disabled,
    .btn-primary.disabled,
    .btn.btn-primary.disabled {
        background-color: <?php echo $primary_color; ?> !important;
        border-color: <?php echo $primary_color; ?> !important;
        color: #fff !important;
        opacity: 0.65;
    }
    
    /* STRONGEST POSSIBLE FORM CONTROLS PRIMARY OVERRIDES */
    .form-control:focus,
    .form-select:focus,
    input:focus,
    textarea:focus,
    select:focus {
        border-color: <?php echo $primary_color; ?> !important;
        box-shadow: 0 0 0 0.25rem rgba(<?php echo $focus_rgb; ?>, 0.25) !important;
    }
    
    /* STRONGEST POSSIBLE TEXT PRIMARY OVERRIDES */
    .text-primary,
    .text-primary a,
    a.text-primary {
        color: <?php echo $primary_color; ?> !important;
    }
    
    .text-primary:hover,
    .text-primary a:hover,
    a.text-primary:hover {
        color: <?php echo $primary_hover; ?> !important;
    }
    
    /* STRONGEST POSSIBLE BACKGROUND PRIMARY OVERRIDES */
    .bg-primary,
    .bg-primary.card-header,
    .card-primary .card-header,
    .badge.bg-primary,
    .badge-primary {
        background-color: <?php echo $primary_color; ?> !important;
        color: #fff !important;
    }
    
    /* STRONGEST POSSIBLE BORDER PRIMARY OVERRIDES */
    .border-primary,
    .card-primary {
        border-color: <?php echo $primary_color; ?> !important;
    }
    
    /* STRONGEST POSSIBLE PROGRESS BAR OVERRIDES */
    .progress-bar,
    .progress-bar-primary {
        background-color: <?php echo $primary_color; ?> !important;
    }
    
    /* STRONGEST POSSIBLE LINK PRIMARY OVERRIDES */
    .link-primary,
    a.link-primary {
        color: <?php echo $primary_color; ?> !important;
    }
    
    .link-primary:hover,
    a.link-primary:hover,
    .link-primary:focus,
    a.link-primary:focus {
        color: <?php echo $primary_hover; ?> !important;
    }
    
    /* STRONGEST POSSIBLE ALERT PRIMARY OVERRIDES */
    .alert-primary {
        background-color: rgba(<?php echo $focus_rgb; ?>, 0.1) !important;
        border-color: rgba(<?php echo $focus_rgb; ?>, 0.2) !important;
        color: <?php echo $primary_active; ?> !important;
    }
    
    /* STRONGEST POSSIBLE NAVBAR PRIMARY OVERRIDES */
    .navbar-primary,
    .main-header .navbar,
    .main-header {
        background-color: <?php echo $primary_color; ?> !important;
    }
    
    /* STRONGEST POSSIBLE SIDEBAR PRIMARY ACCENTS OVERRIDES */
    .main-sidebar .nav-link.active,
    .sidebar-menu > li.active > a,
    .sidebar-menu > li:hover > a {
        background-color: <?php echo $primary_color; ?> !important;
        color: #fff !important;
    }
    
    /* ADMIN LTE SPECIFIC OVERRIDES */
    .main-header .logo:hover {
        background-color: <?php echo $primary_hover; ?> !important;
    }
    
    .main-header .navbar .sidebar-toggle:hover {
        background-color: <?php echo $primary_hover; ?> !important;
    }
    
    .main-header .navbar .nav > li > a:hover,
    .main-header .navbar .nav > li > a:focus,
    .main-header .navbar .nav > li > a:active {
        background-color: <?php echo $primary_hover; ?> !important;
    }
    
    /* OVERRIDE ANY CSS VARIABLES FROM MAIN.CSS */
    .main-header .logo {
        background-color: <?php echo $primary_color; ?> !important;
    }
    
    .main-sidebar,
    .left-side {
        background-color: <?php echo $primary_color; ?> !important;
    }
    
    .sidebar-menu > li > .treeview-menu > li > a:hover,
    .sidebar-menu > li > .treeview-menu > li.active > a {
        background-color: <?php echo $primary_hover; ?> !important;
    }
    
    .sidebar-form .btn {
        background-color: <?php echo $primary_color; ?> !important;
        border-color: <?php echo $primary_color; ?> !important;
    }
    
    .sidebar-form .btn:hover {
        background-color: <?php echo $primary_hover; ?> !important;
    }
    
    /* OVERRIDE DROPDOWN ACTIVE STATES */
    .dropdown-item:active {
        background-color: <?php echo $primary_color; ?> !important;
        color: #fff !important;
    }
    
    /* OVERRIDE NAVIGATION TAB ACTIVE STATES */
    .nav-tabs .nav-link.active {
        color: <?php echo $primary_color; ?> !important;
    }
    
    /* OVERRIDE ANY ACCENT COLOR USAGE IN MAIN.CSS */
    body {
        --accent-color: <?php echo $primary_color; ?> !important;
        --primary-color: <?php echo $primary_color; ?> !important;
        --bs-primary: <?php echo $primary_color; ?> !important;
    }
</style>
