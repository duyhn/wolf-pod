<?php

namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

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
        $client = new Client();
        $response = $client->request('GET', $link);
        $contents = $response->getBody()->getContents();
        $crawler = new Crawler($contents);
        $branch = $crawler->filterXPath('//a[@id="bylineInfo"]')->text();
        $title = $crawler->filterXPath('//span[@class="a-size-large"]')->text();
        $bullets = $crawler->filterXPath('//div[@id="feature-bullets"]')->filterXPath('//li');
        $bullet4 = $bullets->eq(3)->text();
        $bullet5 = $bullets->eq(4)->text();
        $imageMockup = $crawler->filterXPath('//img[@id="landingImage"]')->attr('data-old-hires');
        $imageOriginal = $this->getNameImageOriginFromMockup($imageMockup);
        $desc = $crawler->filterXpath('//div[@id="productDescription"]')->text();
        $divBullet = $crawler->filterXpath('//div[@id="detailBullets_feature_div"]');
        $lis = $divBullet->filterXpath('//ul')->eq(0)->filterXpath('//li');
        $asin = $lis->eq(2)->filterXpath('//span')->eq(2)->text();
        $dateFirstAws = $lis->eq(4)->filterXpath('//span')->eq(2)->text();
        $bestSellerCr = $crawler->filterXpath('//li[@id ="SalesRank"]')->first();
        $bestSellerRank = null;
        if ($bestSellerCr->count() > 0) {
            $bestSellerRank = $bestSellerCr->text();
        }
        $delemiters = ["\n", "\t"];
        return [
            "branch" => $this->replaceString($branch, $delemiters),
            "title" => $this->replaceString($title, $delemiters),
            "bullet_4" => $this->replaceString($bullet4, $delemiters),
            "bullet_5" => $this->replaceString($bullet5, $delemiters),
            "image_mockup" => $this->replaceString($imageMockup, $delemiters),
            "description" => $this->replaceString($desc, $delemiters),
            "asin" => $this->replaceString($asin, $delemiters),
            "date_first_amazon" => $this->replaceString($dateFirstAws, $delemiters),
            "best_sellter_rank" => $this->replaceString($bestSellerRank, $delemiters),
            'image_original' => $imageOriginal,
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
}