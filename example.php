<?php
require_once ('vendor/autoload.php');
use Alsalty\Argocd\Core\Auth;
use Alsalty\Argocd\Core\Managers\ApplicationsManager;
use Alsalty\Argocd\Core\Managers\ClustersManager;


try {
    $auth = new Auth("https://localhost","admin","password");
    $auth->authenticate();

    $clustersManager = new ClustersManager($auth);
    $clusterNames = $clustersManager->getClustersNames();
    foreach ($clusterNames as $name) {
        echo "Cluster Name: " . $name . PHP_EOL;
    }

    $applicationsManager = new ApplicationsManager($auth);
    $applicationsManager->setProjects(['ti-api']);
    $applicationsManager->setAppNamespace('argocd');
    $applicationNames = $applicationsManager->getApplicationsNames();
    foreach ($applicationNames as $name) {
        echo "Application Name: " . $name . PHP_EOL;
    }

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}