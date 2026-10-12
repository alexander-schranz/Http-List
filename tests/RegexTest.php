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

namespace CmsIg\HttpList\Tests;

use CmsIg\HttpList\Cookies;
use CmsIg\HttpList\Queries;
use PHPUnit\Framework\TestCase;

class RegexTest extends TestCase
{
    public function testCookies(): void
    {
        $this->assertSame(
            ['_ga', '_ga_ABC123', '_dc_gtm_UA-1', '_GA_ABC123', 'cookieconsent_STATUS'],
            Cookies::matches(['_ga', '_ga_ABC123', '_dc_gtm_UA-1', '_GA_ABC123', 'cookieconsent_STATUS', 'PHPSESSID', 'x_ga', '_dc_gtm_']),
        );
    }

    public function testQueries(): void
    {
        $this->assertSame(
            ['utm_source', 'gclid', 'li_fat_id', 'etcc_med', 'UTM_Source', 'utm_anything_else', 'mc_foo', '_bta_tid'],
            Queries::matches(['utm_source', 'gclid', 'li_fat_id', 'etcc_med', 'UTM_Source', 'utm_anything_else', 'mc_foo', '_bta_tid', 'page', 'utm']),
        );
    }

    public function testFindMatchesKeepsKeys(): void
    {
        $this->assertSame(
            [1 => 'utm_source', 3 => 'gclid'],
            Queries::matches(['page', 'utm_source', 'sort', 'gclid']),
        );
        $this->assertSame([], Queries::matches(['page']));
        $this->assertSame([], Queries::matches([]));
        $this->assertSame([0 => '_ga'], Cookies::matches(['_ga', 'PHPSESSID']));
    }

    public function testAllFragmentsAreValidRegexes(): void
    {
        foreach ([Cookies::getCookies(), Queries::getQueries()] as $list) {
            foreach ($list as $fragment) {
                $this->assertNotFalse(@\preg_match('~^(?:' . \str_replace('~', '\~', $fragment) . ')$~', ''), $fragment);
            }
        }
    }
}
