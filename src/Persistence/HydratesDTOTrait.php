<?php declare(strict_types=1);
/**
 * @author    Kyle Domingo <kedomingo@gmail.com>
 */

namespace KOA2\Persistence;

use KOA2\Exceptions\DTOHydrationException;
use ReflectionClass;
use ReflectionException;

trait HydratesDTOTrait {

    /**
     * @param string $hydratableClass
     *
     * @param object $data
     *
     * @return object
     * @throws DTOHydrationException
     */
    public function hydrateOne(string $hydratableClass, object $data) {
        return $this->hydrate($hydratableClass, $data);
    }

    /**
     * Warning when using this method, validate that $datas is actually an array
     *
     * @param string $hydratableClass
     *
     * @param object ...$datas
     *
     * @return array
     * @throws DTOHydrationException
     */
    public function hydrateMany(string $hydratableClass, ?object ...$datas) {
        $result = [];
        foreach ($datas as $data) {
            $result[] = $this->hydrate($hydratableClass, $data);
        }

        return $result;
    }

    /**
     * @param string $hydratableClass
     *
     * @param object $data
     *
     * @return object
     * @throws DTOHydrationException
     */
    private function hydrate(string $hydratableClass, object $data) {
        try {
            $reflection = new ReflectionClass($hydratableClass);
        } catch (ReflectionException $e) {
            throw new DTOHydrationException($e->getMessage(), $e->getCode(), $e);
        }
        $instance   = $reflection->newInstanceWithoutConstructor();
        $properties = $reflection->getProperties();
        $dataArray  = $this->objDataToArray($data);

        foreach ($properties as $property) {
            if (array_key_exists($property->getName(), $dataArray)) {
                $property->setAccessible(true);
                $property->setValue($instance, $dataArray[$property->getName()]);
                $property->setAccessible(false);
            }
        }
        is_callable([$instance, '__construct']) && $instance->__construct();

        return $instance;
    }

    /**
     * @param object $data
     *
     * @return array
     */
    private function objDataToArray(object $data) : array {
        $result = [];
        foreach (get_object_vars($data) as $k => $v) {
            $result[$this->snakeToCamelCase($k)] = $v;
        }

        return $result;
    }

    /**
     * Convert snake case to camel case
     *
     * @param string $str
     *
     * @return string
     */
    private function snakeToCamelCase(string $str) : string {
        if (strpos($str, '_') === false) {
            return $str;
        }

        return str_replace(' ', '', lcfirst(ucwords(strtolower(str_replace('_', ' ', $str)))));
    }
}
