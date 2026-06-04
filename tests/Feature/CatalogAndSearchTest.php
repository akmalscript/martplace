<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogAndSearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test case: DUPL-06-22
     * Menampilkan pesan jika tidak ada produk pada katalog (HTML view empty state)
     */
    public function test_catalog_shows_empty_message_when_no_products_exist(): void
    {
        // --- ARRANGE ---
        // Memastikan tidak ada produk di database
        Product::query()->delete();

        // --- ACT ---
        // Mengakses halaman katalog produk utama
        $response = $this->get(route('products.index'));

        // --- ASSERT ---
        // Program terbukti mengeksekusi Jalur Normal (Empty State).
        // Asersi status respons 200 dan konten teks "Produk Tidak Ditemukan"
        $response->assertStatus(200);
        $response->assertSee('Produk Tidak Ditemukan');
        $response->assertSee('Maaf, tidak ada produk yang sesuai dengan pencarian Anda');
    }

    /**
     * Test case: DUPL-06-22 (AJAX scenario)
     * Menampilkan response kosong dengan pagination total 0 jika tidak ada produk pada request AJAX
     */
    public function test_catalog_returns_empty_json_when_no_products_exist_via_ajax(): void
    {
        // --- ARRANGE ---
        // Memastikan tidak ada produk di database
        Product::query()->delete();

        // --- ACT ---
        // Mengirimkan request AJAX ke halaman katalog utama
        $response = $this->get(route('products.index'), [
            'HTTP_X-Requested-With' => 'XMLHttpRequest'
        ]);

        // --- ASSERT ---
        // Program terbukti mengeksekusi Jalur AJAX (Empty State).
        // Asersi status respons 200 dan data JSON kosong
        $response->assertStatus(200);
        $response->assertJson([
            'products' => [],
            'pagination' => [
                'current_page' => 1,
                'last_page' => 1,
                'total' => 0,
            ]
        ]);
    }
}
