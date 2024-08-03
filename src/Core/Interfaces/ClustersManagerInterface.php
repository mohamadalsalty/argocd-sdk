<?php

namespace Alsalty\Argocd\Core\Interfaces;

/**
 * Clusters manager interface
 */
interface ClustersManagerInterface
{
    /**
     * Get information about clusters.
     *
     * @return array
     */
    public function getClustersInfo(): array;

    /**
     * Get the names of all clusters.
     *
     * @return array
     */
    public function getClustersNames(): array;
}