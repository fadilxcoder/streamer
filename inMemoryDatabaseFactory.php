<?php

$client = new Goutte\Client();
$client->setMaxRedirects(2);
require_once('./vendor/mustangostang/spyc/Spyc.php');

$ymlArr = Spyc::YAMLLoad('./live.yaml');
$baseUrl = $ymlArr['configs']['base_url'];

# Crawl the whole webpage

$webPageCrawler = $client->request('GET', $baseUrl);
$streamsUrlsValue = $webPageCrawler->filter('a.game-name')->each(function ($node) {
    return $node->attr('href'); // Get link
});

$streamsUrlsKey = $webPageCrawler->filter('a.game-name span')->each(function ($node) {
    return $node->text(); // Get name
});

$streamerDataset = [];
foreach ($streamsUrlsValue as $key => $value) {
    $streamerDataset[$streamsUrlsKey[$key]] = $value;
}

# EOF Crawl the whole webpage

$mirrorDatabaseLimit = buildStreamsChannels($ymlArr, $client, $baseUrl);
$ymlArr['streams'] = $streamerDataset;
$mirrorDatabaseNoLimit = buildStreamsChannels($ymlArr, $client, $baseUrl);

function buildStreamsChannels($ymlArr, $client, $baseUrl)
{
    $mirrorDatabase = [];
    $inMemoryDatabase = [];

    foreach ($ymlArr['streams'] as $key => $value):
        $inMemoryDatabase[] = [
            'title' => $key,
            'browser_uuid' =>  $value,
        ];
    endforeach;

    foreach ($inMemoryDatabase as $key => $data) :
        try {
            $crawler = $client->request('GET', $data['browser_uuid']);
            $streamUrls = $crawler->filter('div#chanel_links a')->each(function ($node) {
                return $node->attr('onclick');
            });
        } 
        catch(\LogicException $e) {

            $streamUrls = [];
        }

        if (!empty($streamUrls)) {
            $mirrorDatabase[] = [
                '_id' => uniqid(),
                'id' => (int)$key + 1,
                'title' => $data['title'],
                'browser_uuid' => $data['browser_uuid'],
                'live' => buildNeurons($baseUrl, $streamUrls)
            ];
        }
    endforeach;

    return $mirrorDatabase;
}

function buildNeurons($baseUrl, $streamUrls)
{
    $identifier = [];
    foreach ($streamUrls as $url) :
        $explodeArr = explode("'", $url);
        foreach ($explodeArr as $array)  :
        
            if (preg_match('#/#', $array))
            {
                if (preg_match('#https#', $array))
                {
                    $uriFormat = explode("id=", $array);

                    foreach ($uriFormat as $uri)
                    {
                        if (str_contains($uri, 'https')) {
                            $identifier[] = $uri;
                        }
                    }
                } else {

                    $identifier[] = $baseUrl.$array;
                }
            }
        endforeach;
    endforeach;

    return $identifier;
}
