<?php

namespace Alsalty\Argocd\Core\Managers;

use Alsalty\Argocd\Helpers\Curl;
use Alsalty\Argocd\Core\Interfaces\ClustersManagerInterface;
use Alsalty\Argocd\Core\Auth;

/**
 * Managing Argo CD clusters
 */
class ClustersManager implements ClustersManagerInterface
{
    /**
     * @var Auth
     */
    private Auth $auth;
    /**
     * @var string|null
     */
    private ?string $cluster;

    /**
     * @param Auth $auth
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Get the clusters info, including everything
     * @return array
     */
    public function getClustersInfo(): array
    {
        $apiUrl = $this->auth->getApiUrl();
        $token = $this->auth->getToken();
        $endpoint = $apiUrl . '/api/v1/clusters';
        $headers = [
            'Authorization: Bearer ' . $token
        ];

        $response = Curl::get($endpoint, $headers, true);
        return $response['body'];
    }

    /**
     * Get the clusters names
     * @return array
     */
    public function getClustersNames(): array
    {
        $clusterInfo = $this->getClustersInfo();
        $clusterNames = [];

        if (isset($clusterInfo['items'])) {
            foreach ($clusterInfo['items'] as $cluster) {
                if (isset($cluster['name'])) {
                    $clusterNames[] = $cluster['name'];
                }
            }
        }

        return $clusterNames;
    }
}
