<?php
/**
 * @file
 * This file contains the interface for transporters.
 */

namespace HPCloud\Transport;

/**
 * Describes a Transporter.
 *
 * Transporters are responsible for moving data from the remote cloud to
 * the local host. Transporters are responsible only for the transport
 * protocol, not for the payloads.
 *
 * The current OpenStack services implementation is oriented toward
 * REST-based services, and consequently the transport layers are
 * HTTP/HTTPS, and perhaps SPDY some day. The interface reflects this.
 * it is not designed as a protocol-neutral transport layer
 */
interface Transporter {

  const HTTP_USER_AGENT = 'HPCloud-PHP/1.0';

  /**
   * Perform a request.
   *
   * Invoking this method causes a single request to be relayed over the
   * transporter. The transporter MUST be capable of handling multiple
   * invocations of a doRequest() call.
   *
   * @param string $uri
   *   The target URI.
   * @param string $method
   *   The method to be sent.
   * @param array $headers
   *   An array of name/value header pairs.
   * @param string $body
   *   The string containing the request body.
   */
  public function doRequest($uri, $method = 'GET', $headers = array(), $body = '');


  /**
   * Perform a request, but use a resource to read the body.
   *
   * This is a special version of the doRequest() function.
   * It handles a very spefic case where...
   * 
   * - The HTTP verb requires a body (viz. PUT, POST)
   * - The body is in a resource, not a string
   *
   * Examples of appropriate cases for this variant:
   *
   * - Uploading large files.
   * - Streaming data out of a stream and into an HTTP request.
   * - Minimizing memory usage ($content strings are big).
   *
   * Note that all parameters are required.
   *
   * @todo Declare this in Transporter.
   *
   * @param string $uri
   *   The target URI.
   * @param string $method
   *   The method to be sent.
   * @param array $headers
   *   An array of name/value header pairs.
   * @param mixed $resource
   *   The string with a file path or a stream URL; or a file object resource.
   *   If it is a string, then it will be opened with the default context.
   *   So if you need a special context, you should open the file elsewhere
   *   and pass the resource in here.
   */
  public function doRequestWithResource($uri, $method, $headers, $resource);
}
