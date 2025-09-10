<?php

namespace Muhindo\Admin\Console;

use Illuminate\Database\Eloquent\Model;

class ResourceGenerator
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var array
     */
    protected $formats = [
        'form_field'  => "\$form->%s('%s', __('%s'))",
        'show_field'  => "\$show->field('%s', __('%s'))",
        'grid_column' => "\$grid->column('%s', __('%s'))",
    ];

    /**
     * @var array
     */
    private $doctrineTypeMapping = [
        'string' => [
            'enum', 'geometry', 'geometrycollection', 'linestring',
            'polygon', 'multilinestring', 'multipoint', 'multipolygon',
            'point',
        ],
    ];

    /**
     * @var array
     */
    protected $fieldTypeMapping = [
        'ip'       => 'ip',
        'email'    => 'email|mail',
        'password' => 'password|pwd',
        'url'      => 'url|link|src|href',
        'mobile'   => 'mobile|phone',
        'color'    => 'color|rgb',
        'image'    => 'image|img|avatar|pic|picture|cover',
        'file'     => 'file|attachment',
    ];

    /**
     * ResourceGenerator constructor.
     *
     * @param mixed $model
     */
    public function __construct($model)
    {
        $this->model = $this->getModel($model);
    }

    /**
     * @param mixed $model
     *
     * @return mixed
     */
    protected function getModel($model)
    {
        if ($model instanceof Model) {
            return $model;
        }

        if (!is_string($model) || !class_exists($model) || !is_subclass_of($model, Model::class)) {
            throw new \InvalidArgumentException("Invalid model [$model] !");
        }

        return new $model();
    }

    /**
     * @return string
     */
    public function generateForm()
    {
        $reservedColumns = $this->getReservedColumns();

        $output = '';

        foreach ($this->getTableColumns() as $column) {
            $name = $column->name; // Updated for new object structure
            if (in_array($name, $reservedColumns)) {
                continue;
            }
            $type = $column->type; // Updated for new object structure
            $default = ''; // Simplified since we don't have detailed column info

            $defaultValue = '';

            // set column fieldType and defaultValue
            switch ($type) {
                case 'boolean':
                case 'bool':
                    $fieldType = 'switch';
                    break;
                case 'json':
                case 'array':
                case 'object':
                    $fieldType = 'text';
                    break;
                case 'string':
                    $fieldType = 'text';
                    foreach ($this->fieldTypeMapping as $type => $regex) {
                        if (preg_match("/^($regex)$/i", $name) !== 0) {
                            $fieldType = $type;
                            break;
                        }
                    }
                    $defaultValue = "'{$default}'";
                    break;
                case 'integer':
                case 'bigint':
                case 'smallint':
                case 'timestamp':
                    $fieldType = 'number';
                    break;
                case 'decimal':
                case 'float':
                case 'real':
                    $fieldType = 'decimal';
                    break;
                case 'datetime':
                    $fieldType = 'datetime';
                    $defaultValue = "date('Y-m-d H:i:s')";
                    break;
                case 'date':
                    $fieldType = 'date';
                    $defaultValue = "date('Y-m-d')";
                    break;
                case 'time':
                    $fieldType = 'time';
                    $defaultValue = "date('H:i:s')";
                    break;
                case 'text':
                case 'blob':
                    $fieldType = 'textarea';
                    break;
                default:
                    $fieldType = 'text';
                    $defaultValue = "'{$default}'";
            }

            $defaultValue = $defaultValue ?: $default;

            $label = $this->formatLabel($name);

            $output .= sprintf($this->formats['form_field'], $fieldType, $name, $label);

            if (trim($defaultValue, "'\"")) {
                $output .= "->default({$defaultValue})";
            }

            $output .= ";\r\n";
        }

        return $output;
    }

    public function generateShow()
    {
        $output = '';

        foreach ($this->getTableColumns() as $column) {
            $name = $column->name; // Updated for new object structure

            // set column label
            $label = $this->formatLabel($name);

            $output .= sprintf($this->formats['show_field'], $name, $label);

            $output .= ";\r\n";
        }

        return $output;
    }

    public function generateGrid()
    {
        $output = '';

        foreach ($this->getTableColumns() as $column) {
            $name = $column->name; // Updated for new object structure
            $label = $this->formatLabel($name);

            $output .= sprintf($this->formats['grid_column'], $name, $label);
            $output .= ";\r\n";
        }

        return $output;
    }

    protected function getReservedColumns()
    {
        return [
            $this->model->getKeyName(),
            $this->model->getCreatedAtColumn(),
            $this->model->getUpdatedAtColumn(),
            'deleted_at',
        ];
    }

    /**
     * Get columns of a giving model using Laravel 12.x schema builder.
     *
     * @throws \Exception
     *
     * @return array
     */
    protected function getTableColumns()
    {
        try {
            $tableName = $this->model->getTable();
            $connection = $this->model->getConnection();
            
            // Use Laravel's schema builder instead of Doctrine DBAL
            $columns = $connection->getSchemaBuilder()->getColumnListing($tableName);
            
            // Convert to objects with name and type information
            $columnObjects = [];
            foreach ($columns as $columnName) {
                $columnObjects[] = (object) [
                    'name' => $columnName,
                    'type' => $this->getColumnType($connection, $tableName, $columnName)
                ];
            }
            
            return $columnObjects;
            
        } catch (\Exception $e) {
            // Fallback to basic columns if schema inspection fails
            return [
                (object) ['name' => 'id', 'type' => 'integer'],
                (object) ['name' => 'name', 'type' => 'string'],
                (object) ['name' => 'created_at', 'type' => 'datetime'],
                (object) ['name' => 'updated_at', 'type' => 'datetime'],
            ];
        }
    }
    
    /**
     * Get column type using Laravel's schema builder
     */
    protected function getColumnType($connection, $tableName, $columnName)
    {
        try {
            // Use raw SQL to get column information
            $query = "SHOW COLUMNS FROM `{$tableName}` LIKE '{$columnName}'";
            $column = $connection->selectOne($query);
            
            if ($column) {
                $type = $column->Type ?? 'string';
                
                // Map MySQL types to simplified types
                if (strpos($type, 'int') !== false) return 'integer';
                if (strpos($type, 'varchar') !== false || strpos($type, 'text') !== false) return 'string';
                if (strpos($type, 'timestamp') !== false || strpos($type, 'datetime') !== false) return 'datetime';
                if (strpos($type, 'date') !== false) return 'date';
                if (strpos($type, 'decimal') !== false || strpos($type, 'float') !== false) return 'decimal';
                if (strpos($type, 'tinyint(1)') !== false) return 'boolean';
            }
            
            return 'string'; // default fallback
        } catch (\Exception $e) {
            return 'string'; // safe fallback
        }
    }

    /**
     * Format label.
     *
     * @param string $value
     *
     * @return string
     */
    protected function formatLabel($value)
    {
        return ucfirst(str_replace(['-', '_'], ' ', $value));
    }
}
