<?php

use App\Models\User;

test('admin can open the create category page from category management (DUPL-03-12)', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $this->actingAs($admin);

    $indexResponse = $this->get(route('admin.categories.index'));

    // Halaman Kelola Kategori harus terbuka dan memiliki tombol Tambah Kategori
    $indexResponse->assertOk();
    $indexResponse->assertViewIs('admin.categories-index');
    $indexResponse->assertSee('Kelola Kategori', escape: false);
    $indexResponse->assertSee('Tambah Kategori', escape: false);
    $indexResponse->assertSee(route('admin.categories.create', absolute: false), escape: false);

    $createResponse = $this->get(route('admin.categories.create'));

    // Halaman form Tambah Kategori harus terbuka tanpa error
    $createResponse->assertOk();
    $createResponse->assertViewIs('admin.categories-create');
    $createResponse->assertSee('Tambah Kategori Baru', escape: false);
    $createResponse->assertSee('Nama Kategori', escape: false);
    $createResponse->assertSee(route('admin.categories.store', absolute: false), escape: false);
});