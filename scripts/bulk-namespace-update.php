<?php
/**
 * Bulk Namespace Update Script
 * 
 * This script updates all Encore\Admin namespaces to Muhindo\Admin
 * throughout the legacy-muhindo-admin directory.
 */

$baseDir = realpath(__DIR__ . '/../legacy-muhindo-admin/src');

if (!$baseDir) {
    die("Source directory not found!\n");
}

echo "Starting bulk namespace update in: $baseDir\n";

// Find all PHP files
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($baseDir),
    RecursiveIteratorIterator::LEAVES_ONLY
);

$phpFiles = [];
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $phpFiles[] = $file->getPathname();
    }
}

$filesUpdated = 0;
$totalReplacements = 0;

echo "Found " . count($phpFiles) . " PHP files to process\n";

foreach ($phpFiles as $filePath) {
    $content = file_get_contents($filePath);
    $originalContent = $content;
    
    // Track replacements for this file
    $fileReplacements = 0;
    
    // 1. Update namespace declarations
    $content = preg_replace(
        '/^namespace Encore\\\\Admin(.*);$/m',
        'namespace Muhindo\\Admin$1;',
        $content,
        -1,
        $count
    );
    $fileReplacements += $count;
    
    // 2. Update use statements
    $content = preg_replace(
        '/^use Encore\\\\Admin(.*);$/m',
        'use Muhindo\\Admin$1;',
        $content,
        -1,
        $count
    );
    $fileReplacements += $count;
    
    // 3. Update class references in comments
    $content = preg_replace(
        '/@return\s+\\\\?Encore\\\\Admin([\w\\\\]*)/m',
        '@return \\Muhindo\\Admin$1',
        $content,
        -1,
        $count
    );
    $fileReplacements += $count;
    
    $content = preg_replace(
        '/@param\s+\\\\?Encore\\\\Admin([\w\\\\]*)/m',
        '@param \\Muhindo\\Admin$1',
        $content,
        -1,
        $count
    );
    $fileReplacements += $count;
    
    $content = preg_replace(
        '/@var\s+\\\\?Encore\\\\Admin([\w\\\\]*)/m',
        '@var \\Muhindo\\Admin$1',
        $content,
        -1,
        $count
    );
    $fileReplacements += $count;
    
    // 4. Update class references in code
    $content = preg_replace(
        '/\\\\Encore\\\\Admin([\w\\\\]*)/m',
        '\\Muhindo\\Admin$1',
        $content,
        -1,
        $count
    );
    $fileReplacements += $count;
    
    // Only write if changes were made
    if ($fileReplacements > 0) {
        file_put_contents($filePath, $content);
        $filesUpdated++;
        $totalReplacements += $fileReplacements;
        
        $relativePath = str_replace($baseDir . '/', '', $filePath);
        echo "✅ Updated $relativePath ($fileReplacements replacements)\n";
    }
}

echo "\n🎉 Bulk namespace update completed!\n";
echo "Files updated: $filesUpdated\n";
echo "Total replacements: $totalReplacements\n";

if ($totalReplacements > 0) {
    echo "\n✨ All Encore\\Admin namespaces have been updated to Muhindo\\Admin\n";
} else {
    echo "\n👍 No namespace updates needed - all files already use correct namespaces\n";
}
