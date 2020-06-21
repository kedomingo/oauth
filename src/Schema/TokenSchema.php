<?php

namespace KOA2\Schema;

class TokenSchema extends AbstractSchema
{
    private const TABLE_NAME = 'oauth_access_tokens';
    private const FIELD_TOKEN_ID = 'id';
    private const FIELD_USER_ID = 'user_id';
    private const FIELD_CLIENT_ID = 'client_id';
    private const FIELD_SCOPES = 'scopes';
    private const FIELD_EXPIRES_AT = 'expires_at';

    public static function getTableName(): string
    {
        return self::TABLE_NAME;
    }

    public static function tokenId(): string
    {
        return self::FIELD_TOKEN_ID;
    }

    public static function clientId(): string
    {
        return self::FIELD_CLIENT_ID;
    }

    public static function userId(): string
    {
        return self::FIELD_USER_ID;
    }

    public static function scopes(): string
    {
        return self::FIELD_SCOPES;
    }

    public static function expiresAt(): string
    {
        return self::FIELD_EXPIRES_AT;
    }
}