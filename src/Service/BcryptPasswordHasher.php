<?php declare(strict_types=1);

namespace KOA2\Service;

use KOA2\Service\Contract\PasswordHasherInterface;
use RuntimeException;

final class BcryptPasswordHasher implements PasswordHasherInterface
{
    /**
     * The default cost factor.
     *
     * @var int
     */
    protected $rounds = 10;

    /**
     * Indicates whether to perform an algorithm check.
     *
     * @var bool
     */
    protected $verifyAlgorithm = false;

    /**
     * Create a new hasher instance.
     *
     * @param array $options
     * @return void
     */
    public function __construct(array $options = [])
    {
        $this->rounds = $options['rounds'] ?? $this->rounds;
        $this->verifyAlgorithm = $options['verify'] ?? $this->verifyAlgorithm;
    }

    /**
     * Hash the given value.
     *
     * @param string $value
     * @param array  $options
     * @return string
     *
     * @throws RuntimeException
     */
    public function make(string $value, array $options = []): string
    {
        $hash = password_hash(
            $value,
            PASSWORD_BCRYPT,
            [
                'cost' => $this->cost($options),
            ]
        );

        if ($hash === false) {
            throw new RuntimeException('Bcrypt hashing not supported.');
        }

        return $hash;
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param string $value
     * @param string $hashedValue
     * @param array  $options
     * @return bool
     *
     * @throws RuntimeException
     */
    public function check(string $value, string $hashedValue, array $options = []): bool
    {
        if (strlen($hashedValue) === 0) {
            return false;
        }

        return password_verify($value, $hashedValue);
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param string $hashedValue
     * @param array  $options
     * @return bool
     */
    public function needsRehash(string $hashedValue, array $options = []): bool
    {
        return password_needs_rehash(
            $hashedValue,
            PASSWORD_BCRYPT,
            [
                'cost' => $this->cost($options),
            ]
        );
    }

    /**
     * Set the default password work factor.
     *
     * @param int $rounds
     * @return $this
     */
    public function setRounds($rounds): self
    {
        $this->rounds = (int)$rounds;

        return $this;
    }

    /**
     * Extract the cost value from the options array.
     *
     * @param array $options
     * @return int
     */
    protected function cost(array $options = []): int
    {
        return $options['rounds'] ?? $this->rounds;
    }
}