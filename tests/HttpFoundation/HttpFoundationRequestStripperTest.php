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

namespace CmsIg\HttpList\Tests\HttpFoundation;

use CmsIg\HttpList\HttpFoundation\HttpFoundationRequestStripper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class HttpFoundationRequestStripperTest extends TestCase
{
    public function testStrip(): void
    {
        $request = Request::create('/?page=2&utm_source=x&gclid=1', 'GET', [], ['_ga' => '1', 'PHPSESSID' => 'abc']);
        $request->headers->set('Cookie', '_ga=1; PHPSESSID=abc');

        HttpFoundationRequestStripper::strip($request);

        $this->assertSame(['page' => '2'], $request->query->all());
        $this->assertSame('page=2', $request->getQueryString());
        $this->assertSame(['PHPSESSID' => 'abc'], $request->cookies->all());
        $this->assertSame('PHPSESSID=abc', $request->headers->get('Cookie'));
    }

    public function testStripAllCookies(): void
    {
        $request = Request::create('/', 'GET', [], ['_ga' => '1']);
        $request->headers->set('Cookie', '_ga=1');

        HttpFoundationRequestStripper::strip($request);

        $this->assertFalse($request->headers->has('Cookie'));
    }

    public function testNumericNames(): void
    {
        $request = Request::create('/?123=a&utm_source=x', 'GET', [], ['456' => 'b', '_ga' => '1']);

        HttpFoundationRequestStripper::strip($request);

        $this->assertCount(1, $request->query);
        $this->assertSame('a', $request->query->get('123'));
        $this->assertCount(1, $request->cookies);
        $this->assertSame('b', $request->cookies->get('456'));
    }
}
