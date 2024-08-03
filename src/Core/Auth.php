<?php

namespace Alsalty\Argocd\Core;

use Alsalty\Argocd\Helpers\Curl;
use Exception;

/**
 *
 */
class Auth
{
    /**
     * Argo CD api url
     * @var string
     */
    private string $apiUrl;
    /**
     * Argo CD username
     * @var string
     */
    private string $username;
    /**
     * Argo CD password
     * @var string
     */
    private string $password;
    /**
     * Argo CD token
     * @var string
     */
    private string $token;

    /**
     * Construct the class
     */
    public function __construct(string $apiUrl, string $username, string $password)
    {
        $this->apiUrl = $apiUrl;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function authenticate(): void
    {
        $endpoint = $this->apiUrl . '/api/v1/session';

        $payload = [
            'username' => $this->username,
            'password' => $this->password
        ];

        $headers = ['Content-Type: application/json'];

        $response = Curl::post($endpoint, $payload, $headers, true);

        if ($response['httpCode'] === 200 && isset($response['body']['token'])) {
            $this->token = $response['body']['token'];
        } else {
            $errorMessage = $response['body']['message'] ?? 'Unknown error';
            throw new Exception("Authentication failed: $errorMessage");
        }
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }
    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }
}
