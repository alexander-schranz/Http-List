<?php

declare(strict_types=1);

/*
 * This file is part of the CMS-IG HttpList project.
 *
 * (c) Alexander Schranz <alexander@sulu.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CmsIg\HttpList\Psr7;

use CmsIg\HttpList\Cookies;
use CmsIg\HttpList\Queries;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Removes irrelevant cookies and query parameters from a PSR-7 server request.
 */
final class StripRequest
{
    public static function strip(ServerRequestInterface $request): ServerRequestInterface
    {
        return self::stripQueries(self::stripCookies($request));
    }

    public static function stripCookies(ServerRequestInterface $request): ServerRequestInterface
    {
        $cookies = $request->getCookieParams();
        $remaining = \array_filter($cookies, static fn ($name): bool => !Cookies::matches((string) $name), \ARRAY_FILTER_USE_KEY);

        if (\count($remaining) === \count($cookies)) {
            return $request;
        }

        $pairs = [];
        foreach ($remaining as $name => $value) {
            if (\is_scalar($value)) {
                $pairs[] = \rawurlencode((string) $name) . '=' . \rawurlencode((string) $value);
            }
        }

        $request = $request->withCookieParams($remaining);

        return [] === $pairs
            ? $request->withoutHeader('Cookie')
            : $request->withHeader('Cookie', \implode('; ', $pairs));
    }

    public static function stripQueries(ServerRequestInterface $request): ServerRequestInterface
    {
        $queries = $request->getQueryParams();
        $remaining = \array_filter($queries, static fn ($name): bool => !Queries::matches((string) $name), \ARRAY_FILTER_USE_KEY);

        if (\count($remaining) === \count($queries)) {
            return $request;
        }

        return $request
            ->withQueryParams($remaining)
            ->withUri($request->getUri()->withQuery(\http_build_query($remaining, '', '&', \PHP_QUERY_RFC3986)));
    }
}
