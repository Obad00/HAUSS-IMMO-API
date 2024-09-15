<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // Créer les permissions s'ils n'existent pas déjà
            $permissions = [
                'creer utilisateur',
                'editer utilisateur',
                'supprimer utilisateur',
                'voir utilisateur',
            ];

            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission]);
            }

            // Créer les rôles s'ils n'existent pas déjà
            $admin = Role::firstOrCreate(['name' => 'admin']);
            $locataire = Role::firstOrCreate(['name' => 'locataire']);
            $proprietaire = Role::firstOrCreate(['name' => 'proprietaire']);

            // Attribuer toutes les permissions à l'admin
            $admin->givePermissionTo(Permission::all());

            // Attribuer la permission de voir aux locataires et propriétaires
            $locataire->givePermissionTo('voir utilisateur');
            $proprietaire->givePermissionTo('voir utilisateur');
        });
    }
}
