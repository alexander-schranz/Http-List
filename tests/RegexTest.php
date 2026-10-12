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
        $this->assertTrue(Cookies::matches('_ga'));
        $this->assertTrue(Cookies::matches('_ga_ABC123'));
        $this->assertTrue(Cookies::matches('_dc_gtm_UA-1'));
        $this->assertFalse(Cookies::matches('PHPSESSID'));
        $this->assertFalse(Cookies::matches('x_ga'));
        $this->assertFalse(Cookies::matches('_dc_gtm_'));
    }

    public function testQueries(): void
    {
        $this->assertTrue(Queries::matches('utm_source'));
        $this->assertTrue(Queries::matches('gclid'));
        $this->assertFalse(Queries::matches('page'));
        $this->assertFalse(Queries::matches('utm_source_x'));
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
