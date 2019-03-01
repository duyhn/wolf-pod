<?php

namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Image;
use File;
use Log;

class CrawlerService
{
 
    /**
     * Crawler data from link
     *
     * @param string $link Link to crawler
     *
     * @return array
     */
    public function crawler($link)
    {
        $delemiters = ["\n", "\t"];
        $client = new Client();
        $response = $client->request('GET', $link);
        $contents = $response->getBody()->getContents();        
        $crawler = new Crawler($contents);
        $branch = $crawler->filterXPath('//a[@id="bylineInfo"]')->text();
        $title = $crawler->filterXPath('//span[@class="a-size-large"]')->text();
        $priceCr = $crawler->filterXPath('//span[@id="priceblock_ourprice"]');
        $price = null;
        if ($priceCr->count() > 0) {
            $price = $priceCr->text();
        }
        $features = [];
        $bullets = $crawler->filterXPath('//div[@id="feature-bullets"]')->filterXPath('//li');
        $features = $bullets->each(function (Crawler $node, $i) use($delemiters) {
            return ["feature" => $this->replaceString($node->text(), $delemiters)];
        });
        $imageMockup = $crawler->filterXPath('//img[@id="landingImage"]')->attr('data-old-hires');
        $imageOriginal = env('AMAZONE_DOMAIN_DOWNLOAD_IMAGE').$this->getNameImageOriginFromMockup($imageMockup);
        $desc =null;
        $descCr = $crawler->filterXpath('//div[@id="productDescription"]');
        if ($descCr->count() > 0) {
            $desc = $descCr->text();
        }
        $divBullet = $crawler->filterXpath('//div[@id="detailBullets_feature_div"]');
        $lis = $divBullet->filterXpath('//ul')->eq(0)->filterXpath('//li');
        $asin = null;
        $dateFirstAws = null;
        if ($lis->count() == 5) {
            $asin = $lis->eq(2)->filterXpath('//span')->eq(2)->text();
            $dateFirstAws = $lis->eq(4)->filterXpath('//span')->eq(2)->text();
        } else {
            $asin = $lis->eq(1)->filterXpath('//span')->eq(2)->text();
            $dateFirstAws = $lis->eq(3)->filterXpath('//span')->eq(2)->text();
        }
        $bestSellerCr = $crawler->filterXpath('//li[@id ="SalesRank"]')->first();
        $bestSellerRank = null;
        if ($bestSellerCr->count() > 0) {
            $bestSellerRank = $bestSellerCr->text();
            preg_match('/([0-9]+),([0-9]+)/', $bestSellerRank, $matches);
            $bestSellerRank = $matches[0];
        }
        $imageMockup = $this->saveImageToLocal($imageMockup, $asin, 'mockup');
        $imageOriginal = $this->saveImageToLocal($imageOriginal, $asin, 'origin');
        return [
            "branch" => $this->replaceString($branch, $delemiters),
            "title" => $this->replaceString($title, $delemiters),
            "image_mockup" => $imageMockup,
            "description" => $this->replaceString($desc, $delemiters),
            "asin" => $this->replaceString($asin, $delemiters),
            "public_date" => $this->replaceString($dateFirstAws, $delemiters),
            "rank" => $bestSellerRank,
            'image_original' => $imageOriginal,
            'price' => $price,
            'features' => $features,
        ];
    }

    /**
     * Replace string
     *
     * @param string $string     String
     * @param array  $delemiters Delemiters
     *
     * @return string
     */
    public function replaceString($string, array $delemiters)
    {
        foreach($delemiters as $delemiter) {
            $string = str_replace($delemiter, "", $string);
        }
        return trim($string);
    }

    /**
     * Get name image origin from mockup url
     *
     * @param string $urlMockup Mockup image
     *
     * @return string
     */
    public function getNameImageOriginFromMockup(string $urlMockup) 
    {
        $url = urldecode($urlMockup);
        $infos = explode("|", $url);
        
        foreach ($infos as $item) {
            if (preg_match('/.*png.*/i', $item)) {
                return $item;
            }
        }
        return null;
    }
    
    /**
     * Save image to local
     *
     * @param string $url  URL image
     * @param string $asin Asin code
     * @param string $type Imgae type
     *
     * @return string
     */
    public function saveImageToLocal($url, $asin, $type)
    {
        try {
            $path = public_path()."/images/%s";
            $path = sprintf($path, $asin);
            if (!file_exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $img = Image::make($url);
            $imageName = sprintf("%s-%s.png", $asin, $type);
            $path = $path."/$imageName";
            $img->save($path);
            return $imageName;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        return null;       
    }
}