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

namespace Tuleap\OAuth2Server\User;

use Tuleap\DB\DataAccessObject;

class AuthorizationDao extends DataAccessObject
{
    public function create(\PFUser $user, int $app_id): int
    {
        return (int) $this->getDB()->insertReturnId(
            'plugin_oauth2_authorization',
            ['user_id' => $user->getID(), 'app_id' => $app_id]
        );
    }

    public function searchAuthorization(\PFUser $user, int $app_id): ?int
    {
        $sql = 'SELECT id FROM plugin_oauth2_authorization
                WHERE user_id = ? AND app_id = ?';
        return $this->getDB()->cell($sql, $user->getId(), $app_id) ?: null;
    }

    public function deleteAuthorizationByAppID(int $app_id): void
    {
        $this->getDB()->run(
            'DELETE plugin_oauth2_authorization.*, plugin_oauth2_authorization_scope.*
                       FROM plugin_oauth2_authorization
                       LEFT JOIN plugin_oauth2_authorization_scope ON plugin_oauth2_authorization.id = plugin_oauth2_authorization_scope.authorization_id
                       WHERE plugin_oauth2_authorization.app_id = ?',
            $app_id
        );
    }
}
