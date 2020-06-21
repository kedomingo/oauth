<?php declare(strict_types=1);

namespace KOA2\Service;

use Illuminate\Support\Str;

class EncryptionKeyProvider implements EncryptionKeyProviderInterface
{
    /**
     * @return string
     */
    public function getEncryptionKey(): string
    {
        return $this->parseAppKey(config('app.key'));
    }

    /**
     * @param $key
     *
     * @return false|string
     */
    private function parseAppKey($key)
    {
        if (Str::startsWith($key, $prefix = 'base64:')) {
            $key = base64_decode(Str::after($key, $prefix));
        }

        return $key;
    }

}
