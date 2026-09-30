<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        $sliders = [
            ['title' => 'Fresh Groceries, Delivered Daily', 'link' => '/shop/grocery', 'description' => 'Order farm-fresh groceries before 10am and get same-day delivery.'],
            ['title' => 'Up to 40% Off Electronics', 'link' => '/shop/electronics', 'description' => 'Headphones, speakers and gadgets from top brands at unbeatable prices.'],
            ['title' => 'Free Delivery Over 2000', 'link' => '/', 'description' => 'Enjoy free delivery on all orders above 2000 taka nationwide.'],
        ];

        foreach ($sliders as $slider) {
            Slider::firstOrCreate(['title' => $slider['title']], $slider + ['status' => Status::ACTIVE]);
        }
    }
}
