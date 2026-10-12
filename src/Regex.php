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

namespace CmsIg\HttpList;

/**
 * @internal
 */
final class Regex
{
    /**
     * Combines regex fragments into one anchored regex: a single big regex is faster than many small ones.
     *
     * @param string[] $fragments
     */
    public static function combine(array $fragments): string
    {
        return '~^(?:' . \implode('|', \str_replace('~', '\~', $fragments)) . ')$~';
    }
}
