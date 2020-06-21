<?php declare(strict_types=1);

namespace KOA2\Service;

interface VerifierCodeProviderInterface
{
    public function getVerifierCode(string $challenge, string $method): string;
}
