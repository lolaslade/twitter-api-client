<?php

namespace lolaslade\twitterapiclient;

use GuzzleHttp\ClientInterface;

const TWITTER_API_V2_URL = 'https://api.twitter.com/2';

class TwitterApiClient {

  /**
   * @var string
   */
  protected string $oauth_bearer_token;

  /**
   * @var string
   */
  protected string $base_url;

  /**
   * @var \GuzzleHttp\ClientInterface
   */
  protected ClientInterface $client;

  /**
   * @var array
   */
  private array $request_options;

  public function __construct(ClientInterface $client, $oauth_bearer_token, $base_url = TWITTER_API_V2_URL) {
    $this->client = $client;
    $this->oauth_bearer_token = $oauth_bearer_token;
    $this->base_url = $base_url;
    $this->request_options = ['connect_timeout' => 3];
    $this->request_options['headers'] = ["Authorization" => "Bearer {$this->oauth_bearer_token}"];
  }

  /**
   * Build the URL for Recent Tweet Search.
   *
   * @param string $query
   * @param string|null $fields
   * @param string|null $expansions
   * @param int $max_results
   *
   * @return string
   */
  private function buildRecentTweetQueryUrl(string $query, string $fields = null,
                                            string $expansions = null,
                                            int $max_results = 25) : string {
    $query = urlencode($query);
    $url = "{$this->base_url}/tweets/search/recent?query={$query}";
    if (isset($expansions)) {
      $url = $url . "&expansions=" . urlencode($expansions);
    }
    if (isset($fields)) {
      $url = $url . "&tweet.fields=" . urlencode($fields);
    }
    return $url . "&max_results=" . $max_results;
  }

  /**
   * Search recent tweets.
   *
   * @param string $query
   *   The query, will be urlencoded.
   * @param string|null $fields
   *   The fields (optional), will be urlencoded.
   * @param string|null $expansions
   *   Expansions (optional), will be urlencoded.
   * @param int $max_results
   *   How many results to return.
   *
   * @return string The JSON result in the body.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function doRecentTweetSearch(string $query, string $fields = null,
                                      string $expansions = null,
                                      int $max_results = 25): string {
    $url = $this->buildRecentTweetQueryUrl($query, $fields, $expansions, $max_results);
    $response = $this->client->request('GET', $url, $this->request_options);
    return $response->getBody();
  }


}
