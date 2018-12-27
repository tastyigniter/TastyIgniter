TastyIgniter :fire:
============

[![Packagist](https://img.shields.io/packagist/v/tastyigniter/TastyIgniter.svg?label=Packagist&style=flat-square)](https://packagist.org/packages/tastyigniter/TastyIgniter)
[![Build Status](https://img.shields.io/travis/tastyigniter/TastyIgniter.svg?label=TravisCI&style=flat-square)](https://travis-ci.org/tastyigniter/TastyIgniter)
[![License](https://img.shields.io/packagist/l/tastyigniter/TastyIgniter.svg?label=License&style=flat-square)](https://github.com/tastyigniter/TastyIgniter/blob/master/LICENSE)

[TastyIgniter](https://tastyigniter.com/) is a free open source restaurant ordering and management system. TastyIgniter provides a professional and reliable platform for restaurants wanting to offer online ordering to their customers.

## Installation
> **TastyIgniter v3 (uses [Laravel](https://laravel.com/) PHP framework) is currently in beta and should not be used in production.** Join the [Dev Team](http://slack.tastyigniter.com/) to follow along with our progress. See branch [2.1.x](https://github.com/tastyigniter/TastyIgniter/tree/2.1.x) for a stable version.

### Wizard Installation
1. Download and unzip the [setup archive file](https://github.com/tastyigniter/setup/archive/master.zip) into an empty directory on your server.
2. Create a MySQL user database for TastyIgniter.
3. Extract and upload the setup archive contents to your server. Normally the setup.php file will be at your root.
4. Grant write permissions on the setup directory, its subdirectories and files.
4. Run the TastyIgniter setup script by accessing setup.php in your web browser. Example, http://example.com/setup.php or http://example.com/folder/setup.php
5. Follow all onscreen instructions and make sure all installation requirements are checked.

### Manual Installation

```
composer create-project tastyigniter/tastyigniter .
```

After running the above command, run the install command

```
php artisan igniter:install
```

The install command will guide you through the process of setting up TastyIgniter for the first time. 
It will ask for the database configuration, application URL and administrator details.

Read the [Installation Guide](https://docs.tastyigniter.com/installation) for more information.

## Community and Support
- Please report bugs using the [GitHub issue tracker](https://github.com/tastyigniter/TastyIgniter/issues), or better yet, fork the repo and submit a pull request.
- Visit the [Community Forum](https://forum.tastyigniter.com) or [Documentation](https://docs.tastyigniter.com) for support.
- [Follow us on Twitter](https://twitter.com/tastyigniter/) for announcements and updates.
- [Join us on Slack](http://slack.tastyigniter.com/) to chat with us.

## Contributing
TastyIgniter is open-source and we would love your help building it! Please read the [Contributing Guidelines](CONTRIBUTING.md) to learn how you can help.

## Credits
- Laravel - Open source full-stack framework.
- october/rain - OctoberCMS foundation library
- Bootstrap 4 - Open source front end framework.
- [Samuel Adepoyigi](https://github.com/sampoyigi)
- [All Contributors](https://github.com/tastyigniter/TastyIgniter/contributors)

## License
Starting with version 3.0.0 TastyIgniter is licensed under the [The MIT License (MIT)](https://tastyigniter.com/licence/). Older versions were GPL-licensed.

