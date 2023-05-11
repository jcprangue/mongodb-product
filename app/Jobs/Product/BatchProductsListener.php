<?php

namespace App\Jobs\Product;

use App\Jobs\Product\BatchProductsEvent;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class BatchProductsListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    private $products;
    public function __construct($products)
    {
        $this->products = $products;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Jobs\Product\BatchProductsEvent  $event
     * @return void
     */
    public function handle(BatchProductsEvent $event)
    {

        if ($this->products) {
            $products = [];
            foreach ($this->products as $key => $product) {

                $client = new Client();
                $productDomHtml = $client->request('GET', $product["loc"], ['verify' => false]);

                $dom = new \DOMDocument;
                @$dom->loadHTML($productDomHtml->getBody()->getContents());

                $product = $this->getDataFromScraper($dom);
                ///save to mongodb;
                $products[] = $product;

                if ($product["title"] != ""){
                    Product::firstOrCreate($product);
                }
            }
        }
    }



    public function getDataFromScraper($dom)
    {
        $xpathQuery = [
            "title" => '//h1[contains(concat (" ", normalize-space(@class), " "), "product-meta__title")]/text()[normalize-space()]',
            "price" => '//span[contains(concat (" ", normalize-space(@class), " "), "price")]/text()[normalize-space()]',
            "image" => '//img[contains(concat (" ", normalize-space(@class), " "), "product-gallery__image")]/@data-zoom',
            "sku" => '//input[@name="id"]/@data-sku',
            'ingredient' => '//meta[@name="twitter:description"]/@content'
        ];
        $product = [];
        foreach ($xpathQuery as $key => $path) {
            try {
                $xpath = new \DomXPath($dom);
                $data = $xpath->evaluate($path);

                $product[$key] = trim($data[0]->nodeValue);

                if ($key == "price") {
                    $price = preg_replace('/[^0-9,]/', '', trim($data[0]->nodeValue));
                    $product[$key] = $price;
                }
            } catch (\Throwable $th) {
                $product[$key] = "";
            }
        }
        $product["quantity"] = rand(0,100);
        $product["slug"] = Str::slug($product["title"]);
        return $product;
    }
}
