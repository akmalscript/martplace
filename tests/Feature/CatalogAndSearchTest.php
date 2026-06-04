<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
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

    /**
     * Test case: DUPL-06-24
     * Melakukan pencarian dengan input huruf kapital/kecil (case insensitive)
     */
    public function test_search_is_case_insensitive(): void
    {
        // --- ARRANGE ---
        $user = User::factory()->create(['role' => 'seller']);
        $seller = Seller::factory()->create(['user_id' => $user->id]);
        $category = Category::factory()->create();

        // Membuat produk target dengan nama campuran huruf besar-kecil
        Product::factory()->create([
            'seller_id' => $seller->id,
            'category_id' => $category->id,
            'name' => 'Kaos Polos Cotton',
            'is_active' => true,
        ]);

        // --- ACT ---
        // Skenario 1: Pencarian menggunakan huruf kecil semua
        $responseLower = $this->get('/products?search=kaos+polos');

        // Skenario 2: Pencarian menggunakan huruf besar semua
        $responseUpper = $this->get('/products?search=KAOS+POLOS');

        // --- ASSERT ---
        // Program terbukti mengeksekusi Jalur Pencarian Case Insensitive.
        // Asersi status respons 200 dan konten teks "Kaos Polos Cotton" harus bernilai True
        $responseLower->assertStatus(200);
        $responseLower->assertSee('Kaos Polos Cotton');

        $responseUpper->assertStatus(200);
        $responseUpper->assertSee('Kaos Polos Cotton');
    }
}
