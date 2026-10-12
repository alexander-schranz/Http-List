# Http List

Lists of cookies and query parameters (analytics, ads, consent, profilers) that are irrelevant for the response,
for better caching and canonical URL handling.

## Installation

```bash
composer require cmsig/http-list
```

## Usage

Every entry is a regex fragment (no delimiters, no anchors), e.g. `_ga.*`. Matching is anchored and case-insensitive.

```php
use CmsIg\HttpList\Cookies;
use CmsIg\HttpList\Queries;

Cookies::getCookies();      // string[] of regex fragments
Cookies::getCookiesRegex(); // one anchored regex: ~^(?:_ga.*|_gid|...)$~i
Cookies::matches(['_ga_ABC123', 'PHPSESSID']); // [0 => '_ga_ABC123']

Queries::getQueries();
Queries::getQueriesRegex();
Queries::matches(['page', 'utm_source']); // [1 => 'utm_source']
```

### Symfony HttpFoundation

Requires `symfony/http-foundation`. Strips in place, including the `Cookie` header and `QUERY_STRING`:

```php
use CmsIg\HttpList\HttpFoundation\HttpFoundationRequestStripper;

HttpFoundationRequestStripper::strip($request); // or stripCookies() / stripQueries()
```

### PSR-7

Requires `psr/http-message`. Returns a new request:

```php
use CmsIg\HttpList\Psr7\Psr7RequestStripper;

$request = Psr7RequestStripper::strip($request); // or stripCookies() / stripQueries()
```
