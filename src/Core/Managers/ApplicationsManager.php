<?php

namespace Alsalty\Argocd\Core\Managers;

use Alsalty\Argocd\Helpers\Curl;
use Alsalty\Argocd\Core\Interfaces\ApplicationsManagerInterface;
use Alsalty\Argocd\Core\Auth;

/**
 * Managing Argo CD applications
 */
class ApplicationsManager implements ApplicationsManagerInterface
{
    /**
     * @var Auth
     */
    private Auth $auth;

    /**
     * @var array|null
     */
    private ?array $projects = null;

    /**
     * @var string|null
     */
    private ?string $appNamespace = null;

    /**
     * ApplicationsManager constructor.
     * @param Auth $auth
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Set the projects filter.
     * @param array|null $projects
     * @return void
     */
    public function setProjects(?array $projects): void
    {
        $this->projects = $projects;
    }

    /**
     * Set the app namespace filter.
     * @param string|null $appNamespace
     * @return void
     */
    public function setAppNamespace(?string $appNamespace): void
    {
        $this->appNamespace = $appNamespace;
    }

    /**
     * Get information about applications with the current filters.
     * @return array
     */
    public function getApplicationsInfo(): array
    {
        $apiUrl = $this->auth->getApiUrl();
        $token = $this->auth->getToken();
        $endpoint = $apiUrl . '/api/v1/applications';
        $headers = [
            'Authorization: Bearer ' . $token
        ];

        // Associative array to hold query parameters
        $queryParams = [
            'projects' => !empty($this->projects) ? implode(',', $this->projects) : null,
            'appNamespace' => $this->appNamespace,
        ];

        // Filter out null values and build the query string
        $query = http_build_query(array_filter($queryParams, function ($value) {
            return $value !== null;
        }));

        // Append query parameters to the endpoint if any
        if (!empty($query)) {
            $endpoint .= '?' . $query;
        }

        // Debug: output the endpoint for verification
        echo $endpoint;

        $response = Curl::get($endpoint, $headers, true);
        return $response['body'];
    }

    /**
     * Get the names of the applications with the current filters.
     * @return array
     */
    public function getApplicationsNames(): array
    {
        $applicationsInfo = $this->getApplicationsInfo();
        $applicationNames = [];

        if (isset($applicationsInfo['items'])) {
            foreach ($applicationsInfo['items'] as $application) {
                if (isset($application['metadata']['name'])) {
                    $applicationNames[] = $application['metadata']['name'];
                }
            }
        }

        return $applicationNames;
    }
}
