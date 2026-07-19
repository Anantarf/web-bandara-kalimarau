<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Table Columns
    |--------------------------------------------------------------------------
    */

    'column.name' => 'Nama Hak Akses',
    'column.guard_name' => 'Sistem Guard',
    'column.roles' => 'Hak Akses',
    'column.permissions' => 'Izin',
    'column.updated_at' => 'Dirubah',

    /*
    |--------------------------------------------------------------------------
    | Form Fields
    |--------------------------------------------------------------------------
    */

    'field.name' => 'Nama Hak Akses',
    'field.guard_name' => 'Sistem Guard',
    'field.permissions' => 'Izin',
    'field.select_all.name' => 'Pilih Semua',
    'field.select_all.message' => 'Aktifkan semua izin yang <span class="text-primary font-medium">Tersedia</span> untuk Hak Akses ini.',

    /*
    |--------------------------------------------------------------------------
    | Navigation & Resource
    |--------------------------------------------------------------------------
    */

    'nav.group' => 'Pengaturan',
    'nav.role.label' => 'Hak Akses',
    'nav.role.icon' => 'heroicon-o-shield-check',
    'resource.label.role' => 'Hak Akses',
    'resource.label.roles' => 'Hak Akses',

    /*
    |--------------------------------------------------------------------------
    | Section & Tabs
    |--------------------------------------------------------------------------
    */

    'section' => 'Entitas',
    'resources' => 'Sumber Daya',
    'widgets' => 'Widget',
    'pages' => 'Halaman',
    'custom' => 'Izin Kustom',

    /*
    |--------------------------------------------------------------------------
    | Messages
    |--------------------------------------------------------------------------
    */

    'forbidden' => 'Kamu tidak punya izin akses',

    /*
    |--------------------------------------------------------------------------
    | Resource Permissions' Labels
    |--------------------------------------------------------------------------
    */

    'resource_permission_prefixes_labels' => [
        'view' => 'Lihat',
        'view_any' => 'Lihat Apa Saja',
        'create' => 'Buat',
        'update' => 'Perbarui',
        'delete' => 'Hapus',
        'delete_any' => 'Hapus Apa Saja',
        'force_delete' => 'Paksa Hapus',
        'force_delete_any' => 'Paksa Hapus Apa Saja',
        'restore' => 'Pulihkan',
        'replicate' => 'Replikasi',
        'reorder' => 'Susun Ulang',
        'restore_any' => 'Pulihkan Apa Saja',
    ],
];
