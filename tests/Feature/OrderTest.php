<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{

    use RefreshDatabase;

    public function test_is_the_product_orderable()
    {
        $this->actingAs(factory(\App\User::class)->create());
        factory(\App\Models\Variant::class, 1);

    }

}
