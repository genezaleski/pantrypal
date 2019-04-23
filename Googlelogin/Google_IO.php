<?php


require_once 'io/Google_HttpRequest.php';
require_once 'io/Google_CurlIO.php';
require_once 'io/Google_REST.php';

/**
 * Abstract IO class
 *
 * @author Chris Chabot <chabotc@google.com>
 */
interface Google_IO {
  /**
   * An utility function that first calls $this->auth->sign($request) and then executes makeRequest()
   * on that signed request. Used for when a request should be authenticated
   * @param Google_HttpRequest $request
   * @return Google_HttpRequest $request
   */
  public function authenticatedRequest(Google_HttpRequest $request);

  /**
   * Executes a apIHttpRequest and returns the resulting populated httpRequest
   * @param Google_HttpRequest $request
   * @return Google_HttpRequest $request
   */
  public function makeRequest(Google_HttpRequest $request);

  /**
   * Set options that update the transport implementation's behavior.
   * @param $options
   */
  public function setOptions($options);

}
