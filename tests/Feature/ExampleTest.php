<?php

namespace Tests\Feature;

namespace Database\Factories;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // Run your migrations
        Artisan::call('migrate');

        // Seed your database with test data (if needed)
        Artisan::call('db:seed');
    }

    /** @test */
    public function it_can_create_a_product()
    {
        $payload = [
            'name' => 'Sample Product',
            'description' => 'This is a sample product',
            'price' => 10.99,
            'quantity' => 100,
        ];

        $response = $this->postJson('/api/products', $payload);

        $response->assertStatus(201); // Ensure resource created
        $this->assertDatabaseHas('products', ['name' => 'Sample Product']);
    }

    

    /** @test */
    public function it_can_list_all_products()
    {
        Product::factory()->count(3)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data'); // Assuming API response structure has 'data' key for array
    }

    /** @test */
    public function it_can_show_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJson(['data' => [
                'id' => $product->id,
                'name' => $product->name,
                // Add other assertions as needed
            ]]);
    }

    /** @test */
    public function it_can_update_a_product()
    {
        $product = Product::factory()->create();

        $payload = [
            'name' => 'Updated Product Name',
            'description' => 'Updated description',
            'price' => 19.99,
            'quantity' => 50,
        ];

        $response = $this->putJson("/api/products/{$product->id}", $payload);

        $response->assertStatus(201); // Ensure resource updated
        $this->assertDatabaseHas('products', ['name' => 'Updated Product Name']);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(201); // Ensure resource deleted
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
