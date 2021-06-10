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

  /**
   * @var array
   */
  private array $get_fields;

  public function __construct(ClientInterface $client, $oauth_bearer_token, $base_url = TWITTER_API_V2_URL) {
    $this->client = $client;
    $this->oauth_bearer_token = $oauth_bearer_token;
    $this->base_url = $base_url;
    $this->request_options = ['connect_timeout' => 3];
    $this->request_options['headers'] = ["Authorization" => "Bearer {$this->oauth_bearer_token}"];
    $this->get_fields = [];
  }

  /**
   * Set an arbitrary field that will be used by the URL builder.
   *
   * @param string $key
   * @param string $value
   */
  public function setGetField(string $key, string $value) {
      $this->get_fields[$key] =  $value;
  }

  /**
   * Build the Query array for Recent Tweet Search.
   *
   * @param string $query_params
   * @param string|null $fields
   * @param string|null $expansions
   * @param int $max_results
   *
   * @return array
   */
  private function buildTweetQuery(string $query, string $fields = null,
                                   string $expansions = null,
                                   int $max_results = 25) : array {
    $query_params = [];
    $query_params['query'] = $query;
    if (isset($expansions)) {
      $query_params["expansions"] =  $expansions;
    }
    if (isset($fields)) {
      $query_params["tweet.fields"] =  $fields;
    }
    $query_params["max_results"] = $max_results;
    foreach ($this->get_fields as $key => $value) {
      $query_params[$key] = $value;
    }
    return $query_params;
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
    $query_params = $this->buildTweetQuery($query, $fields, $expansions, $max_results);
    $this->request_options['query'] = $query_params;
    $url = "{$this->base_url}/tweets/search/recent";
    $response = $this->client->request('GET', $url, $this->request_options);
    return $response->getBody();
  }


}
