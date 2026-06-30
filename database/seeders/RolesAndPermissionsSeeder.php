<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ── Create Roles ──────────────────────────────────────────────
        $admin = \App\Models\Role::firstOrCreate(['name' => 'admin'], ['display_name' => 'Administrator']);
        $kader = \App\Models\Role::firstOrCreate(['name' => 'kader'], ['display_name' => 'Kader Posyandu']);

        // ── Define Permissions ────────────────────────────────────────
        $permissions = [
            'medical_record.view' => 'Lihat Rekam Medis',
            'medical_record.create' => 'Tambah Rekam Medis',
            'medical_record.update' => 'Ubah Rekam Medis',
            'medical_record.delete' => 'Hapus Rekam Medis',
            'patient.view' => 'Lihat Data Warga',
            'patient.create' => 'Tambah Data Warga',
            'patient.update' => 'Ubah Data Warga',
            'patient.delete' => 'Hapus Data Warga',
            'view_activity_logs' => 'Lihat Log Aktivitas',
            'delete_activity_logs' => 'Hapus Log Aktivitas',
            'view_reports' => 'Lihat Laporan',
            'export_reports' => 'Export Laporan',
        ];

        foreach ($permissions as $name => $displayName) {
            $permission = \App\Models\Permission::firstOrCreate(
                ['name' => $name],
                ['description' => $displayName]
            );

            // Assign all permissions to Admin for initial setup
            $admin->permissions()->syncWithoutDetaching([$permission->id]);

            // Assign view permissions to Kader for initial visibility
            if (str_ends_with($name, '.view')) {
                $kader->permissions()->syncWithoutDetaching([$permission->id]);
            }
        }
    }
}
