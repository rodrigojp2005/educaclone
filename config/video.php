<?php

return [
    'default' => env('VIDEO_PROVIDER', 'bunny'),

    'cloudflare' => [
        'account_id' => env('CF_STREAM_ACCOUNT_ID'),
        'key_id' => env('CF_STREAM_SIGNING_KEY_ID'),
        'private_key' => env('CF_STREAM_SIGNING_PRIVATE_KEY'), // PEM content or path
        'embed_domain' => env('APP_URL'),
        // token TTL in seconds
        'token_ttl' => env('CF_STREAM_TOKEN_TTL', 300),
    ],

    'bunny' => [
        // Video Library settings
        'library_id' => env('BUNNY_STREAM_LIBRARY_ID'),
        'signing_key' => env('BUNNY_STREAM_SIGNING_KEY'), // Token Authentication Key
        // Hosts
        'iframe_host' => env('BUNNY_STREAM_IFRAME_HOST', 'https://iframe.mediadelivery.net'),
        // HLS direct host (optional): e.g. https://vz-XXXX.b-cdn.net
        'hls_host' => env('BUNNY_STREAM_HLS_HOST'),
        // TTL for signed URLs (seconds)
        'token_ttl' => env('BUNNY_STREAM_TOKEN_TTL', 300),
        // Optionally bind token to IP
        'bind_ip' => env('BUNNY_STREAM_BIND_IP', false),
    ],
];
