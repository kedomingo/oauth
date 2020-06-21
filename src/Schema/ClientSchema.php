<?php

namespace KOA2\Schema;

class ClientSchema extends AbstractSchema {
  private const TABLE_NAME          = 'oauth_clients';
  private const FIELD_CLIENT_ID     = 'client_id';
  private const FIELD_CLIENT_SECRET = 'client_secret';

  public static function getTableName() : string {
    return self::TABLE_NAME;
  }

  public static function clientId() : string {
    return self::FIELD_CLIENT_ID;
  }

  public static function clientSecret() : string {
    return self::FIELD_CLIENT_SECRET;
  }
}