<?php
$httpClient = new \SocialConnect\HttpClient\Cache(
    $httpClient,
    /**
     * You can use any library with PSR-16 (simple-cache) compatibility
     */
    new \Symfony\Component\Cache\Psr16Cache(
        new \Symfony\Component\Cache\Adapter\PhpFilesAdapter(
            'socialconnect',
            0,
            __DIR__ . '/cache'
        )
    )
);

$httpStack = new \SocialConnect\Provider\HttpStack(
    $httpClient,
    new \SocialConnect\HttpClient\RequestFactory(),
    new \SocialConnect\HttpClient\StreamFactory()
);

$configureProviders = [
    'redirectUri' => 'http://sconnect.local/auth/cb/${provider}/',
    'provider' => [
        'facebook' => [
            'applicationId' => '',
            'applicationSecret' => '',
            'scope' => ['email'],
            'options' => [
                'identity.fields' => [
                    'email',
                    'picture.width(99999)'
                ],
            ],
        ],
    ],
];

$service = new \SocialConnect\Auth\Service(
    $httpStack,
    new \SocialConnect\Provider\Session\Session(),
    $configureProviders,
    $collectionFactory
);

/**
 * By default collection factory is null, in this case Auth\Service will create 
 * a new instance of \SocialConnect\Auth\CollectionFactory
 * you can use custom or register another providers by CollectionFactory instance
 */
$collectionFactory = null;

$service = new \SocialConnect\Auth\Service(
    $httpClient,
    new \SocialConnect\Provider\Session\Session(),
    $configureProviders,
    $collectionFactory
);
