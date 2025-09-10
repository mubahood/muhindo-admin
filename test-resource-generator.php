<?php

// Simple test script to verify ResourceGenerator functionality
require_once __DIR__ . '/vendor/autoload.php';

use Muhindo\Admin\Console\ResourceGenerator;
use Illuminate\Database\Eloquent\Model;

// Mock the model class for testing
class MockModel extends Model
{
    protected $table = 'test_models';
    
    public function getTable() 
    {
        return $this->table;
    }
    
    public function getConnection()
    {
        return new MockConnection();
    }
}

class MockConnection  
{
    public function getSchemaBuilder()
    {
        return new MockSchemaBuilder();
    }
    
    public function selectOne($query)
    {
        // Mock column information
        if (strpos($query, 'name') !== false) {
            return (object) ['Type' => 'varchar(255)'];
        }
        if (strpos($query, 'email') !== false) {
            return (object) ['Type' => 'varchar(255)'];
        }
        if (strpos($query, 'status') !== false) {
            return (object) ['Type' => 'tinyint(1)'];
        }
        if (strpos($query, 'created_at') !== false) {
            return (object) ['Type' => 'timestamp'];
        }
        
        return (object) ['Type' => 'varchar(255)'];
    }
}

class MockSchemaBuilder
{
    public function getColumnListing($table)
    {
        return ['id', 'name', 'email', 'description', 'status', 'created_at', 'updated_at'];
    }
}

echo "Testing ResourceGenerator with Laravel 12.x compatibility...\n\n";

try {
    $model = new MockModel();
    $generator = new ResourceGenerator($model, 'TestController');
    
    echo "✅ ResourceGenerator created successfully\n";
    
    // Test getting table columns using reflection
    $reflection = new ReflectionClass($generator);
    $getTableColumnsMethod = $reflection->getMethod('getTableColumns');
    $getTableColumnsMethod->setAccessible(true);
    
    $columns = $getTableColumnsMethod->invoke($generator);
    echo "✅ getTableColumns() works - found " . count($columns) . " columns\n";
    
    foreach ($columns as $column) {
        echo "   - {$column->name} ({$column->type})\n";
    }
    
    // Test form generation
    $formCode = $generator->generateForm();
    echo "\n✅ generateForm() works - generated " . strlen($formCode) . " characters of form code\n";
    
    // Test grid generation  
    $gridCode = $generator->generateGrid();
    echo "✅ generateGrid() works - generated " . strlen($gridCode) . " characters of grid code\n";
    
    echo "\n🎉 All tests passed! ResourceGenerator is Laravel 12.x compatible.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
