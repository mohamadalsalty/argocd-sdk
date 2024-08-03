# Argo CD PHP SDK Library

This PHP SDK library provides an easy way to interact with Argo CD's API, allowing you to manage applications, clusters, and more.

## Features

- Authenticate with Argo CD API using username and password
- Manage applications with project and namespace filters
- Fetch information and names of applications

## Installation

### Using Composer

You can install the library via Composer. Run the following command in your terminal:

```bash
composer require alsalty/argocd
```

## Usage

### Basic Example

```php
require 'vendor/autoload.php';

use Alsalty\Argocd\Core\Auth;
use Alsalty\Argocd\Core\Managers\ApplicationsManager;

try {
    // Set your Argo CD API credentials
    $apiUrl = 'https://your-argocd-api-url';
    $username = 'your-username';
    $password = 'your-password';

    // Create an Auth instance and authenticate
    $auth = new Auth($apiUrl, $username, $password);
    $auth->authenticate();

    // Create an ApplicationsManager instance
    $appManager = new ApplicationsManager($auth);

    // Set projects and namespace filters
    $appManager->setProjects(['project1', 'project2']);
    $appManager->setAppNamespace('namespace1');

    // Fetch and print application names
    $applicationNames = $appManager->getApplicationsNames();
    print_r($applicationNames);

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
```

### Filtering Applications

You can filter applications by projects and namespaces:

- **Projects**: Set multiple projects to filter applications by those projects.
- **Namespace**: Set a namespace to filter applications by a specific namespace.

```php
$appManager->setProjects(['project1', 'project2']);
$appManager->setAppNamespace('namespace1');
```

## Configuration

You can configure the following parameters:

- **API URL**: The URL of your Argo CD API server.
- **Username**: Your Argo CD username.
- **Password**: Your Argo CD password.

## Development

### Structure

- **src/Core**: Contains core classes such as `Auth` and managers.
- **src/Helpers**: Contains helper classes like `Curl`.
- **tests**: Contains test cases.


## Contributing

Contributions are welcome!

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
