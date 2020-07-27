<?php
namespace IGD\Trustpilot\API\BusinessUnit\Product;

use IGD\Trustpilot\API\BusinessUnit\Product\ProductApi;
use IGD\Trustpilot\API\Resource;

class Product extends Resource
{
    /**
     * Save the product.
     *
     * @return mixed
     */
    public function save()
    {
        return (new ProductApi())->save([$this->toSaveArray()])[0];
    }

    /**
     * Get the parameters to save.
     *
     * @return array
     */
    private function toSaveArray()
    {
        return [
            'sku' => $this->sku,
            'title' => $this->title,
            'description' => $this->description,
            'mpn' => $this->mpn,
            'price' => $this->price,
            'currency' => $this->currency,
            'link' => $this->link,
            'imageLink' => $this->imageLink,
            'gtin' => $this->gtin,
            'brand' => $this->brand,
            'googleMerchantCenterProductId' => $this->googleMerchantCenterProductId,
        ];
    }
}
