<?php
// tests/Feature/ProductSearchPartialMatchTest.php
namespace Tests\Feature;
use App\Models\Category;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class ProductSearchPartialMatchTest extends TestCase
{
    use RefreshDatabase;

    public function test_partial_match_search(): void
    {
        // --- ARRANGE: Prepare data in the test database ---
        $user   = User::factory()->create(['role' => 'seller']);
        $seller = Seller::factory()->create(['user_id' => $user->id]);
        $category = Category::factory()->create();
        // Product that MUST be found (its name contains "Lapt")
        $targetProduct = Product::factory()->create([
            'seller_id'   => $seller->id,
            'category_id' => $category->id,
            'name'        => 'Laptop Gaming RTX 4060',
            'is_active'   => true,
        ]);
        // Product that must NOT be found
        Product::factory()->create([
            'seller_id'   => $seller->id,
            'category_id' => $category->id,
            'name'        => 'Mouse Wireless Logitech',
            'is_active'   => true,
        ]);
        // --- ACT: Call the controller directly via simulated HTTP ---
        $response = $this->get('/products?search=Lapt');
        // --- ASSERT: Verify the results ---
        $response->assertStatus(200);
        // The target product must appear on the page
        $response->assertSee('Laptop Gaming RTX 4060');
        // The irrelevant product must NOT appear in the search results
        $response->assertDontSee('Mouse Wireless Logitech');
    }

    public function test_partial_match_search_case_insensitive(): void
    {
        $user     = User::factory()->create(['role' => 'seller']);
        $seller   = Seller::factory()->create(['user_id' => $user->id]);
        $category = Category::factory()->create();
        Product::factory()->create([
            'seller_id'   => $seller->id,
            'category_id' => $category->id,
            'name'        => 'Laptop Gaming RTX 4060',
            'is_active'   => true,
        ]);
        // Search using all lowercase — MySQL LIKE is case-insensitive by default
        $response = $this->get('/products?search=laptop');
        $response->assertStatus(200);
        $response->assertSee('Laptop Gaming RTX 4060');
    }
}
