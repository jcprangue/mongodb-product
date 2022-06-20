<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                "name" => "Admin",
                "slug" => "admin",
                "description" => "Administrator Access"
            ],
            [
                "name" => "Guest",
                "slug" => "guest",
                "description" => "Guest Access"
            ]


        ];

        $permissions = [
            [
                "name" => "View Dashboard",
                "slug" => "view-dashboard",
                "description" => "Permission to view dashboard"
            ],
            [

                "name" => "View Procurement",
                "slug" => "view-procurement",
                "description" => "Permission to view procurement"
            ],
            [
                "name" => "Create Procurement",
                "slug" => "procurement-create",
                "description" => "Permission to create procurement"
            ],
            [
                "name" => "Update Procurement",
                "slug" => "procurement-update",
                "description" => "Permission to update procurement"
            ],
            [
                "name" => "Delete Procurement",
                "slug" => "procurement-delete",
                "description" => "Permission to delete procurement"
            ],
            [

                "name" => "View Procurement Details",
                "slug" => "view-procurement-details",
                "description" => "Permission to view details"
            ],
            [
                "name" => "Create Procurement Details",
                "slug" => "procurement-details-create",
                "description" => "Permission to create procurement details"
            ],
            [
                "name" => "Update Procurement Details",
                "slug" => "procurement-details-update",
                "description" => "Permission to update procurement details"
            ],
            [
                "name" => "Delete Procurement Details",
                "slug" => "procurement-details-delete",
                "description" => "Permission to delete procurement-details"
            ],
            [
                "name" => "View Category",
                "slug" => "view-category",
                "description" => "Permission to view category"
            ],
            [
                "name" => "Create Category",
                "slug" => "category-create",
                "description" => "Permission to create category"
            ],
            [
                "name" => "Update Category",
                "slug" => "category-update",
                "description" => "Permission to update category"
            ],
            [
                "name" => "Delete Category",
                "slug" => "category-delete",
                "description" => "Permission to delete category"
            ],
            [
                "name" => "View LGUs",
                "slug" => "view-lgu",
                "description" => "Permission to view lgus"
            ],
            [
                "name" => "Create LGU",
                "slug" => "lgu-create",
                "description" => "Permission to create LGU"
            ],
            [
                "name" => "Update LGU",
                "slug" => "lgu-update",
                "description" => "Permission to update LGU"
            ],
            [
                "name" => "Delete LGU",
                "slug" => "lgu-delete",
                "description" => "Permission to delete LGU"
            ],
            [
                "name" => "View Documents",
                "slug" => "view-documents",
                "description" => "Permission to view documents"
            ],
            [
                "name" => "Create Documents",
                "slug" => "document-create",
                "description" => "Permission to create documents"
            ],
            [
                "name" => "Update Documents",
                "slug" => "document-update",
                "description" => "Permission to update documents"
            ],
            [
                "name" => "Delete Documents",
                "slug" => "document-delete",
                "description" => "Permission to delete documents"
            ],
            [
                "name" => "View Documents Fields",
                "slug" => "view-document-field",
                "description" => "Permission to view document field"
            ],
            [
                "name" => "Create Documents Fields",
                "slug" => "document-field-create",
                "description" => "Permission to create documents field"
            ],
            [
                "name" => "Update Documents Fields",
                "slug" => "document-field-update",
                "description" => "Permission to update documents field"
            ],
            [
                "name" => "Delete Documents Fields",
                "slug" => "document-field-delete",
                "description" => "Permission to delete documents field"
            ],
            [
                "name" => "View User History",
                "slug" => "view-user-history",
                "description" => "Permission to view user history"
            ],


        ];

        foreach ($roles as $key => $role) {
            $guestPermission = [
                'view-dashboard',
                'view-procurement',
                'procurement-create',
                'procurement-update',
                'procurement-delete',
                'view-procurement-details',
                'procurement-details-create',
                'procurement-details-update',
                'procurement-details-delete',
            ];

            $_role = Role::firstOrCreate($role);
            $permissionsIds = [];
            foreach ($permissions as $key => $permission) {
                if ($role["slug"] == "admin") {
                    $_permission = Permission::firstOrCreate($permission);
                    $permissionsIds[] = $_permission->id;
                } else {
                    if (in_array($permission['slug'], $guestPermission)) {
                        $_permission = Permission::firstOrCreate($permission);
                        $permissionsIds[] = $_permission->id;
                    }
                }
            }
            $_role->allowTo($permissionsIds);
        }
    }
}
