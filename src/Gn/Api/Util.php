<?php

namespace Gn\Api;

/**
 * Util
 */
class Util
{

    /**
     * @param string $value
     * @return string
     */
    public static function toCamelized($value)
    {
        return str_replace(' ','',ucwords(preg_replace('/[^A-Z^a-z^0-9]+/', ' ', $value)));
    }

    /**
     * @param string $value
     * @return string
     */
    public static function toUnderscore($value)
    {
        return  strtolower(preg_replace('/[^A-Z^a-z^0-9]+/', '_', preg_replace('/([a-zd])([A-Z])/', '\1_\2', preg_replace('/([A-Z]+)([A-Z][a-z])/', '\1_\2', $value))));
    }
}
