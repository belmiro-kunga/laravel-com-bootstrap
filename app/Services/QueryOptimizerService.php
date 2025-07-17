<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QueryOptimizerService
{
    /**
     * Otimiza uma consulta Eloquent para melhorar a performance
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $options
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function optimize(Builder $query, array $options = [])
    {
        // Aplicar opções padrão
        $options = array_merge([
            'select' => true,      // Selecionar apenas colunas necessárias
            'index' => true,       // Forçar uso de índices
            'lock' => false,       // Usar bloqueio de tabela
            'timeout' => null,     // Timeout da consulta em segundos
            'log' => false,        // Registrar consulta no log
        ], $options);
        
        // Obter modelo e tabela
        $model = $query->getModel();
        $table = $model->getTable();
        
        // Selecionar apenas colunas necessárias se não houver select explícito
        if ($options['select'] && !$query->getQuery()->columns) {
            // Obter colunas essenciais do modelo
            $columns = self::getEssentialColumns($model);
            $query->select($columns);
        }
        
        // Forçar uso de índices quando aplicável
        if ($options['index']) {
            $primaryKey = $model->getKeyName();
            
            // Verificar se há ordenação e aplicar índice
            if ($query->getQuery()->orders) {
                foreach ($query->getQuery()->orders as $order) {
                    if (isset($order['column']) && !str_contains($order['column'], '.')) {
                        // Verificar se a coluna tem índice
                        if (self::columnHasIndex($table, $order['column'])) {
                            // Forçar uso do índice via SQL bruto
                            $query->from(DB::raw("`{$table}` USE INDEX (`{$order['column']}`)"));
                            break;
                        }
                    }
                }
            }
            // Forçar uso do índice primário para consultas por ID
            elseif ($query->getQuery()->wheres) {
                foreach ($query->getQuery()->wheres as $where) {
                    if (isset($where['column']) && $where['column'] === $primaryKey) {
                        $query->from(DB::raw("`{$table}` USE INDEX (PRIMARY)"));
                        break;
                    }
                }
            }
        }
        
        // Aplicar timeout da consulta
        if ($options['timeout']) {
            $query->timeout($options['timeout']);
        }
        
        // Aplicar bloqueio de tabela se necessário
        if ($options['lock']) {
            $query->lockForUpdate();
        }
        
        // Registrar consulta no log para debug
        if ($options['log']) {
            $query->beforeQuery(function ($query) {
                $sql = $query->toSql();
                $bindings = $query->getBindings();
                
                // Substituir placeholders pelos valores
                foreach ($bindings as $binding) {
                    $value = is_numeric($binding) ? $binding : "'{$binding}'";
                    $sql = preg_replace('/\?/', $value, $sql, 1);
                }
                
                Log::channel('queries')->info('SQL Query: ' . $sql);
            });
        }
        
        return $query;
    }
    
    /**
     * Obter colunas essenciais do modelo
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return array
     */
    protected static function getEssentialColumns($model)
    {
        $table = $model->getTable();
        $primaryKey = $model->getKeyName();
        $columns = [$table . '.' . $primaryKey];
        
        // Adicionar colunas fillable
        if (property_exists($model, 'fillable') && !empty($model->getFillable())) {
            foreach ($model->getFillable() as $column) {
                $columns[] = $table . '.' . $column;
            }
        } else {
            // Se não houver fillable, selecionar todas as colunas
            $columns = [$table . '.*'];
        }
        
        // Adicionar timestamps se o modelo os utiliza
        if ($model->usesTimestamps()) {
            $columns[] = $table . '.' . $model->getCreatedAtColumn();
            $columns[] = $table . '.' . $model->getUpdatedAtColumn();
        }
        
        // Adicionar coluna de soft delete se o modelo a utiliza
        if (method_exists($model, 'getDeletedAtColumn')) {
            $columns[] = $table . '.' . $model->getDeletedAtColumn();
        }
        
        return $columns;
    }
    
    /**
     * Verificar se uma coluna tem índice
     *
     * @param string $table
     * @param string $column
     * @return bool
     */
    protected static function columnHasIndex($table, $column)
    {
        try {
            $indexes = DB::select("SHOW INDEX FROM `{$table}` WHERE Column_name = '{$column}'");
            return !empty($indexes);
        } catch (\Exception $e) {
            return false;
        }
    }
}