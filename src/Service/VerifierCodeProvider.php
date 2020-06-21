<?php declare(strict_types=1);

namespace KOA2\Service;

class VerifierCodeProvider implements VerifierCodeProviderInterface
{
    private const HASH_METHOD_PLAIN = 'plain';
    private const HASH_METHOD_SHA256 = 'sha256';

    /**
     * @param string $challenge
     * @param string $method
     *
     * @return string
     */
    public function getVerifierCode(string $challenge, string $method): string
    {
        switch ($method) {
            case self::HASH_METHOD_PLAIN:
                return $challenge;

            case self::HASH_METHOD_SHA256:
                return rtrim(base64_encode(urlencode(hash(self::HASH_METHOD_SHA256, $challenge))), '=');
        }

        return '';
    }
}
