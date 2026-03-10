<?php

namespace App\Queries\ward;

use Illuminate\Support\Facades\DB;

class RbacRouteQuery extends \App\Queries\Query
{
    /**
     * Lista das rotas com as respectivas atribuições a role
     */
    public static function getRoleRows(int $roleId): array {
        $sql = <<<SQL
            WITH cte_role_assigned AS (
                SELECT roro_rout AS assigned_route_id
                     , STRING_AGG(role_name, '; ') AS assigned_by
                  FROM admin.rbac_user_role
                     , admin.rbac_role_route
                     , admin.rbac_role
                 WHERE usro_user = :usro_user
                   AND roro_role = usro_role
                   AND role_code = roro_role
                 GROUP BY roro_rout
            ), cte_assigned AS (
                -- cte diferente para desconsiderar as atribuições pelo grupo nas atribuições manuais
                SELECT assigned_route_id, assigned_by FROM cte_role_assigned
                 UNION
                SELECT roro_rout AS assigned_route_id
                     , NULL AS assigned_by
                  FROM admin.rbac_role_route
                 WHERE roro_role = :roro_role
                   AND NOT EXISTS (SELECT * FROM cte_role_assigned WHERE assigned_route_id = roro_rout)
            )
            SELECT rout_code AS id
                 , rout_name AS name
                 , rout_path AS path
                 , rout_ctrl_path AS controller_path
                 , rout_ctrl_name AS controller_name
                 , assigned_route_id IS NOT NULL AS is_assigned
                 , assigned_by
              FROM admin.rbac_route
              LEFT OUTER JOIN cte_assigned
                ON assigned_route_id = rout_code
             ORDER BY rout_path
        SQL;
        return DB::select($sql, ['usro_user' => $roleId, 'roro_role' => $roleId]);
    }
}
