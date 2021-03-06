<?php
/**
 * Copyright (c) Enalean, 2020-Present. All Rights Reserved.
 *
 * This file is a part of Tuleap.
 *
 * Tuleap is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Tuleap is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tuleap. If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace Tuleap\OAuth2Server\Grant\AuthorizationCode;

use ParagonIE\EasyDB\EasyStatement;
use Tuleap\DB\DataAccessObject;

class OAuth2AuthorizationCodeDAO extends DataAccessObject
{
    public function create(int $app_id, int $user_id, string $hashed_verification_string, int $expiration_date_timestamp): int
    {
        return (int) $this->getDB()->insertReturnId(
            'plugin_oauth2_authorization_code',
            [
                'app_id'                => $app_id,
                'user_id'               => $user_id,
                'verifier'              => $hashed_verification_string,
                'expiration_date'       => $expiration_date_timestamp,
                'has_already_been_used' => false
            ]
        );
    }

    /**
     * @psalm-return null|array{verifier:string,user_id:int,expiration_date:int,has_already_been_used:0|1}
     */
    public function searchAuthorizationCode(int $authorization_code_id): ?array
    {
        return $this->getDB()->row(
            'SELECT plugin_oauth2_authorization_code.verifier, user_id, expiration_date, has_already_been_used
                       FROM plugin_oauth2_authorization_code
                       JOIN plugin_oauth2_server_app ON plugin_oauth2_authorization_code.app_id = plugin_oauth2_server_app.id
                       JOIN `groups` ON plugin_oauth2_server_app.project_id = `groups`.group_id
                       WHERE plugin_oauth2_authorization_code.id = ? AND `groups`.status = "A"',
            $authorization_code_id
        );
    }

    public function markAuthorizationCodeAsUsed(int $authorization_code_id): void
    {
        $this->getDB()->run(
            'UPDATE plugin_oauth2_authorization_code SET has_already_been_used=TRUE WHERE id=?',
            $authorization_code_id
        );
    }

    public function deleteAuthorizationCodeByAppID(int $app_id): void
    {
        $this->deleteAuthorizationCode(
            EasyStatement::open()->with('plugin_oauth2_authorization_code.app_id = ?', $app_id)
        );
    }

    public function deleteAuthorizationCodeByID(int $authorization_code_id): void
    {
        $this->deleteAuthorizationCode(
            EasyStatement::open()->with('plugin_oauth2_authorization_code.id = ?', $authorization_code_id)
        );
    }

    private function deleteAuthorizationCode(EasyStatement $filter_statement): void
    {
        $this->getDB()->safeQuery(
            "DELETE plugin_oauth2_authorization_code.*, plugin_oauth2_authorization_code_scope.*, plugin_oauth2_access_token.*, plugin_oauth2_access_token_scope.*
                       FROM plugin_oauth2_authorization_code
                       LEFT JOIN plugin_oauth2_authorization_code_scope ON plugin_oauth2_authorization_code.id = plugin_oauth2_authorization_code_scope.auth_code_id
                       LEFT JOIN plugin_oauth2_access_token ON plugin_oauth2_authorization_code.id = plugin_oauth2_access_token.authorization_code_id
                       LEFT JOIN plugin_oauth2_access_token_scope on plugin_oauth2_access_token.id = plugin_oauth2_access_token_scope.access_token_id
                       WHERE $filter_statement",
            $filter_statement->values()
        );
    }
}
