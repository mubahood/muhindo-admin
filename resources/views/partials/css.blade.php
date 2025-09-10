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
        --bs-primary: <?php echo $primary_color; ?>;
        --bs-primary-rgb: <?php echo $focus_rgb; ?>;
    }
    
    /* Bootstrap 5 Button Primary Overrides */
    .btn-primary {
        --bs-btn-color: #fff;
        --bs-btn-bg: <?php echo $primary_color; ?>;
        --bs-btn-border-color: <?php echo $primary_color; ?>;
        --bs-btn-hover-color: #fff;
        --bs-btn-hover-bg: <?php echo $primary_hover; ?>;
        --bs-btn-hover-border-color: <?php echo $primary_hover; ?>;
        --bs-btn-focus-shadow-rgb: <?php echo $focus_rgb; ?>;
        --bs-btn-active-color: #fff;
        --bs-btn-active-bg: <?php echo $primary_active; ?>;
        --bs-btn-active-border-color: <?php echo $primary_active; ?>;
        --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        --bs-btn-disabled-color: #fff;
        --bs-btn-disabled-bg: <?php echo $primary_color; ?>;
        --bs-btn-disabled-border-color: <?php echo $primary_color; ?>;
    }
    
    /* Bootstrap 5 Form Controls Primary */
    .form-control:focus,
    .form-select:focus {
        border-color: <?php echo $primary_color; ?>;
        box-shadow: 0 0 0 0.25rem rgba(<?php echo $focus_rgb; ?>, 0.25);
    }
    
    /* Bootstrap 5 Links */
    .link-primary {
        color: <?php echo $primary_color; ?> !important;
    }
    
    /* Bootstrap 5 Alerts */
    .alert-primary {
        --bs-alert-color: var(--bs-primary-text-emphasis);
        --bs-alert-bg: var(--bs-primary-bg-subtle);
        --bs-alert-border-color: var(--bs-primary-border-subtle);
        background-color: rgba(<?php echo $focus_rgb; ?>, 0.1);
        border-color: rgba(<?php echo $focus_rgb; ?>, 0.2);
        color: <?php echo $primary_active; ?>;
    }
    
    /* Bootstrap 5 Badge Primary */
    .badge.bg-primary {
        background-color: <?php echo $primary_color; ?> !important;
    }
    
    /* Bootstrap 5 Progress Bar */
    .progress-bar {
        background-color: <?php echo $primary_color; ?>;
    }
    
    /* Bootstrap 5 Text Primary */
    .text-primary {
        color: <?php echo $primary_color; ?> !important;
    }
    
    /* Bootstrap 5 Background Primary */
    .bg-primary {
        background-color: <?php echo $primary_color; ?> !important;
    }
    
    /* Bootstrap 5 Border Primary */
    .border-primary {
        border-color: <?php echo $primary_color; ?> !important;
    }
    
    /* AdminLTE Navbar Primary Integration */
    .navbar-primary {
        background-color: <?php echo $primary_color; ?> !important;
    }
    
    /* AdminLTE Sidebar Primary Accents */
    .main-sidebar .nav-link.active {
        background-color: rgba(<?php echo $focus_rgb; ?>, 0.1);
        color: <?php echo $primary_color; ?>;
    }
    
    /* AdminLTE Card Primary Header */
    .card-primary .card-header {
        background-color: <?php echo $primary_color; ?>;
        border-color: <?php echo $primary_color; ?>;
    }
</style>
