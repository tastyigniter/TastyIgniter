# Manage self-hosted Google Fonts in Laravel apps

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-google-fonts.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-google-fonts)
[![run-tests](https://github.com/spatie/laravel-google-fonts/actions/workflows/run-tests.yml/badge.svg)](https://github.com/spatie/laravel-google-fonts/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-google-fonts.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-google-fonts)

This package makes self-hosting Google Fonts as frictionless as possible for Laravel users.  To load fonts in your application, register a Google Fonts embed URL and load it with the `@googlefonts` Blade directive.

```php
// config/google-fonts.php

return [
    'fonts' => [
        'default' => 'https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,700;1,400;1,700&display=swap',
        'code' => 'https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:ital,wght@0,400;0,700;1,400&display=swap',
    ],
];
```

```blade
{{-- resources/views/layouts/app.blade.php --}}

<head>
    {{-- Loads Inter --}}
    @googlefonts

    {{-- Loads IBM Plex Mono --}}
    @googlefonts('code')
</head>
```

When fonts are requested the first time, this package will scrape the CSS, fetch the assets from Google's servers, store them locally, and render the CSS inline.

If anything goes wrong in this process, the package falls back to a `<link>` tag to load the fonts from Google.

## Why we created this package

Google Fonts hosts an impressive catalog of fonts, but relying on it has its costs. By hosting fonts on an external domain, browsers need to perform an additional DNS lookup. This slows down the initial page load. In addition, you're directing your visitors to Google property, which privacy-minded users might not appreciate.

You can download fonts from Google Fonts and self-host them, but it's more work than embedding a code. Keeping up with the latest font version can also be a chore.

This package makes self-hosting Google Fonts as frictionless as possible for Laravel users.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-google-fonts.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-google-fonts)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-google-fonts
```

You may optionally publish the config file:

```bash
php artisan vendor:publish --provider="Spatie\GoogleFonts\GoogleFontsServiceProvider" --tag="google-fonts-config"
```

Here's what the config file looks like:

```php
return [

    /*
     * Here you can register fonts to call from the @googlefonts Blade directive.
     * The google-fonts:fetch command will prefetch these fonts.
     */
    'fonts' => [
        'default' => 'https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,700;1,400;1,700',
    ],

    /*
     * This disk will be used to store local Google Fonts. The public disk
     * is the default because it can be served over HTTP with storage:link.
     */
    'disk' => 'public',

    /*
     * Prepend all files that are written to the selected disk with this path.
     * This allows separating the fonts from other data in the public disk.
     */
    'path' => 'fonts',

    /*
     * By default, CSS will be inlined to reduce the amount of round trips
     * browsers need to make in order to load the requested font files.
     */
    'inline' => true,

    /*
     * When preload is set to true, preload meta tags will be generated
     * in the HTML output to instruct the browser to start fetching the
     * font files as early as possible, even before the CSS is fully parsed.
     */
    'preload' => false,
    
    /*
     * When something goes wrong fonts are loaded directly from Google.
     * With fallback disabled, this package will throw an exception.
     */
    'fallback' => ! env('APP_DEBUG'),

    /*
     * This user agent will be used to request the stylesheet from Google Fonts.
     * This is the Safari 14 user agent that only targets modern browsers. If
     * you want to target older browsers, use different user agent string.
     */
    'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Safari/605.1.15',

];
```

## Usage

To add fonts to your application, grab an embed code from Google fonts, register it in the config and use the `@googlefonts` Blade directive.

```php
// config/google-fonts.php

return [
    'fonts' => [
        'default' => 'https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,700;1,400;1,700&display=swap',
        'code' => 'https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:ital,wght@0,400;0,700;1,400&display=swap',
    ],
];
```

```blade
{{-- resources/views/layouts/app.blade.php --}}

<head>
    {{-- Loads Inter --}}
    @googlefonts
    
    {{-- Loads IBM Plex Mono --}}
    @googlefonts('code')
</head>
```

This will inline the CSS, so the browser needs to do one less round-trip. If you prefer an external CSS file, you may disable the `inline` option in the package configuration.

Fonts are stored in a `fonts` folder on the `public` disk. You'll need to run `php artisan storage:link` to ensure the files can be served over HTTP. If you wish to store fonts in the git repository, make sure `storage/app/public` is not ignored.

If you want to serve fonts from a CDN, you may set up a different disk configuration.

## Prefetching fonts

If you want to make sure fonts are ready to go before anyone visits your site, you can prefetch them with this artisan command.

```bash
php artisan google-fonts:fetch
```

## Usage with spatie/laravel-csp

If you're using [spatie/laravel-csp](https://github.com/spatie/laravel-csp) to manage your Content Security Policy, you can pass an array to the blade directive and add the `nonce` option.

```blade
{{-- resources/views/layouts/app.blade.php --}}

<head>
    {{-- Loads Inter --}}
    @googlefonts(['nonce' => csp_nonce()])

    {{-- Loads IBM Plex Mono --}}
    @googlefonts(['font' => 'code', 'nonce' => csp_nonce()])
</head>
```

### Caveats for legacy browsers

Google Fonts' servers sniff the visitor's user agent header to determine which font format to serve. This means fonts work in all modern and legacy browsers.

This package isn't able to tailor to different user agents. With the default configuration, only browsers that can handle WOFF 2.0 font files are supported. At the time of writing, this is >95% of all users according to [caniuse](https://caniuse.com/woff2). Most notably, IE doesn't support WOFF 2.0.

If you need to serve fonts to a legacy browser, you may specify a different user agent string in the configuration. Keep in mind that makes the page load heavier for all visitors, including modern browsers.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Sebastian De Deyne](https://github.com/sebastiandedeyne)
- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
