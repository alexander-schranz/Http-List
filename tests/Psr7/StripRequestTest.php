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

namespace CmsIg\HttpList\Tests\Psr7;

use CmsIg\HttpList\Psr7\StripRequest;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class StripRequestTest extends TestCase
{
    public function testStrip(): void
    {
        $request = (new ServerRequest('GET', '/?page=2&utm_source=x', ['Cookie' => '_ga=1; PHPSESSID=abc']))
            ->withQueryParams(['page' => '2', 'utm_source' => 'x'])
            ->withCookieParams(['_ga' => '1', 'PHPSESSID' => 'abc']);

        $stripped = StripRequest::strip($request);

        $this->assertSame(['page' => '2'], $stripped->getQueryParams());
        $this->assertSame('page=2', $stripped->getUri()->getQuery());
        $this->assertSame(['PHPSESSID' => 'abc'], $stripped->getCookieParams());
        $this->assertSame('PHPSESSID=abc', $stripped->getHeaderLine('Cookie'));
        $this->assertSame('page=2&utm_source=x', $request->getUri()->getQuery(), 'original is untouched');
    }
}
