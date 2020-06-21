<?php declare(strict_types=1);
/**
 * @author    Kyle Domingo <kedomingo@gmail.com>
 */

namespace KOA2\Schema;

final class Type {

    // Numeric types
    public const TYPE_ID               = 'id';
    public const TYPE_UNSIGNED_DECIMAL = 'unsignedDecimal';
    public const TYPE_DECIMAL          = 'decimal';
    public const TYPE_UNSIGNED_INTEGER = 'unsignedInteger';
    public const TYPE_INTEGER          = 'integer';

    // Date types
    public const TYPE_DATE      = 'date';
    public const TYPE_TIME      = 'time';
    public const TYPE_DATETIME  = 'dateTime';
    public const TYPE_TIMESTAMP = 'timestamp';

    // Text types
    public const TYPE_JSON        = 'json';
    public const TYPE_TEXT        = 'text';
    public const TYPE_MEDIUM_TEXT = 'mediumText';
    public const TYPE_LONG_TEXT   = 'longText';
    public const TYPE_STRING      = 'string';

    // Misc
    public const TYPE_ENUM    = 'enum';
    public const TYPE_BOOLEAN = 'boolean';

}
