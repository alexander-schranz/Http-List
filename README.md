# Http List

Lists of cookies and query parameters (analytics, ads, consent, profilers) that are irrelevant for the response,
for better caching and canonical URL handling.

## Installation

```bash
composer require cmsig/http-list
```

## Usage

Every entry is a regex fragment (no delimiters, no anchors), e.g. `_ga.*`.

```php
use CmsIg\HttpList\Cookies;
use CmsIg\HttpList\Queries;

Cookies::getCookies();      // string[] of regex fragments
Cookies::getCookiesRegex(); // one anchored regex: ~^(?:_ga.*|_gid|...)$~
Cookies::matches('_ga_ABC123'); // true

Queries::getQueries();
Queries::getQueriesRegex();
Queries::matches('utm_source'); // true
```

### Symfony HttpFoundation

Requires `symfony/http-foundation`. Strips in place, including the `Cookie` header and `QUERY_STRING`:

```php
use CmsIg\HttpList\HttpFoundation\StripRequest;

StripRequest::strip($request); // or stripCookies() / stripQueries()
```

### PSR-7

Requires `psr/http-message`. Returns a new request:

```php
use CmsIg\HttpList\Psr7\StripRequest;

$request = StripRequest::strip($request); // or stripCookies() / stripQueries()
```
