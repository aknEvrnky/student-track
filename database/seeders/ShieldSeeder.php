<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_book","view_any_book","create_book","update_book","restore_book","restore_any_book","replicate_book","reorder_book","delete_book","delete_any_book","force_delete_book","force_delete_any_book","view_course","view_any_course","create_course","update_course","restore_course","restore_any_course","replicate_course","reorder_course","delete_course","delete_any_course","force_delete_course","force_delete_any_course","view_course::type","view_any_course::type","create_course::type","update_course::type","restore_course::type","restore_any_course::type","replicate_course::type","reorder_course::type","delete_course::type","delete_any_course::type","force_delete_course::type","force_delete_any_course::type","view_exam","view_any_exam","create_exam","update_exam","restore_exam","restore_any_exam","replicate_exam","reorder_exam","delete_exam","delete_any_exam","force_delete_exam","force_delete_any_exam","view_publisher","view_any_publisher","create_publisher","update_publisher","restore_publisher","restore_any_publisher","replicate_publisher","reorder_publisher","delete_publisher","delete_any_publisher","force_delete_publisher","force_delete_any_publisher","view_subject","view_any_subject","create_subject","update_subject","restore_subject","restore_any_subject","replicate_subject","reorder_subject","delete_subject","delete_any_subject","force_delete_subject","force_delete_any_subject","view_activity","view_any_activity","create_activity","update_activity","restore_activity","restore_any_activity","replicate_activity","reorder_activity","delete_activity","delete_any_activity","force_delete_activity","force_delete_any_activity","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_solved::question::record","view_any_solved::question::record","create_solved::question::record","update_solved::question::record","restore_solved::question::record","restore_any_solved::question::record","replicate_solved::question::record","reorder_solved::question::record","delete_solved::question::record","delete_any_solved::question::record","force_delete_solved::question::record","force_delete_any_solved::question::record","view_student","view_any_student","create_student","update_student","restore_student","restore_any_student","replicate_student","reorder_student","delete_student","delete_any_student","force_delete_student","force_delete_any_student"]},{"name":"student","guard_name":"web","permissions":["view_book","view_any_book","create_book","update_book","restore_book","restore_any_book","replicate_book","reorder_book","delete_book","delete_any_book","force_delete_book","force_delete_any_book","view_course","view_any_course","create_course","update_course","restore_course","restore_any_course","replicate_course","reorder_course","delete_course","delete_any_course","force_delete_course","force_delete_any_course","view_publisher","view_any_publisher","create_publisher","update_publisher","restore_publisher","restore_any_publisher","replicate_publisher","reorder_publisher","delete_publisher","delete_any_publisher","force_delete_publisher","force_delete_any_publisher","view_subject","view_any_subject","create_subject","update_subject","restore_subject","restore_any_subject","replicate_subject","reorder_subject","delete_subject","delete_any_subject","force_delete_subject","force_delete_any_subject","view_solved::question::record","view_any_solved::question::record","create_solved::question::record","update_solved::question::record","restore_solved::question::record","restore_any_solved::question::record","replicate_solved::question::record","reorder_solved::question::record","delete_solved::question::record","delete_any_solved::question::record","force_delete_solved::question::record","force_delete_any_solved::question::record"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
