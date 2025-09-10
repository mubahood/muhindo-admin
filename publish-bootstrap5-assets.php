<?php
/**
 * Bootstrap 5 Asset Publisher
 * 
 * This script simulates what happens when you publish assets in a Laravel app
 * and creates a test environment to demonstrate Bootstrap 5 changes.
 */

echo "🚀 Publishing Muhindo Admin Bootstrap 5 Assets...\n\n";

$packagePath = '/Applications/MAMP/htdocs/muhindo-admin';
$publicPath = $packagePath . '/public-test/vendor/muhindo-admin';

// Create public directory structure
$directories = [
    $publicPath,
    $publicPath . '/bootstrap5/css',
    $publicPath . '/bootstrap5/js', 
    $publicPath . '/css',
    $publicPath . '/font-awesome-6.4.2/css',
    $publicPath . '/font-awesome-6.4.2/webfonts',
    $publicPath . '/muhindo-core',
    $publicPath . '/AdminLTE/dist/css',
    $publicPath . '/AdminLTE/dist/js',
    $publicPath . '/AdminLTE/plugins/slimScroll',
    $publicPath . '/laravel-admin',
    $publicPath . '/jquery-pjax',
    $publicPath . '/nprogress',
    $publicPath . '/nestable',
    $publicPath . '/toastr/build',
    $publicPath . '/sweetalert2/dist',
    $publicPath . '/jquery',
    $publicPath . '/google-fonts',
    $publicPath . '/bootstrap3-editable/js',
    $publicPath . '/bootstrap3-editable/css',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "✅ Created directory: {$dir}\n";
    }
}

// Copy Bootstrap 5 assets
$assets = [
    // Bootstrap 5 CSS
    'resources/assets/bootstrap5/css/bootstrap.min.css' => 'bootstrap5/css/bootstrap.min.css',
    
    // Bootstrap 5 JS
    'resources/assets/bootstrap5/js/bootstrap.bundle.min.js' => 'bootstrap5/js/bootstrap.bundle.min.js',
    
    // Muhindo Core CSS (our custom AdminLTE)
    'resources/assets/muhindo-core/main.css' => 'muhindo-core/main.css',
    
    // Font Awesome 6.4.2
    'resources/assets/font-awesome-6.4.2/css/all.min.css' => 'font-awesome-6.4.2/css/all.min.css',
    'resources/assets/font-awesome-6.4.2/webfonts/fa-brands-400.woff2' => 'font-awesome-6.4.2/webfonts/fa-brands-400.woff2',
    'resources/assets/font-awesome-6.4.2/webfonts/fa-brands-400.ttf' => 'font-awesome-6.4.2/webfonts/fa-brands-400.ttf',
    'resources/assets/font-awesome-6.4.2/webfonts/fa-regular-400.woff2' => 'font-awesome-6.4.2/webfonts/fa-regular-400.woff2',
    'resources/assets/font-awesome-6.4.2/webfonts/fa-regular-400.ttf' => 'font-awesome-6.4.2/webfonts/fa-regular-400.ttf',
    'resources/assets/font-awesome-6.4.2/webfonts/fa-solid-900.woff2' => 'font-awesome-6.4.2/webfonts/fa-solid-900.woff2',
    'resources/assets/font-awesome-6.4.2/webfonts/fa-solid-900.ttf' => 'font-awesome-6.4.2/webfonts/fa-solid-900.ttf',
    
    // AdminLTE CSS
    'resources/assets/AdminLTE/dist/css/AdminLTE.min.css' => 'AdminLTE/dist/css/AdminLTE.min.css',
    
    // AdminLTE JavaScript (now properly available in AdminLTE directory)
    'resources/assets/AdminLTE/dist/js/adminlte.min.js' => 'AdminLTE/dist/js/adminlte.min.js',
    
    // AdminLTE Plugins
    'resources/assets/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js' => 'AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js',
    
    // Laravel Admin
    'resources/assets/laravel-admin/laravel-admin.js' => 'laravel-admin/laravel-admin.js',
    
    // jQuery
    'resources/assets/jquery/jquery-3.7.1.min.js' => 'jquery/jquery-3.7.1.min.js',
    
    // jQuery PJAX
    'resources/assets/jquery-pjax/jquery.pjax.js' => 'jquery-pjax/jquery.pjax.js',
    
    // NProgress
    'resources/assets/nprogress/nprogress.js' => 'nprogress/nprogress.js',
    'resources/assets/nprogress/nprogress.css' => 'nprogress/nprogress.css',
    
    // Nestable
    'resources/assets/nestable/jquery.nestable.js' => 'nestable/jquery.nestable.js',
    'resources/assets/nestable/nestable.css' => 'nestable/nestable.css',
    
    // Toastr
    'resources/assets/toastr/build/toastr.min.js' => 'toastr/build/toastr.min.js',
    'resources/assets/toastr/build/toastr.min.css' => 'toastr/build/toastr.min.css',
    
    // SweetAlert2
    'resources/assets/sweetalert2/dist/sweetalert2.min.js' => 'sweetalert2/dist/sweetalert2.min.js',
    'resources/assets/sweetalert2/dist/sweetalert2.css' => 'sweetalert2/dist/sweetalert2.css',
    
    // Google Fonts
    'resources/assets/google-fonts/fonts.css' => 'google-fonts/fonts.css',
    
    // Bootstrap 3 Editable (required by laravel-admin.js)
    'resources/assets/bootstrap3-editable/js/bootstrap-editable.min.js' => 'bootstrap3-editable/js/bootstrap-editable.min.js',
    'resources/assets/bootstrap3-editable/css/bootstrap-editable.css' => 'bootstrap3-editable/css/bootstrap-editable.css',
];

$copied = 0;
$skipped = 0;

foreach ($assets as $source => $dest) {
    $sourcePath = $packagePath . '/' . $source;
    $destPath = $publicPath . '/' . $dest;
    
    if (file_exists($sourcePath)) {
        copy($sourcePath, $destPath);
        echo "✅ Copied: {$source} → {$dest}\n";
        $copied++;
    } else {
        echo "⚠️  Skipped: {$source} (not found)\n";
        $skipped++;
    }
}

echo "\n📊 Summary:\n";
echo "✅ Assets copied: {$copied}\n";
echo "⚠️  Assets skipped: {$skipped}\n";

// Create a test admin layout file to demonstrate Bootstrap 5
$testLayout = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muhindo Admin - Bootstrap 5 Test Layout</title>
    
    <!-- Published Assets - Order matches HasAssets.php $baseCss array -->
    <link href="vendor/muhindo-admin/bootstrap5/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/muhindo-admin/font-awesome-6.4.2/css/all.min.css" rel="stylesheet">
    <link href="vendor/muhindo-admin/muhindo-core/main.css" rel="stylesheet">
    <link href="vendor/muhindo-admin/nprogress/nprogress.css" rel="stylesheet">
    <link href="vendor/muhindo-admin/sweetalert2/dist/sweetalert2.css" rel="stylesheet">
    <link href="vendor/muhindo-admin/nestable/nestable.css" rel="stylesheet">
    <link href="vendor/muhindo-admin/toastr/build/toastr.min.css" rel="stylesheet">
    <link href="vendor/muhindo-admin/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet">
    <link href="vendor/muhindo-admin/google-fonts/fonts.css" rel="stylesheet">
    
    <style>
        .admin-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 0;
        }
        .sidebar {
            background: #343a40;
            min-height: 100vh;
            color: white;
        }
        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            padding: 0.5rem 1rem;
            display: block;
        }
        .sidebar a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        .content-wrapper {
            padding: 2rem;
        }
    </style>
</head>
<body>
    <!-- Admin Header -->
    <header class="admin-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="mb-0">
                        <i class="fa fa-cogs me-2"></i>
                        Muhindo Admin Panel
                    </h4>
                    <small class="opacity-75">Bootstrap 5 Enhanced</small>
                </div>
                <div class="col-md-6 text-end">
                    <div class="btn-group">
                        <button class="btn btn-outline-light btn-sm">
                            <i class="fa fa-user me-1"></i> Profile
                        </button>
                        <button class="btn btn-outline-light btn-sm">
                            <i class="fa fa-sign-out me-1"></i> Logout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 sidebar">
                <div class="p-3">
                    <h6 class="text-uppercase text-muted">Navigation</h6>
                    <a href="#"><i class="fa fa-dashboard me-2"></i> Dashboard</a>
                    <a href="#"><i class="fa fa-users me-2"></i> Users</a>
                    <a href="#"><i class="fa fa-cog me-2"></i> Settings</a>
                    <a href="#"><i class="fa fa-file-o me-2"></i> Content</a>
                </div>
            </nav>
            
            <!-- Main Content -->
            <main class="col-md-10 content-wrapper">
                <div class="row mb-4">
                    <div class="col">
                        <h1 class="h3">Bootstrap 5 Form Components</h1>
                        <p class="text-muted">Demonstrating the migrated form templates and Bootstrap 5 styling</p>
                    </div>
                </div>
                
                <!-- Bootstrap 5 Components Showcase -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fa fa-edit me-2"></i>
                                    User Profile Form
                                </h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <!-- Text Input -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" value="John Doe">
                                        <div class="form-text">Enter your full legal name</div>
                                    </div>
                                    
                                    <!-- Email with validation -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control is-invalid" id="email" value="invalid.email">
                                        <div class="invalid-feedback">Please provide a valid email address</div>
                                    </div>
                                    
                                    <!-- Select -->
                                    <div class="mb-3">
                                        <label for="role" class="form-label">User Role</label>
                                        <select class="form-select" id="role">
                                            <option value="">Choose role...</option>
                                            <option value="admin" selected>Administrator</option>
                                            <option value="editor">Editor</option>
                                            <option value="viewer">Viewer</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Textarea -->
                                    <div class="mb-3">
                                        <label for="bio" class="form-label">Biography</label>
                                        <textarea class="form-control" id="bio" rows="3" placeholder="Tell us about yourself..."></textarea>
                                    </div>
                                    
                                    <!-- Input Group -->
                                    <div class="mb-3">
                                        <label for="website" class="form-label">Website</label>
                                        <div class="input-group">
                                            <span class="input-group-text">https://</span>
                                            <input type="text" class="form-control" id="website" placeholder="example.com">
                                        </div>
                                    </div>
                                    
                                    <!-- Checkboxes -->
                                    <div class="mb-3">
                                        <label class="form-label">Permissions</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="perm1" checked>
                                            <label class="form-check-label" for="perm1">Can edit content</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="perm2">
                                            <label class="form-check-label" for="perm2">Can manage users</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="perm3">
                                            <label class="form-check-label" for="perm3">Can access settings</label>
                                        </div>
                                    </div>
                                    
                                    <!-- Radio buttons -->
                                    <div class="mb-3">
                                        <label class="form-label">Account Status</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="active" value="active" checked>
                                            <label class="form-check-label" for="active">Active</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="inactive" value="inactive">
                                            <label class="form-check-label" for="inactive">Inactive</label>
                                        </div>
                                    </div>
                                    
                                    <!-- Action buttons -->
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save me-1"></i> Save Changes
                                        </button>
                                        <button type="button" class="btn btn-secondary">
                                            <i class="fa fa-times me-1"></i> Cancel
                                        </button>
                                        <button type="button" class="btn btn-outline-danger">
                                            <i class="fa fa-trash me-1"></i> Delete
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <!-- Migration Status Card -->
                        <div class="card mb-3">
                            <div class="card-header bg-success text-white">
                                <h6 class="card-title mb-0">
                                    <i class="fa fa-check-circle me-1"></i>
                                    Migration Status
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <small class="text-muted">Form Templates</small>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" style="width: 100%">5/5</div>
                                    </div>
                                </div>
                                
                                <div class="mb-2">
                                    <small class="text-muted">Bootstrap 5 Assets</small>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" style="width: 100%">Complete</div>
                                    </div>
                                </div>
                                
                                <div class="mb-2">
                                    <small class="text-muted">Laravel 12.x Compatibility</small>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" style="width: 100%">Complete</div>
                                    </div>
                                </div>
                                
                                <hr>
                                <div class="text-center">
                                    <span class="badge bg-success">All Systems Ready</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Class Comparison -->
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Class Migration</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Bootstrap 3</th>
                                            <th>Bootstrap 5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>.control-label</code></td>
                                            <td><code>.form-label</code></td>
                                        </tr>
                                        <tr>
                                            <td><code>.has-error</code></td>
                                            <td><code>.is-invalid</code></td>
                                        </tr>
                                        <tr>
                                            <td><code>.help-block</code></td>
                                            <td><code>.form-text</code></td>
                                        </tr>
                                        <tr>
                                            <td><code>.input-group-addon</code></td>
                                            <td><code>.input-group-text</code></td>
                                        </tr>
                                        <tr>
                                            <td><code>.checkbox</code></td>
                                            <td><code>.form-check</code></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Published JavaScript - Order matches HasAssets.php $baseJs array -->
    <script>
        // Define LA object (CRITICAL for laravel-admin.js)
        function LA() {}
        LA.token = "dummy-token-for-testing";
        LA.user = {"id": 1, "name": "Test User"};
        console.log('✅ LA object defined for testing');
    </script>
    
    <script src="vendor/muhindo-admin/jquery/jquery-3.7.1.min.js"></script>
    <script src="vendor/muhindo-admin/bootstrap5/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/muhindo-admin/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="vendor/muhindo-admin/jquery-pjax/jquery.pjax.js"></script>
    <script src="vendor/muhindo-admin/nprogress/nprogress.js"></script>
    <script src="vendor/muhindo-admin/nestable/jquery.nestable.js"></script>
    <script src="vendor/muhindo-admin/toastr/build/toastr.min.js"></script>
    <script src="vendor/muhindo-admin/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="vendor/muhindo-admin/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script src="vendor/muhindo-admin/AdminLTE/dist/js/adminlte.min.js"></script>
    <script src="vendor/muhindo-admin/laravel-admin/laravel-admin.js"></script>
    
    <script>
        // Initialize tooltips and other Bootstrap 5 components
        document.addEventListener('DOMContentLoaded', function() {
            // Bootstrap 5 tooltip initialization
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            console.log('🎉 Bootstrap 5 components initialized!');
            console.log('✅ All JavaScript assets loaded successfully!');
        });
    </script>
</body>
</html>
HTML;

file_put_contents($packagePath . '/public-test/admin-bootstrap5-test.html', $testLayout);
echo "\n✅ Created test layout: public-test/admin-bootstrap5-test.html\n";

echo "\n🌐 To view the Bootstrap 5 changes:\n";
echo "   Open: file://{$packagePath}/public-test/admin-bootstrap5-test.html\n";
echo "\n📝 In a real Laravel app, assets would be published to:\n";
echo "   public/vendor/muhindo-admin/\n";
echo "\n🚀 Next steps:\n";
echo "   1. Create a new Laravel app\n";
echo "   2. Add this package as a dependency\n";
echo "   3. Run: php artisan vendor:publish --provider=\"Muhindo\\Admin\\AdminServiceProvider\"\n";
echo "   4. Visit admin routes to see Bootstrap 5 in action\n\n";

?>
