<?php

namespace App\Helpers;

class AuditHelper
{
    public static function filterSensitiveFields($array)
    {
        $fieldsToHide = ['password', 'remember_token'];
        if (!is_array($array)) {
            $array = json_decode($array, true);
        }
        if (!is_array($array)) return $array;

        foreach ($fieldsToHide as $field) {
            if (array_key_exists($field, $array)) {
                $array[$field] = '[OCULTO]';
            }
        }
        return $array;
    }
} 