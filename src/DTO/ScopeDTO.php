<?php declare(strict_types=1);

namespace KOA2\DTO;

class ScopeDTO
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return (int)$this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $json
     * @return static|null
     */
    public static function fromJson(string $json): ?self
    {
        $instance = null;
        $decoded = json_decode($json, true);

        if (isset($decoded['id'], $decoded['name'])) {
            $instance = new self();
            $instance->id = $decoded['id'];
            $instance->name = $decoded['name'];
        }

        return $instance;
    }
}