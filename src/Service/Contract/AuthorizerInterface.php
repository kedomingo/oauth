<?php declare(strict_types=1);

namespace KOA2\Service\Contract;

use League\OAuth2\Server\RequestTypes\AuthorizationRequest;
use Psr\Http\Message\ResponseInterface;

interface AuthorizerInterface
{
    public function getAuthRequest(): AuthorizationRequest;

    public function complete(AuthorizationRequest $authRequest): ResponseInterface;
}
