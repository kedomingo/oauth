<?php declare(strict_types=1);
/**
 * @author    Kyle Domingo <kedomingo@gmail.com>
 */

namespace KOA2\Schema;


abstract class AbstractSchema
{

    abstract public static function getTablename(): string;

}
