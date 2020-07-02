<?php
/**
 * routee auth config, maybe yaml file
 */

return [
    'applicationId' => '57cd83a3e4b0464b9119ba46',
    'secret' => 'OXr7WYcP9A',
    'url' => 'https://auth.routee.net/oauth/token',
    'headers' => [
        'Content-Type: application/x-www-form-urlencoded',
    ],
    'post' => [
        'grant_type' => 'client_credentials',
    ],
];