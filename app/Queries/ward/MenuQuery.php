<?php

namespace App\Queries\ward;

use Illuminate\Support\Facades\DB;

class MenuQuery extends \App\Queries\Query
{
    public static function getTree(): array {
        return static::recursiveTreeGenerate(null);
    }

    private static function recursiveTreeGenerate(?int $parentItemId, array &$tree = []): array {
        $rows = static::recursiveTreeRows($parentItemId);
        if (count($rows) > 0) {
            $i = 0;
            foreach ($rows as $reg) {
                $tree['items'][$i] = [
                    'id' => $reg->menu_code,
                    'name' => $reg->menu_name,
                    'shortcut_icon_name' => $reg->shortcut_icon_name,
                    'shortcut_name' => $reg->shortcut_name,
                    'url_path' => $reg->url_path,
                    'sortable_parent_id' => $parentItemId,
                ];
                static::recursiveTreeGenerate($reg->menu_code, $tree['items'][$i]);
                $i++;
            }
        }
        return $tree;
    }

    private static function recursiveTreeRows(?int $parentItemId = null): array {
        $filters = [];
        $bindings = [];
        if ($parentItemId === null) {
            $filters[] = 'menu_menu IS NULL';
        } else {
            $filters[] = 'menu_menu = :menu_menu';
            $bindings['menu_menu'] = $parentItemId;
        }
        $sql = <<<SQL
          SELECT menu_code
               , menu_name
               , menu_shcu_data->>'icon_name' AS shortcut_icon_name
               , menu_shcu_data->>'name' AS shortcut_name
               , menu_rout AS url_path
            FROM admin.menu
            LEFT OUTER
            JOIN admin.rbac_route
              ON rout_code = menu_rout
        SQL;
        $sql .= parent::resolveAdditionalSql(
            filters: $filters,
            orderBy: ' menu_orde, F_CI(menu_name)',
            filterPrefix: 'WHERE',
        );
        return DB::select($sql, $bindings);
    }
}
