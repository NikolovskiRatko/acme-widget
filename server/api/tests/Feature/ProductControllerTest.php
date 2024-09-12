<?php

namespace Tests\Feature;

use App\Applications\Product\Model\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase; // This will refresh the database after each test

    public function testGetAllProducts()
    {
        // Arrange: Create some products in the database
        Product::factory()->create(['name' => 'Red Widget', 'code' => 'R01', 'price' => 32.95]);
        Product::factory()->create(['name' => 'Green Widget', 'code' => 'G01', 'price' => 24.95]);

        // Act: Call the GET endpoint
        $response = $this->getJson('/api/product/all');

        // Assert: Check that the response is correct
        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonFragment(['name' => 'Red Widget', 'code' => 'R01']);
    }

    public function testCreateProduct()
    {
        // Arrange: Prepare product data
        $productData = [
            'name' => 'Blue Widget',
            'code' => 'B01',
            'price' => 7.95,
        ];

        // Act: Call the POST endpoint
        $response = $this->postJson('/api/product/create', $productData);

        // Assert: Check that the product was created successfully
        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'Blue Widget', 'code' => 'B01']);

        $this->assertDatabaseHas('products', ['name' => 'Blue Widget']);
    }

    public function testUpdateProduct()
    {
        // Arrange: Create a product
        $product = Product::factory()->create(['name' => 'Red Widget', 'code' => 'R01', 'price' => 32.95]);

        // Act: Update the product
        $updatedData = ['name' => 'Updated Widget', 'code' => 'R01', 'price' => 35.00];
        $response = $this->putJson("/api/product/{$product->id}/update", $updatedData);

        // Assert: Check that the update was successful
        $response->assertStatus(200);
        $this->assertDatabaseHas('products', ['name' => 'Updated Widget', 'price' => 35.00]);
    }

    public function testDeleteProduct()
    {
        // Arrange: Create a product
        $product = Product::factory()->create(['name' => 'Red Widget', 'code' => 'R01', 'price' => 32.95]);

        // Act: Call the DELETE endpoint
        $response = $this->deleteJson("/api/product/{$product->id}/delete");

        // Assert: Check that the deletion was successful
        $response->assertStatus(200);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
