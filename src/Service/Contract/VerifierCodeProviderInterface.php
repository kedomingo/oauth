<?php declare(strict_types=1);

namespace KOA2\Service\Contract;

interface VerifierCodeProviderInterface
{
    public function getVerifierCode(string $challenge, string $method): string;
}
