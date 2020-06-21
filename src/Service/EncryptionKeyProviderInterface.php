<?php declare(strict_types=1);

namespace KOA2\Service;

interface EncryptionKeyProviderInterface
{
    public function getEncryptionKey() : string;
}
