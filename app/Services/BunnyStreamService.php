<?php

namespace App\Services;

class BunnyStreamService
{
    public function __construct(
        protected string $libraryId,
        protected string $signingKey,
        protected string $iframeHost = 'https://iframe.mediadelivery.net',
        protected ?string $hlsHost = null,
        protected int $ttl = 300,
        protected bool $bindIp = false,
    ) {}

    public static function fromConfig(): self
    {
        $cfg = config('video.bunny');
        return new self(
            $cfg['library_id'] ?? '',
            $cfg['signing_key'] ?? '',
            $cfg['iframe_host'] ?? 'https://iframe.mediadelivery.net',
            $cfg['hls_host'] ?? null,
            (int) ($cfg['token_ttl'] ?? 300),
            (bool) ($cfg['bind_ip'] ?? false),
        );
    }

    /**
     * Generate a signed token per Bunny docs (simple HMAC SHA256 on path + expiry + optional IP)
     * Docs: https://docs.bunny.net/docs/stream-security-hotlinking-protection
     */
    protected function sign(string $path, int $expires, ?string $ip = null): string
    {
        $base = $path . $expires . ($ip ? $ip : '');
        $hash = hash_hmac('sha256', $base, $this->signingKey, true);
        return rtrim(strtr(base64_encode($hash), '+/', '-_'), '=');
    }

    public function iframeUrl(string $videoGuid, ?string $clientIp = null): string
    {
        $expires = time() + $this->ttl;
        // Bunny iframe requires the '/play' segment in the path
        $path = sprintf('/play/%s/%s', $this->libraryId, $videoGuid);
        $token = $this->sign($path, $expires, $this->bindIp ? $clientIp : null);
        return sprintf('%s%s?token=%s&expires=%d', $this->iframeHost, $path, $token, $expires);
    }

    public function hlsUrl(string $videoGuid, ?string $clientIp = null): ?string
    {
        if (!$this->hlsHost) return null;
        $expires = time() + $this->ttl;
        $path = sprintf('/%s/%s/playlist.m3u8', $this->libraryId, $videoGuid);
        $token = $this->sign($path, $expires, $this->bindIp ? $clientIp : null);
        return sprintf('%s%s?token=%s&expires=%d', rtrim($this->hlsHost, '/'), $path, $token, $expires);
    }
}
