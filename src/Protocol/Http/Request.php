<?php

namespace SF\Protocol\Http;

use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use SF\Contracts\Protocol\Http\Request as RequestInterface;
use SF\Http\Cookie;
use SF\Http\Stream;
use SF\Http\UploadedFile;
use SF\Support\Json;

class Request extends Message implements RequestInterface
{

    /**
     * @var string
     */
    public $rawContent = '';
    /**
     *
     * @var array
     */
    private $server = [];
    /**
     *
     * @var string
     */
    private $requestTarget;
    /**
     *
     * @var string
     */
    private $method;
    /**
     *
     * @var UriInterface
     */
    private $uri;
    /**
     *
     * @var Cookie[]
     */
    private $cookies = [];
    /**
     *
     * @var array
     */
    private $queryParams;
    /**
     *
     * @var array
     */
    private $bodyParams;
    /**
     *
     * @var UploadedFile[]
     */
    private $files = [];

    public function __construct(array $queryParams = null, array $bodyParams = null)
    {
        $this->queryParams = $queryParams;
        $this->bodyParams = $bodyParams;
    }


    public function setHeaders(array $headers)
    {
        foreach ($headers as $name => $value) {
            $this->withAddedHeader(str_replace(' ', '-', ucwords(str_replace('-', ' ', $name))), $value);
        }

        return $this;
    }

    public function setUploadedFile(array $files)
    {
        foreach ($files as $name => $file) {
            $this->files[$name] = new UploadedFile($file);
        }

        return $this;
    }

    public function getProtocolVersion()
    {
        if ($this->protocolVersion === null) {
            $protocol              = $this->getServer('server_protocol');
            $this->protocolVersion = $protocol ? str_replace('HTTP/', '', $protocol) : '1.1';
        }

        return $this->protocolVersion;
    }

    public function getServer($name)
    {
        return $this->server[strtolower($name)] ?? null;
    }

    public function setServer(array $server)
    {
        foreach ($server as $name => $value) {
            $this->server[strtolower($name)] = $value;
        }

        return $this;
    }

    /**
     * Retrieves the message's request target.
     *
     * Retrieves the message's request-target either as it will appear (for
     * clients), as it appeared at request (for servers), or as it was
     * specified for the instance (see withRequestTarget()).
     *
     * In most cases, this will be the origin-form of the composed URI,
     * unless a value was provided to the concrete implementation (see
     * withRequestTarget() below).
     *
     * If no URI is available, and no request-target has been specifically
     * provided, this method MUST return the string "/".
     *
     * @return string
     */
    public function getRequestTarget()
    {
        if ($this->requestTarget === null) {
            $target = $this->getUri()->getPath();
            if ($target == '') {
                $target = '/';
            }
            $query = $this->getUri()->getQuery();
            if ($query) {
                $target .= '?' . $query;
            }
            $this->requestTarget = $target;
        }

        return $this->requestTarget;
    }

    /**
     * Retrieves the URI instance.
     *
     * This method MUST return a UriInterface instance.
     *
     * @link http://tools.ietf.org/html/rfc3986#section-4.3
     * @return UriInterface Returns a UriInterface instance
     *     representing the URI of the request.
     */
    public function getUri(): UriInterface
    {
        if ($this->uri === null) {
            $host      = explode(':', $this->getHeader('host'));
            $this->uri = (new Uri())
                ->withHost($host[0])
                ->withPort($host[1] ?? null)
                ->withPath($this->getServer('request_uri'))
                ->withQuery($this->getServer('query_string'));
        }

        return $this->uri;
    }

    /**
     * Return an instance with the specific request-target.
     *
     * If the request needs a non-origin-form request-target — e.g., for
     * specifying an absolute-form, authority-form, or asterisk-form —
     * this method may be used to create an instance with the specified
     * request-target, verbatim.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * changed request target.
     *
     * @link http://tools.ietf.org/html/rfc7230#section-5.3 (for the various
     *     request-target forms allowed in request messages)
     * @param mixed $requestTarget
     * @return static
     */
    public function withRequestTarget($requestTarget)
    {
        $this->requestTarget = $requestTarget;

        return $this;
    }

    /**
     * Return an instance with the provided HTTP method.
     *
     * While HTTP method names are typically all uppercase characters, HTTP
     * method names are case-sensitive and thus implementations SHOULD NOT
     * modify the given string.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * changed request method.
     *
     * @param string $method Case-sensitive method.
     * @return static
     * @throws \InvalidArgumentException for invalid HTTP methods.
     */
    public function withMethod($method)
    {
        $this->method = strtoupper($method);

        return $this;
    }

    /**
     * Returns an instance with the provided URI.
     *
     * This method MUST update the Host header of the returned request by
     * default if the URI contains a host component. If the URI does not
     * contain a host component, any pre-existing Host header MUST be carried
     * over to the returned request.
     *
     * You can opt-in to preserving the original state of the Host header by
     * setting `$preserveHost` to `true`. When `$preserveHost` is set to
     * `true`, this method interacts with the Host header in the following ways:
     *
     * - If the Host header is missing or empty, and the new URI contains
     *   a host component, this method MUST update the Host header in the returned
     *   request.
     * - If the Host header is missing or empty, and the new URI does not contain a
     *   host component, this method MUST NOT update the Host header in the returned
     *   request.
     * - If a Host header is present and non-empty, this method MUST NOT update
     *   the Host header in the returned request.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new UriInterface instance.
     *
     * @link http://tools.ietf.org/html/rfc3986#section-4.3
     * @param UriInterface $uri New request URI to use.
     * @param bool $preserveHost Preserve the original state of the Host header.
     * @return static
     */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        $this->uri = $uri;
        if ($preserveHost) {
            $host = $uri->getHost();
            $port = $uri->getPort();
            $this->withHeader('host', $port === null ? $host : $host . ':' . $port);
        }
        return $this;
    }

    public function getServers(): array
    {
        return $this->server;
    }

    public function getCookie(string $name): Cookie
    {
        $cookies = $this->getCookies();
        return $cookies[$name] ?? null;
    }

    public function getCookies()
    {
        return $this->cookies;
    }

    public function setCookies(array $cookies)
    {
        foreach ($cookies as $name => $value) {
            $this->cookies[$name] = new Cookie($name, $value);
        }

        return $this;
    }

    public function hasCookie(string $name)
    {
        $cookies = $this->getCookies();
        return isset($cookies[$name]);
    }

    public function withCookie(Cookie $cookie)
    {
        $this->cookies[$cookie->name] = $cookie;

        return $this;
    }

    public function withoutCookie(string $name)
    {
        unset($this->cookies[$name]);

        return $this;
    }

    public function getQueryParam(string $name)
    {
        $queryParams = $this->getQueryParams();
        return $queryParams[$name] ?? null;
    }

    public function getQueryParams()
    {
        return $this->queryParams;
    }

    public function hasQueryParams(string $name): bool
    {
        $queryParams = $this->getQueryParams();
        return isset($queryParams[$name]);
    }

    public function getBodyParam(string $name)
    {
        $bodyParams = $this->getBodyParams();

        return $bodyParams[$name] ?? null;
    }

    public function getBodyParams(): array
    {
        if ($this->bodyParams === null) {
            $contentType = $this->getHeader('Content-Type');
            if ($contentType && in_array('application/json', $contentType)) {
                $this->bodyParams = Json::deCode($this->getBody()->getContents(), true);
            } else {
                if ($this->getIsPost()) {
                    $this->bodyParams = (array)$this->post;
                } else {
                    if ($this->getIsPut()) {
                        mb_parse_str($this->getBody()->getContents(), $this->bodyParams);
                    } else {
                        $this->bodyParams = [];
                    }
                }
            }
        }

        return $this->bodyParams;
    }

    /**
     * Gets the body of the message.
     *
     * @return StreamInterface Returns the body as a stream.
     */
    public function getBody(): StreamInterface
    {
        if ($this->stream === null) {
            $this->stream = new Stream($this->rawContent);
        }
        return $this->stream;
    }

    public function getIsPost()
    {
        return 'POST' === $this->getMethod();
    }

    /**
     * Retrieves the HTTP method of the request.
     *
     * @return string Returns the request method.
     */
    public function getMethod()
    {
        if ($this->method === null) {
            if (isset($this->server['http_x_http_method_override'])) {
                $this->method = strtoupper($this->server['http_x_http_method_override']);
            } else {
                if (isset($this->server['request_method'])) {
                    $this->method = strtoupper($this->server['request_method']);
                } else {
                    $this->method = 'GET';
                }
            }
        }

        return $this->method;
    }

    public function getIsPut()
    {
        return 'PUT' === $this->getMethod();
    }

    public function hasBodyParam($name): bool
    {
        $bodyParams = $this->getBodyParams();
        return isset($bodyParams[$name]);
    }

    public function getIp()
    {
        $ip = '';
        if ($this->hasHeader('x-forwarded-for')) {
            $ip = $this->getHeaderLine('x-forwarded-for');
        } else {
            if ($this->hasHeader('http_x_forwarded_for')) {
                $ip = $this->getHeaderLine('http_x_forwarded_for');
            } else {
                if ($this->hasHeader('http_forwarded')) {
                    $ip = $this->getHeaderLine('http_forwarded');
                } else {
                    if ($this->hasHeader('http_forwarded_for')) {
                        $ip = $this->getHeaderLine('http_forwarded_for');
                    }
                }
            }
        }

        if ($ip) {
            $ip = explode(',', $ip);
            $ip = trim($ip[0]);
            return $ip;
        }

        if ($this->hasHeader('http_client_ip')) {
            $ip = $this->getHeaderLine('http_client_ip');
        } else {
            if ($this->hasHeader('x-real-ip')) {
                $ip = $this->getHeaderLine('x-real-ip');
            } else {
                if ($this->hasHeader('remote_addr')) {
                    $ip = $this->getHeaderLine('remote_addr');
                }
            }
        }
        return $ip;
    }

    public function getIsGet()
    {
        return 'GET' === $this->getMethod();
    }

    public function getIsOptions()
    {
        return 'OPTIONS' === $this->getMethod();
    }

    public function getIsHead()
    {
        return 'HEAD' === $this->getMethod();
    }

    public function getIsDelete()
    {
        return 'DELETE' === $this->getMethod();
    }

    public function getIsPatch()
    {
        return 'PATCH' === $this->getMethod();
    }

    public function getIsAjax()
    {
        return 'XMLHttpRequest' === $this->getServer('HTTP_X_REQUESTED_WITH');
    }

    /**
     *
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    public function getFile(string $name)
    {
        return $this->files[$name] ?? null;
    }
}