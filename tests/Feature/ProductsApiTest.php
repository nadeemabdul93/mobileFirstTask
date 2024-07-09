<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\factory;
class ProductsApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_returns_all_products()
    {
        // Create some products
        factory(Product::class, 5)->create();

    // Make a GET request to the API endpoint
    $response = $this->getJson('/api/products');

    // Dump the response content for debugging
    $response->dump();

    // Assert the response is successful
    $response->assertStatus(200);

    // Assert the response contains the expected products
    $response->assertJsonCount(5, 'data');

    // Verify the products are in the database
    $this->assertCount(5, Product::all());
    }

    /**
     * @test
     */
    public function it_returns_a_single_product()
    {
        // Create a product
        $product = factory(Product::class)->create();

        // Make a GET request to the API endpoint
        $response = $this->getJson("/api/products/{$product->id}");

        // Assert the response is successful
        $response->assertStatus(200);

        // Assert the response contains the expected product
        $response->assertJsonFragment(['id' => $product->id, 'name' => $product->name]);
    }

    /**
     * @test
     */
    public function it_creates_a_new_product()
    {
        // Make a POST request to the API endpoint
        $response = $this->postJson('/api/products', [
            'name' => 'New Product',
            'description' => 'This is a new product',
            'price' => 19.99,
        ]);

        // Assert the response is successful
        $response->assertStatus(201);

        // Assert the response contains the expected product
        $response->assertJsonFragment(['name' => 'New Product', 'description' => 'This is a new product', 'price' => 19.99]);

        // Assert the product was created in the database
        $this->assertCount(1, Product::all());
    }

    /**
     * @test
     */
    public function it_updates_an_existing_product()
    {
        // Create a product
        $product = factory(Product::class)->create();

        // Make a PATCH request to the API endpoint
        $response = $this->patchJson("/api/products/{$product->id}", [
            'name' => 'Updated Product',
            'description' => 'This is an updated product',
        ]);

        // Assert the response is successful
        $response->assertStatus(200);

        // Assert the response contains the expected product
        $response->assertJsonFragment(['name' => 'Updated Product', 'description' => 'This is an updated product']);

        // Assert the product was updated in the database
        $this->assertEquals('Updated Product', $product->fresh()->name);
    }

    /**
     * @test
     */
    public function it_deletes_an_existing_product()
    {
        // Create a product
        $product = factory(Product::class)->create();

        // Make a DELETE request to the API endpoint
        $response = $this->deleteJson("/api/products/{$product->id}");

        // Assert the response is successful
        $response->assertStatus(204);

        // Assert the product was deleted from the database
        $this->assertCount(0, Product::all());
    }
}