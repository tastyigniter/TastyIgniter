# Glide

[![Latest Version](https://img.shields.io/github/release/thephpleague/glide.svg?style=flat-square)](https://github.com/thephpleague/glide/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/thephpleague/glide/blob/master/LICENSE)
[![Build Status](https://img.shields.io/github/actions/workflow/status/thephpleague/glide/test.yaml?style=flat-square&branch=master)](https://github.com/thephpleague/glide/actions/workflows/test.yaml?query=branch%3Amaster++)
[![Code Coverage](https://img.shields.io/codecov/c/github/thephpleague/glide/master?style=flat-square)](https://app.codecov.io/gh/thephpleague/glide/)
[![Total Downloads](https://img.shields.io/packagist/dt/league/glide.svg?style=flat-square)](https://packagist.org/packages/league/glide)
[![Source Code](http://img.shields.io/badge/source-thephpleague/glide-blue.svg?style=flat-square)](https://github.com/thephpleague/glide)
[![Author](http://img.shields.io/badge/author-@reinink-blue.svg?style=flat-square)](https://twitter.com/reinink)
[![Author](http://img.shields.io/badge/author-@titouangalopin-blue.svg?style=flat-square)](https://twitter.com/titouangalopin)

Glide is a wonderfully easy on-demand image manipulation library written in PHP. Its straightforward API is exposed via HTTP, similar to cloud image processing services like [Imgix](http://www.imgix.com/) and [Cloudinary](http://cloudinary.com/). Glide leverages powerful libraries like [Intervention Image](http://image.intervention.io/) (for image handling and manipulation) and [Flysystem](http://flysystem.thephpleague.com/) (for file system abstraction).

[![© Photo Joel Reynolds](https://glide.herokuapp.com/1.0/kayaks.jpg?w=1000)](https://glide.herokuapp.com/1.0/kayaks.jpg?w=1000)
> © Photo Joel Reynolds

## Highlights

- Adjust, resize and add effects to images using a simple HTTP based API.
- Manipulated images are automatically cached and served with far-future expires headers.
- Create your own image processing server or integrate Glide directly into your app.
- Supports both the [GD](http://php.net/manual/en/book.image.php) library and the [Imagick](http://php.net/manual/en/book.imagick.php) PHP extension.
- Supports many response methods, including PSR-7, HttpFoundation and more.
- Ability to secure image URLs using HTTP signatures.
- Works with many different file systems, thanks to the [Flysystem](http://flysystem.thephpleague.com/) library.
- Powered by the battle tested [Intervention Image](http://image.intervention.io/) image handling and manipulation library.
- Framework-agnostic, will work with any project.
- Composer ready and PSR-2 compliant.

## Documentation

Full documentation can be found at [glide.thephpleague.com](http://glide.thephpleague.com).

## Installation

Glide is available via Composer:

```bash
$ composer require league/glide
```

## Testing

Glide has a [PHPUnit](https://phpunit.de/) test suite. To run the tests, run the following command from the project folder:

```bash
$ phpunit
```
## Contributing

Contributions are welcome and will be fully credited. Please see [CONTRIBUTING](https://github.com/thephpleague/glide/blob/master/CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email jonathan@reinink.ca instead of using the issue tracker.

## Credits

- [Jonathan Reinink](https://github.com/reinink)
- [All Contributors](https://github.com/thephpleague/glide/contributors)

## License

The MIT License (MIT). Please see [LICENSE](https://github.com/thephpleague/glide/blob/master/LICENSE) for more information.
