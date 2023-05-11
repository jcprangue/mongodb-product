<?php

namespace App\Jobs\Product;

use App\Jobs\Product\ProductsEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Queue;

class ProductsListener
{
    use Dispatchable, Queueable;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Jobs\Product\ProductsEvent  $event
     * @return void
     */
    public function handle(ProductsEvent $event)
    {

        $url = "https://sugargang.com/sitemap.xml";
        $client = new Client();

        $xml = $client->request('GET', $url, ['verify' => false]);

        $xmlResponse = $this->xmlToJson($xml->getBody()->getContents());
        //get products url sitemaps
        $productURL = $xmlResponse["sitemap"][0]["loc"];
        $xmlProduct = $client->request('GET', $productURL, ['verify' => false]);
        $productsURL = $this->xmlToJson($xmlProduct->getBody()->getContents());


        $urls = $productsURL["url"];
        $chunksProducts = array_chunk($urls, 10);

        foreach ($chunksProducts as $key => $products) {
            //send to queue
            Queue::pushOn('ProductScrapeChannel', new BatchProductsListener($products));
        }
    }

    public function xmlToJson($response)
    {
        $xml = simplexml_load_string($response);
        $json = json_encode($xml);
        $xmlResponse = json_decode($json, TRUE);

        return $xmlResponse;
    }
}
