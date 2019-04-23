<?php

class Google_AuthNone extends Google_Auth {
  public $key = null;

  public function __construct() {
    global $apiConfig;
    if (!empty($apiConfig['developer_key'])) {
      $this->setDeveloperKey($apiConfig['developer_key']);
    }
  }

  public function setDeveloperKey($key) {$this->key = $key;}
  public function authenticate($service) {/*noop*/}
  public function setAccessToken($accessToken) {/* noop*/}
  public function getAccessToken() {return null;}
  public function createAuthUrl($scope) {return null;}
  public function refreshToken($refreshToken) {/* noop*/}
  public function revokeToken() {/* noop*/}

  public function sign(Google_HttpRequest $request) {
    if ($this->key) {
      $request->setUrl($request->getUrl() . ((strpos($request->getUrl(), '?') === false) ? '?' : '&')
          . 'key='.urlencode($this->key));
    }
    return $request;
  }
}
