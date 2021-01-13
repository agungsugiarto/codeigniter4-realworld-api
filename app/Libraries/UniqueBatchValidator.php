<?php

namespace App\Libraries;

use Config\Database;

class UniqueBatchValidator
{
    /**
     * Check the database to see if the given value is unique. can ignore a single
     * record by field or valaue to make it usefull during record updates.
     *
     * @param array $str
     * @param array $data
     */
    public function unique(array $str, string $field, array $data): bool
    {
        // Grab any data for exclusion of a single row.
        [$field, $ignoreField, $ignoreValue] = array_pad(explode(',', $field), 3, null);

        // Break the table and field apart
        sscanf($field, '%[^.].%[^.]', $table, $field);

        $db = Database::connect($data['DBGroup'] ?? null);

        $rows = $db->table($table)->select('1')->whereIn($field, $str);

        if (! empty($ignoreField) && ! empty($ignoreValue)) {
            if (! preg_match('/^\{(\w+)\}$/', $ignoreValue)) {
                foreach (explode('.', $ignoreValue) as $value) {
                    $rows = $rows->where("{$ignoreField} !=", $value);
                }
            }
        }

        return $rows->countAllResults() === 0;
    }
}
