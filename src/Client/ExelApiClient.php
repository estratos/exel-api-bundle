<?php

declare(strict_types=1);

namespace Exel\ApiBundle\Client;

use Exel\ApiBundle\Exception\ApiException;
use Exel\ApiBundle\Exception\AuthenticationException;
use Exel\ApiBundle\Exception\ValidationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\Retry\GenericRetryStrategy;
use Symfony\Component\HttpClient\RetryableHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class ExelApiClient
{
    private HttpClientInterface $httpClient;

    public function __construct(
        HttpClientInterface $httpClient,
        private string $baseUrl,
        private string $apiKey,
        private int $maxRetries = 3,
        private int $retryDelayMs = 1000,
        private float $retryMultiplier = 2.0,
        private bool $logEnabled = true,
        private bool $logRequestBody = false,
        private bool $logResponseBody = false,
        private int $connectionTimeout = 10,
        private int $responseTimeout = 30,
        private ?LoggerInterface $logger = null
    ) {
        $this->httpClient = $this->buildRetryClient($httpClient);
    }

    public function get(string $endpoint, array $query = []): array
    {
        return $this->request('GET', $endpoint, ['query' => $query]);
    }

    public function post(string $endpoint, array $data = []): array
    {
        return $this->request('POST', $endpoint, ['json' => $data]);
    }

    private function request(string $method, string $endpoint, array $options = []): array
    {
        $url = rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/');
        
        $options = array_merge([
            'headers' => [
                'Authorization' => $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'timeout' => $this->responseTimeout,
        ], $options);

        if ($this->logEnabled) {
            $this->logRequest($method, $url, $options);
        }

        $startTime = microtime(true);
        
        try {
            $response = $this->httpClient->request($method, $url, $options);
            $data = $this->handleResponse($response);
            
            if ($this->logEnabled) {
                $duration = (microtime(true) - $startTime) * 1000;
                $this->logger?->info('API request completed', [
                    'method' => $method,
                    'url' => $url,
                    'duration_ms' => round($duration, 2),
                    'status_code' => $response->getStatusCode(),
                ]);
            }
            
            return $data;
        } catch (ApiException $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw new ApiException(
                sprintf('API request failed: %s', $e->getMessage()),
                null,
                null,
                $e
            );
        }
    }

    private function handleResponse(ResponseInterface $response): array
    {
        $statusCode = $response->getStatusCode();

        if ($statusCode >= 200 && $statusCode < 300) {
            try {
                $content = $response->getContent(false);
                
                if ($this->logEnabled && $this->logResponseBody) {
                    $this->logger?->debug('Response body', ['body' => $content]);
                }
                
                return json_decode($content, true) ?? [];
            } catch (\Throwable $e) {
                throw new ApiException('Failed to parse response: ' . $e->getMessage(), $statusCode, null, $e);
            }
        }

        // Handle error responses
        $errorData = $this->extractErrorData($response);

        throw match ($statusCode) {
            401 => new AuthenticationException($errorData['message'] ?? 'Invalid API key'),
            404 => new ApiException($errorData['message'] ?? 'Resource not found', $statusCode, $errorData),
            422 => new ValidationException(
                $errorData['message'] ?? 'Validation failed',
                $errorData['errors'] ?? []
            ),
            default => new ApiException(
                $errorData['message'] ?? sprintf('API error with status code %d', $statusCode),
                $statusCode,
                $errorData
            ),
        };
    }

    private function extractErrorData(ResponseInterface $response): array
    {
        try {
            $content = $response->getContent(false);
            $data = json_decode($content, true);
            
            if (is_array($data)) {
                return $data;
            }
            
            return ['message' => $content];
        } catch (\Throwable $e) {
            return ['message' => $e->getMessage()];
        }
    }

    private function buildRetryClient(HttpClientInterface $client): HttpClientInterface
    {
        if (!$this->maxRetries) {
            return $client;
        }

        $retryStrategy = new GenericRetryStrategy(
            retryStatusCodes: [429, 500, 502, 503, 504],
            delayMs: $this->retryDelayMs,
            multiplier: $this->retryMultiplier,
            maxDelayMs: 30000
        );

        return new RetryableHttpClient(
            $client,
            $retryStrategy,
            $this->maxRetries,
            $this->logger
        );
    }

    private function logRequest(string $method, string $url, array $options): void
    {
        $logData = [
            'method' => $method,
            'url' => $url,
            'headers' => array_keys($options['headers'] ?? []),
        ];

        if ($this->logRequestBody && isset($options['json'])) {
            $logData['body'] = $options['json'];
        }

        if ($this->logRequestBody && isset($options['query'])) {
            $logData['query'] = $options['query'];
        }

        $this->logger?->info('API request', $logData);
    }

    public function setLogger(?LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}
