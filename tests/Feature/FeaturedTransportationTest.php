<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeaturedTransportationTest extends TestCase
{
    use RefreshDatabase;

    public function test_featured_page_loads_successfully_with_all_transportation_modes(): void
    {
        $response = $this->get('/featured');

        $response->assertStatus(200);

        // Hero Content
        $response->assertSee("Moving India's Products to the World.", false);
        $response->assertSee("Reliable transportation solutions connecting India's agricultural heartlands with global markets through road, air, and sea logistics.");

        // Transportation Section
        $response->assertSee("Choose Your Way of Transport");

        // 01 - ROAD
        $response->assertSee("01 &mdash; ROAD", false);
        $response->assertSee("Road Transportation");
        $response->assertSee("Farm-to-warehouse transportation");
        $response->assertSee("Warehouse-to-port movement");
        $response->assertSee("Flexible pickup and delivery");
        $response->assertSee("Suitable for short and medium distances");

        // 02 - AIRWAY
        $response->assertSee("02 &mdash; AIRWAY", false);
        $response->assertSee("Air Transportation");
        $response->assertSee("Rapid international delivery");
        $response->assertSee("Suitable for urgent shipments");
        $response->assertSee("Ideal for high-value products");
        $response->assertSee("Suitable for smaller-volume shipments");

        // 03 - SEAWAYS
        $response->assertSee("03 &mdash; SEAWAYS", false);
        $response->assertSee("Sea Transportation");
        $response->assertSee("Containerized shipping");
        $response->assertSee("Suitable for bulk agricultural products");
        $response->assertSee("Cost-effective international logistics");
        $response->assertSee("Access to major Indian ports");

        // Why Choose Our Logistics
        $response->assertSee("Why Choose Our Logistics");

        // Final CTA
        $response->assertSee("Ready to Move Your Products Globally?");
        $response->assertSee("Request a Quote");
    }

    public function test_homepage_elements_match_specifications(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        // Topmost information bar color reverse: bg-[#EBD6B4] and text-[#091433]
        $response->assertSee('bg-[#EBD6B4]');
        $response->assertSee('text-[#091433]');

        // Hero section has Featured button
        $response->assertSee(route('featured'));
        $response->assertSee('Featured');

        // Existing CTA section: Request a Formal Quotation removed, Direct Contact Details kept
        $response->assertDontSee('Request a Formal Quotation');
        $response->assertSee('Direct Contact Details');

        // Footer has Regional Registered Office, not Rajkot Registered Office
        $response->assertSee('Regional Registered Office');
        $response->assertDontSee('Rajkot Registered Office');

        // Featured Export Commodities section background has #F7F3EC
        $response->assertSee('bg-[#F7F3EC]');
    }
}
