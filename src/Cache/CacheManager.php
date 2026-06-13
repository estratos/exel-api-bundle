<?php

declare(strict_types=1);

namespace Exel\ApiBundle\Cache;

use Symfony\Contracts\Cache\CacheInterface;

final class CacheManager
{
    public function __construct(
        private CacheInterface $cache,
        private int $ttl = 3600
    ) {
    }

    public function get(string $key, callable $callback): mixed
    {
        return $this->cache->get($key, $callback, $this->ttl);
    }

    public function delete(string $key): bool
    {
        return $this->cache->delete($key);
    }

    public function clear(): bool
    {
        return $this->cache->clear();
    }
}
