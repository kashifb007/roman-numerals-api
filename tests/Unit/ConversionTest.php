<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Conversion;

class ConversionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
    }

    /**
     * Can create a Conversion
     *
     * @return void
     */
    public function testCreateConversion()
    {
        self::assertEquals(0, Conversion::count());

        $this->get(url('/api/convert/123'))
            ->assertStatus(200);

        self::assertEquals(1, Conversion::count());
    }

    /**
     * Can get a Conversion
     */
    public function testGetConversionList()
    {
        $this->get(url('/api/convert/list'))
            ->assertStatus(200);
    }
}
