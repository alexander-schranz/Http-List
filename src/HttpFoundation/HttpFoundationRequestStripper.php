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

namespace CmsIg\HttpList\HttpFoundation;

use CmsIg\HttpList\Cookies;
use CmsIg\HttpList\Queries;
use Symfony\Component\HttpFoundation\Request;

/**
 * Removes irrelevant cookies and query parameters from a Symfony request.
 */
final class HttpFoundationRequestStripper
{
    public static function strip(Request $request): void
    {
        self::stripCookies($request);
        self::stripQueries($request);
    }

    public static function stripCookies(Request $request): void
    {
        $cookies = $request->cookies->all();
        $remaining = \array_diff_key($cookies, \array_flip(Cookies::matches(\array_keys($cookies))));

        if (\count($remaining) === \count($cookies)) {
            return;
        }

        $request->cookies->replace($remaining);

        $pairs = [];
        foreach ($remaining as $name => $value) {
            if (\is_scalar($value)) {
                $pairs[] = \rawurlencode((string) $name) . '=' . \rawurlencode((string) $value);
            }
        }

        if ([] === $pairs) {
            $request->headers->remove('Cookie');
        } else {
            $request->headers->set('Cookie', \implode('; ', $pairs));
        }
    }

    public static function stripQueries(Request $request): void
    {
        $queries = $request->query->all();
        $remaining = \array_diff_key($queries, \array_flip(Queries::matches(\array_keys($queries))));

        if (\count($remaining) === \count($queries)) {
            return;
        }

        $request->query->replace($remaining);
        $request->server->set('QUERY_STRING', \http_build_query($remaining, '', '&', \PHP_QUERY_RFC3986));
    }
}
