<?php

use App\Models\User;
use App\Models\Category;

test('admin can open edit category page and the form is pre-populated (DUPL-03-17)', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $category = Category::create([
        'name' => 'Kategori Lama',
        'slug' => 'kategori-lama',
        'description' => 'Deskripsi lama',
        'icon' => 'fa-tags',
        'is_active' => true,
        'order' => 3,
    ]);

    $this->actingAs($admin);

    $indexResponse = $this->get(route('admin.categories.index'));

    // Halaman Kelola Kategori harus memuat ikon Edit untuk kategori yang dipilih
    $indexResponse->assertOk();
    $indexResponse->assertViewIs('admin.categories-index');
    $indexResponse->assertSee('Kelola Kategori', escape: false);
    $indexResponse->assertSee($category->name, escape: false);
    $indexResponse->assertSee(route('admin.categories.edit', $category->id, absolute: false), escape: false);

    $editResponse = $this->get(route('admin.categories.edit', $category->id));

    // Pastikan halaman edit berhasil dimuat
    $editResponse->assertOk();
    $editResponse->assertViewIs('admin.categories-edit');
    $editResponse->assertViewHas('category', function ($viewCategory) use ($category) {
        return $viewCategory->id === $category->id;
    });

    // Pastikan form pre-populated sesuai data kategori yang dipilih
    $editResponse->assertSee('Edit Kategori', escape: false);
    $editResponse->assertSee('value="Kategori Lama"', escape: false);
    $editResponse->assertSee('value="fa-tags"', escape: false);
    $editResponse->assertSee('Deskripsi lama', escape: false);
    $editResponse->assertSee('value="3"', escape: false);
    $editResponse->assertSee('name="is_active"', escape: false);
    $editResponse->assertSee('checked', escape: false);
});