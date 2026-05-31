<?php
// tests/Feature/RatingOutOfRangeTest.php
namespace Tests\Feature;
use App\Models\Category;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class RatingOutOfRangeTest extends TestCase
{
    use RefreshDatabase;
    private Product $product;
    protected function setUp(): void
    {
        parent::setUp();
        // Prepare a dummy product once, shared across all tests in this class
        $user     = User::factory()->create(['role' => 'seller']);
        $seller   = Seller::factory()->create(['user_id' => $user->id]);
        $category = Category::factory()->create();
        $this->product = Product::factory()->create([
            'seller_id'   => $seller->id,
            'category_id' => $category->id,
            'is_active'   => true,
        ]);
    }

    public function test_rating_zero_is_rejected_by_server_validation(): void
    {
        // --- ACT: Send a POST request with rating = 0 ---
        $response = $this->post('/reviews/' . $this->product->id, [
            'product_id' => $this->product->id,
            'rating'     => 0,           // <-- invalid value
            'name'       => 'Penguji Unit',
            'email'      => 'test@example.com',
            'phone'      => '081234567890',
            'province'   => 'Jawa Tengah',
        ]);
        // --- ASSERT ---
        // Validation fails : Laravel redirects back with session error
        $response->assertSessionHasErrors(['rating']);
        // No review should be saved in the database
        $this->assertDatabaseMissing('reviews', [
            'product_id' => $this->product->id,
            'rating'     => 0,
        ]);
    }

    public function test_rating_six_is_rejected_by_server_validation(): void
    {
        // --- ACT: Send a POST request with rating = 6 ---
        $response = $this->post('/reviews/' . $this->product->id, [
            'product_id' => $this->product->id,
            'rating'     => 6,           // <-- invalid value
            'name'       => 'Penguji Unit',
            'email'      => 'test@example.com',
            'phone'      => '081234567890',
            'province'   => 'Jawa Tengah',
        ]);
        // --- ASSERT ---
        $response->assertSessionHasErrors(['rating']);
        $this->assertDatabaseMissing('reviews', [
            'product_id' => $this->product->id,
            'rating'     => 6,
        ]);
    }
    /**
     * Additional: Valid ratings (1–5) MUST be accepted
     * This proves the validation logic is not overly strict
     */
    public function test_rating_valid_satu_sampai_lima_diterima(): void
    {
        \Illuminate\Support\Facades\Mail::fake();

        foreach ([1, 2, 3, 4, 5] as $validRating) {
            $response = $this->post('/reviews/' . $this->product->id, [
                'product_id' => $this->product->id,
                'rating'     => $validRating,
                'name'       => 'Penguji Unit',
                'email'      => "test{$validRating}@example.com",
                'phone'      => '081234567890',
                'province'   => 'Jawa Tengah',
            ]);
            // There must be no validation error for the rating field
            $response->assertSessionDoesntHaveErrors(['rating']);
        }
    }
}

