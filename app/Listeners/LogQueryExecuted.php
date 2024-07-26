<?php

namespace App\Listeners;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Log;

class LogQueryExecuted
{
    public function handle(QueryExecuted $event)
    {
        $sql = $event->sql;
        $bindings = $event->bindings;
        $time = $event->time;

        // Заменяем знаки "?" на значения параметров запроса
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'{$binding}'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }

        // Записываем полный текст запроса и время выполнения в лог
        Log::channel('mysql_queries')->debug("Query: {$sql} | Execution Time: {$time}ms");
    }
}