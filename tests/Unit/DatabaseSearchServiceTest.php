<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use App\Services\Search\DatabaseSearchService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSearchServiceTest extends TestCase
{
    use RefreshDatabase;

    protected DatabaseSearchService $searchService;
    protected Category $category;
    protected ProductType $productType;

    protected function setUp(): void
    {
        parent::setUp();
        $this->searchService = new DatabaseSearchService();

        $this->category = Category::create([
            'name' => 'Agro Products',
            'slug' => 'agro-products',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $this->productType = ProductType::create([
            'category_id' => $this->category->id,
            'name' => 'Spices',
            'slug' => 'spices',
            'is_active' => true,
        ]);
    }

    public function test_sorts_by_name_asc_and_desc(): void
    {
        Product::create([
            'category_id' => $this->category->id,
            'product_type_id' => $this->productType->id,
            'name' => 'Turmeric Powder',
            'slug' => 'turmeric-powder',
            'origin' => 'India',
            'short_description' => 'Pure turmeric',
            'description' => 'High curcumin turmeric',
            'status' => Product::STATUS_PUBLISHED,
            'published_at' => now(),
        ]);

        Product::create([
            'category_id' => $this->category->id,
            'product_type_id' => $this->productType->id,
            'name' => 'Coriander Seeds',
            'slug' => 'coriander-seeds',
            'origin' => 'India',
            'short_description' => 'Aromatic coriander',
            'description' => 'Sortex coriander',
            'status' => Product::STATUS_PUBLISHED,
            'published_at' => now(),
        ]);

        Product::create([
            'category_id' => $this->category->id,
            'product_type_id' => $this->productType->id,
            'name' => 'Black Pepper',
            'slug' => 'black-pepper',
            'origin' => 'India',
            'short_description' => 'Bold pepper',
            'description' => 'Malabar black pepper',
            'status' => Product::STATUS_PUBLISHED,
            'published_at' => now(),
        ]);

        // Name Ascending
        $ascResults = $this->searchService->searchProducts(['sort' => 'name_asc']);
        $namesAsc = $ascResults->pluck('name')->all();
        $this->assertSame(['Black Pepper', 'Coriander Seeds', 'Turmeric Powder'], $namesAsc);

        // Name Descending
        $descResults = $this->searchService->searchProducts(['sort' => 'name_desc']);
        $namesDesc = $descResults->pluck('name')->all();
        $this->assertSame(['Turmeric Powder', 'Coriander Seeds', 'Black Pepper'], $namesDesc);
    }

    public function test_sorts_by_newest_and_oldest_with_secondary_id_tie_breaker(): void
    {
        $baseDate = now()->subDays(5);

        // Three products created with identical published_at to verify secondary id sorting
        $p1 = Product::create([
            'category_id' => $this->category->id,
            'product_type_id' => $this->productType->id,
            'name' => 'First Product',
            'slug' => 'first-product',
            'origin' => 'India',
            'short_description' => 'First',
            'description' => 'First product',
            'status' => Product::STATUS_PUBLISHED,
            'published_at' => $baseDate,
        ]);

        $p2 = Product::create([
            'category_id' => $this->category->id,
            'product_type_id' => $this->productType->id,
            'name' => 'Second Product',
            'slug' => 'second-product',
            'origin' => 'India',
            'short_description' => 'Second',
            'description' => 'Second product',
            'status' => Product::STATUS_PUBLISHED,
            'published_at' => $baseDate,
        ]);

        $p3 = Product::create([
            'category_id' => $this->category->id,
            'product_type_id' => $this->productType->id,
            'name' => 'Third Product',
            'slug' => 'third-product',
            'origin' => 'India',
            'short_description' => 'Third',
            'description' => 'Third product',
            'status' => Product::STATUS_PUBLISHED,
            'published_at' => now(),
        ]);

        // Default / Newest should have p3 first, then p2, then p1
        $newestResults = $this->searchService->searchProducts(['sort' => 'newest']);
        $this->assertEquals([$p3->id, $p2->id, $p1->id], $newestResults->pluck('id')->all());

        // Oldest should have p1 first, then p2, then p3
        $oldestResults = $this->searchService->searchProducts(['sort' => 'oldest']);
        $this->assertEquals([$p1->id, $p2->id, $p3->id], $oldestResults->pluck('id')->all());

        // Invalid sort should fallback safely to default (newest)
        $fallbackResults = $this->searchService->searchProducts(['sort' => 'unknown_value']);
        $this->assertEquals([$p3->id, $p2->id, $p1->id], $fallbackResults->pluck('id')->all());
    }
}
