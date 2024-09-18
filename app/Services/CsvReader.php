<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;

/**
 * Read csv file into laravel collection
 */
class CsvReader
{
    public static function read($file, $hasColumnsTitle = true, $delimiter = ',', $enclosure = '"', $keysToLower = true, ?int $limit = null): Collection
    {
        $result = collect();
        $table = fopen($file, 'r');
        if ($hasColumnsTitle) {
            $columns = fgetcsv($table, null, $delimiter);
        }
        $counter = 0;
        while (($row = fgetcsv($table, null, $delimiter, $enclosure)) !== false) {
            if ($limit && $counter >= $limit) {
                break;
            }

            if ($hasColumnsTitle) {
                $row = self::addRowKeys($row, $columns, $keysToLower);
            }

            $result->push($row);
            $counter++;
        }
        fclose($table);

        return $result;
    }

    public static function map($file, callable $callback, $hasColumnsTitle = true, $delimiter = ',', $enclosure = '"', $keysToLower = true, ?int $limit = null): void
    {
        $table = fopen($file, 'r');
        if ($hasColumnsTitle) {
            $columns = fgetcsv($table, null, $delimiter);
        }
        $counter = 0;
        while (($row = fgetcsv($table, null, $delimiter, $enclosure)) !== false) {
            if ($limit && $counter >= $limit) {
                break;
            }

            if ($hasColumnsTitle) {
                $row = self::addRowKeys($row, $columns, $keysToLower);
            }
            $callback($row, $counter);

            $counter++;
        }
        fclose($table);
    }

    public static function readLazy($file, $hasColumnsTitle = true, $delimiter = ',', $enclosure = '"', $keysToLower = true): LazyCollection
    {
        return LazyCollection::make(function () use ($enclosure, $delimiter, $keysToLower, $file, $hasColumnsTitle) {
            $table = fopen($file, 'r');
            if ($hasColumnsTitle) {
                $columns = fgetcsv($table, null, $delimiter);
            }

            while (($row = fgetcsv($table, null, $delimiter, $enclosure)) !== false) {
                if ($hasColumnsTitle) {
                    $row = self::addRowKeys($row, $columns, $keysToLower);
                }

                yield $row;
            }
        });
    }

    protected static function addRowKeys(array $row, array $columns, $keysToLower): array
    {
        $result = [];
        foreach ($columns as $index => $column) {
            if (!array_key_exists($index, $row)) {
                dd($row);
            }
            if ($keysToLower) {
                $column = strtolower($column);
            }
            $result[$column] = $row[$index] === '' ? null : $row[$index];
        }

        return $result;
    }

    public static function getRowsCount(string $file): int
    {
        $c = 0;
        $fp = fopen($file, 'r');
        if ($fp) {
            while (!feof($fp)) {
                $content = fgets($fp);
                if ($content) {
                    $c++;
                }
            }
        }
        fclose($fp);

        return $c;
    }
}
