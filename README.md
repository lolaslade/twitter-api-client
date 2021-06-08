# Twitter API Client

Simple functions to abstract the Twitter API v2. Relies on Guzzle for HTTP communication

# Versions

* alpha 1 - Supports recent tweet search and Oauth Bearer Token

# Usage

    <?php
    
    $guzzle = new \GuzzleHttp\Client();
    $twitter_api = new \lolaslade\twitter_api_client\TwitterApiClient($guzzle, 'my_bearer_token');
    $json = $twitter_api->doRecentTweetSearch("#SAMPLEHASHTAG");
    print($json);

