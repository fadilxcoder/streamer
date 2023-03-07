<?php

$client = new Goutte\Client();
require_once('./vendor/mustangostang/spyc/Spyc.php');

$ymlArr = Spyc::YAMLLoad('./live.yaml');
$baseUrl = $ymlArr['configs']['base_url'];
$mirrorDatabase = [];
$inMemoryDatabase = [];

foreach ($ymlArr['streams'] as $key => $value):
    $inMemoryDatabase[] = [
        'title' => $key,
        'browser_uuid' =>  $value,
    ];
endforeach;

foreach ($inMemoryDatabase as $key => $data) :
    $crawler = $client->request('GET', $data['browser_uuid']);

    $streamUrls = $crawler->filter('div#chanel_links a')->each(function ($node) {
        return $node->attr('onclick');
    });

    $mirrorDatabase[] = [
        '_id' => uniqid(),
        'id' => (int)$key + 1,
        'title' => $data['title'],
        'browser_uuid' => $data['browser_uuid'],
        'live' => buildNeurons($baseUrl, $streamUrls)
    ];
endforeach;

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
