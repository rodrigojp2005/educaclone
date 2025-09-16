<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class CloudflareStreamService
{
    public function __construct(
        protected string $accountId,
        protected string $keyId,
        protected string $privateKeyPem,
        protected int $ttl = 300,
    ) {}

    public static function fromConfig(): self
    {
        $cfg = config('video.cloudflare');
        return new self(
            $cfg['account_id'] ?? '',
            $cfg['key_id'] ?? '',
            self::resolvePrivateKey($cfg['private_key'] ?? ''),
            (int) ($cfg['token_ttl'] ?? 300),
        );
    }

    private static function resolvePrivateKey(string $value): string
    {
        // Support passing PEM content directly or a path to a PEM file
        if (str_starts_with($value, '-----BEGIN')) {
            return $value;
        }
        if ($value && is_file($value)) {
            return file_get_contents($value) ?: '';
        }
        return $value;
    }

    /**
     * Generate a signed token for a given video UID.
     * Docs: https://developers.cloudflare.com/stream/viewing-videos/securing-your-stream/ 
     */
    public function signPlaybackToken(string $videoUid, array $overrides = []): string
    {
        $now = time();
        $payload = array_merge([
            'sub' => $videoUid,       // video UID
            'kid' => $this->keyId,    // signing key id
            'exp' => $now + $this->ttl,
            'nbf' => $now,
            // optional constraints (ip, geo, etc.) can be added here
        ], $overrides);

        return JWT::encode($payload, $this->privateKeyPem, 'RS256');
    }

    /**
     * Build the HLS playback URL with signed token for the video.
     */
    public function hlsUrl(string $videoUid): string
    {
        $token = $this->signPlaybackToken($videoUid);
        return sprintf('https://videodelivery.net/%s/manifest/video.m3u8?token=%s', $videoUid, $token);
    }

    /**
     * Build the iframe embed URL with signed token.
     */
    public function iframeUrl(string $videoUid): string
    {
        $token = $this->signPlaybackToken($videoUid);
        return sprintf('https://iframe.videodelivery.net/%s?token=%s', $videoUid, $token);
    }
}
