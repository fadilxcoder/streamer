<?php

$client = new Goutte\Client();

const BASE_URL = 'https://www.streamonsport4.click';

$mirrorDatabase = [];
$inMemoryDatabase = [
    [
        'title' => 'NANTES-LENS',
        'browser_uuid' => 'https://www.streamonsport4.click/4801-regarder-nantes-lens-en-streaming-coupe-de-france.html',
    ],
    [
        'title' => 'TOULOUSE-RODEZ',
        'browser_uuid' => 'https://www.streamonsport4.click/4802-regarder-toulouse-rodez-en-streaming-coupe-de-france.html',
    ],
];

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
        'live' => buildNeurons($streamUrls)
    ];
endforeach;

function buildNeurons($streamUrls)
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

                    $identifier[] = BASE_URL.$array;
                }
            }
        endforeach;
    endforeach;

    return $identifier;
}
