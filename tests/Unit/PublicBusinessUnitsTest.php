<?php

namespace IGD\Trustpilot\Tests\Unit;

use IGD\Trustpilot\Tests\TestBase;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;


class PublicBusinessUnitsTest extends TestBase
{

    /**
     * Trustpilot BUID
     */
    const TRUSPILOT_DOMAIN = 'trustpilot.com';
    const TRUSTPILOT_BUID = '46d6a890000064000500e0c3';


    /**
     * Test to search the first business and retrieve the reviews information.
     *
     * @return void
     */
    public function testSearchWithReviewsBusinessUnit() {
        $tp = $this->getInstance();

        $business = $tp->businessUnits()
            ->search(static::TRUSPILOT_DOMAIN)
            ->first();

        $this->assertEquals(static::TRUSTPILOT_BUID, $business->id);
        $this->assertEquals(
            sprintf(
                "%sbusiness-units/%s",
                Str::finish(config('trustpilot.endpoints.default'), '/'), $business->id
            ),
            $business->links[0]->href
        );

        $fullInfo = $business->load()->toArray();
        $this->assertArrayHasKey('numberOfReviews', $fullInfo);

        $reviews = $business->reviews()->limit(10)->get();
        $this->assertCount(10, $reviews);
    }


    /**
     * Test to search multiple business.
     *
     * @return void
     */
    public function testSearchMultipleBusinessUnit() {
        $tp = $this->getInstance();

        $business = $tp->businessUnits()
            ->search('trustpilot')
            ->toArray();

        $this->assertGreaterThan(1, count($business));
        $this->assertTrue((bool)Arr::first($business, function ($b) {
            return $b['id'] === static::TRUSTPILOT_BUID;
        }));
    }
}
