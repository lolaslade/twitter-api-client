# Twitter API Client

Simple functions to abstract the Twitter API v2. Relies on Guzzle for HTTP communication

# Versions

* alpha 1 - Supports recent tweet search and Oauth Bearer Token
* alpha 2 - Supports arbitrary get fields

# Usage

    <?php
    
    $guzzle = new \GuzzleHttp\Client();
    $twitter_api = new \lolaslade\twitter_api_client\TwitterApiClient($guzzle, 'my_bearer_token');
    $twitter_api->setGetField("user.fields", 'id,name,username,description,profile_image_url');
    $json = $twitter_api->doRecentTweetSearch("#SAMPLEHASHTAG",
       'id,text,author_id,attachments,created_at', 'author_id');
    print($json);

