<?php

namespace Tests\Unit;

use App\Applications\Product\Services\ProductService;
use App\Applications\Product\Repositories\IProductRepository;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
    private $productService;
    private $mockRepository;

    protected function setUp(): void
    {
        $this->mockRepository = $this->createMock(IProductRepository::class);
        $this->productService = new ProductService($this->mockRepository);
    }

    public function testGetAllProducts()
    {
        // Define the mock behavior
        $this->mockRepository->method('getAll')
            ->willReturn(collect([['id' => 1, 'name' => 'Test Product']]));

        // Call the method
        $result = $this->productService->getAll();

        // Assert the results
        $this->assertIsIterable($result);
        $this->assertEquals(1, $result->first()['id']);
    }

    public function testCreateProduct()
    {
        $productData = ['name' => 'Test Product', 'code' => 'T01', 'price' => 10.0];

        $this->mockRepository->expects($this->once())
            ->method('create')
            ->with($this->equalTo($productData))
            ->willReturn((object)$productData);

        $result = $this->productService->create($productData);

        $this->assertEquals('Test Product', $result->name);
        $this->assertEquals('T01', $result->code);
        $this->assertEquals(10.0, $result->price);
    }
}
