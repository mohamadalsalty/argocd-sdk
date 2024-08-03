<?php

namespace Alsalty\Argocd\Core\Interfaces;

/**
 * Applications manager interface
 */
interface ApplicationsManagerInterface
{
    /**
     * Get information about applications.
     *
     * @return array
     */
    public function getApplicationsInfo(): array;

    /**
     * Get the names of all applications.
     *
     * @return array
     */
    public function getApplicationsNames(): array;

    /**
     * Set the project name for filtering applications.
     *
     * @param array|null $projects
     */
    public function setProjects(?array $projects): void;
}
