<?php
/**
 * Bootstrap 5 Asset Diagnostic Tool
 * 
 * This script helps diagnose why Bootstrap 5 changes might not be visible
 * in the Muhindo Admin interface.
 */

echo "<h1>🔍 Muhindo Admin - Bootstrap 5 Diagnostic Report</h1>\n";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .warning{color:orange;} .info{color:blue;} code{background:#f4f4f4;padding:2px 4px;}</style>\n";

$basePath = '/Applications/MAMP/htdocs/muhindo-admin';
$issues = [];
$successes = [];

echo "<h2>📁 Asset File Verification</h2>\n";

// Check Bootstrap 5 assets
$bootstrap5Assets = [
    'resources/assets/bootstrap5/css/bootstrap.min.css' => 'Bootstrap 5 CSS',
    'resources/assets/bootstrap5/js/bootstrap.bundle.min.js' => 'Bootstrap 5 JS',
    'resources/assets/css/bootstrap5-admin-override.css' => 'Bootstrap 5 Override CSS'
];

foreach ($bootstrap5Assets as $file => $description) {
    $fullPath = $basePath . '/' . $file;
    if (file_exists($fullPath)) {
        $size = filesize($fullPath);
        echo "<div class='success'>✅ {$description}: <code>{$file}</code> ({$size} bytes)</div>\n";
        $successes[] = $description . ' found';
    } else {
        echo "<div class='error'>❌ {$description}: <code>{$file}</code> - NOT FOUND</div>\n";
        $issues[] = $description . ' missing';
    }
}

echo "<h2>🔧 HasAssets.php Configuration</h2>\n";

// Check HasAssets configuration
$hasAssetsPath = $basePath . '/src/Traits/HasAssets.php';
if (file_exists($hasAssetsPath)) {
    $content = file_get_contents($hasAssetsPath);
    
    // Check for Bootstrap 5 in baseCss
    if (strpos($content, 'bootstrap5/css/bootstrap.min.css') !== false) {
        echo "<div class='success'>✅ Bootstrap 5 CSS configured in HasAssets.php</div>\n";
        $successes[] = 'Bootstrap 5 CSS in baseCss';
    } else {
        echo "<div class='error'>❌ Bootstrap 5 CSS NOT found in HasAssets.php</div>\n";
        $issues[] = 'Bootstrap 5 CSS not in baseCss';
    }
    
    // Check for Bootstrap 5 JS
    if (strpos($content, 'bootstrap5/js/bootstrap.bundle.min.js') !== false) {
        echo "<div class='success'>✅ Bootstrap 5 JS configured in HasAssets.php</div>\n";
        $successes[] = 'Bootstrap 5 JS in baseJs';
    } else {
        echo "<div class='error'>❌ Bootstrap 5 JS NOT found in HasAssets.php</div>\n";
        $issues[] = 'Bootstrap 5 JS not in baseJs';
    }
    
    // Check for bootstrap3-editable conflicts
    if (strpos($content, 'bootstrap3-editable') !== false) {
        echo "<div class='warning'>⚠️  Bootstrap 3 editable conflicts still present</div>\n";
        $issues[] = 'Bootstrap 3 conflicts remain';
    } else {
        echo "<div class='success'>✅ Bootstrap 3 conflicts removed</div>\n";
        $successes[] = 'Bootstrap 3 conflicts cleaned';
    }
    
    // Check override CSS
    if (strpos($content, 'bootstrap5-admin-override.css') !== false) {
        echo "<div class='success'>✅ Bootstrap 5 override CSS configured</div>\n";
        $successes[] = 'Override CSS configured';
    } else {
        echo "<div class='error'>❌ Bootstrap 5 override CSS NOT configured</div>\n";
        $issues[] = 'Override CSS missing from config';
    }
    
} else {
    echo "<div class='error'>❌ HasAssets.php NOT found</div>\n";
    $issues[] = 'HasAssets.php missing';
}

echo "<h2>📝 Form Template Verification</h2>\n";

// Check form templates
$templates = [
    'resources/views/form/input.blade.php' => 'Input Template',
    'resources/views/form/textarea.blade.php' => 'Textarea Template', 
    'resources/views/form/select.blade.php' => 'Select Template',
    'resources/views/form/checkbox.blade.php' => 'Checkbox Template',
    'resources/views/form/help-block.blade.php' => 'Help Block Template'
];

foreach ($templates as $file => $description) {
    $fullPath = $basePath . '/' . $file;
    if (file_exists($fullPath)) {
        $content = file_get_contents($fullPath);
        
        // Check for Bootstrap 5 classes
        $hasBootstrap5 = false;
        $bootstrap5Classes = ['form-label', 'form-control', 'form-select', 'form-check', 'form-text', 'is-invalid'];
        
        foreach ($bootstrap5Classes as $class) {
            if (strpos($content, $class) !== false) {
                $hasBootstrap5 = true;
                break;
            }
        }
        
        if ($hasBootstrap5) {
            echo "<div class='success'>✅ {$description}: Bootstrap 5 classes found</div>\n";
            $successes[] = $description . ' updated';
        } else {
            echo "<div class='warning'>⚠️  {$description}: No Bootstrap 5 classes found</div>\n";
            $issues[] = $description . ' not updated';
        }
    } else {
        echo "<div class='error'>❌ {$description}: NOT found</div>\n";
        $issues[] = $description . ' missing';
    }
}

echo "<h2>🚀 Laravel Package Status</h2>\n";

// Check if package is installable
$composerPath = $basePath . '/composer.json';
if (file_exists($composerPath)) {
    $composer = json_decode(file_get_contents($composerPath), true);
    echo "<div class='info'>📦 Package Name: <code>{$composer['name']}</code></div>\n";
    echo "<div class='info'>📝 Description: <code>{$composer['description']}</code></div>\n";
    
    if (isset($composer['autoload']['psr-4']['Muhindo\\Admin\\'])) {
        echo "<div class='success'>✅ PSR-4 autoloading configured for Muhindo\\Admin</div>\n";
        $successes[] = 'PSR-4 autoloading correct';
    } else {
        echo "<div class='error'>❌ PSR-4 autoloading NOT configured</div>\n";
        $issues[] = 'PSR-4 autoloading missing';
    }
} else {
    echo "<div class='error'>❌ composer.json NOT found</div>\n";
    $issues[] = 'composer.json missing';
}

echo "<h2>💡 Asset Publishing Instructions</h2>\n";

echo "<div class='info'>\n";
echo "<p><strong>To see Bootstrap 5 changes in your Laravel app:</strong></p>\n";
echo "<ol>\n";
echo "<li>Install the package: <code>composer require muhindo/admin</code></li>\n";
echo "<li>Publish assets: <code>php artisan vendor:publish --provider=\"Muhindo\\Admin\\AdminServiceProvider\"</code></li>\n";
echo "<li>Clear cache: <code>php artisan config:clear && php artisan cache:clear</code></li>\n";
echo "<li>Check public/vendor/muhindo-admin/ directory for assets</li>\n";
echo "</ol>\n";
echo "</div>\n";

echo "<h2>📊 Summary Report</h2>\n";

echo "<h3 class='success'>✅ Working Components (" . count($successes) . ")</h3>\n";
foreach ($successes as $success) {
    echo "<div class='success'>• {$success}</div>\n";
}

echo "<h3 class='error'>❌ Issues Found (" . count($issues) . ")</h3>\n";
foreach ($issues as $issue) {
    echo "<div class='error'>• {$issue}</div>\n";
}

if (empty($issues)) {
    echo "<div class='success'><h3>🎉 All systems check passed!</h3></div>\n";
    echo "<div class='info'>Bootstrap 5 should be working. If you still don't see changes, try:\n";
    echo "<ul>\n";
    echo "<li>Clear browser cache (Ctrl+F5)</li>\n";
    echo "<li>Check browser developer tools for CSS conflicts</li>\n";
    echo "<li>Verify Laravel app cache is cleared</li>\n";
    echo "</ul></div>\n";
} else {
    echo "<div class='warning'><h3>⚠️  Issues need to be resolved first</h3></div>\n";
}

echo "<hr>\n";
echo "<small>Generated: " . date('Y-m-d H:i:s') . " | Muhindo Admin Bootstrap 5 Diagnostic Tool</small>\n";
