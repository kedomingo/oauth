<?php

namespace KOA2\Schema;

class RefreshTokenSchema extends AbstractSchema
{
    private const TABLE_NAME = 'oauth_refresh_tokens';
    private const FIELD_TOKEN_ID = 'id';
    private const FIELD_ACCESS_TOKEN_ID = 'access_token_id';
    private const FIELD_EXPIRES_AT = 'expires_at';

    public static function getTableName(): string
    {
        return self::TABLE_NAME;
    }

    public static function tokenId(): string
    {
        return self::FIELD_TOKEN_ID;
    }

    public static function accessTokenId(): string
    {
        return self::FIELD_ACCESS_TOKEN_ID;
    }

    public static function expiresAt(): string
    {
        return self::FIELD_EXPIRES_AT;
    }
}