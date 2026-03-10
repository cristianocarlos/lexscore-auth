<?php

namespace App\Queries\ward;

use Illuminate\Support\Facades\DB;

class RbacRoleQuery extends \App\Queries\Query
{
    /**
     * Lista das roles-grupo com as respectivas atribuições ao user
     */
    public static function getGroupRoleRows(int $userId): array {
        $sql = <<<SQL
            SELECT role_code AS id
                 , role_name AS name
                 , role_desc AS description
                 , usro_user IS NOT NULL AS is_assigned
              FROM admin.rbac_role
              LEFT OUTER JOIN admin.rbac_user_role
                ON usro_role = role_code
               AND usro_user = :usro_user
             WHERE role_user IS NULL
             ORDER BY F_CI(role_name)
        SQL;
        return DB::select($sql, ['usro_user' => $userId]);
    }
}
