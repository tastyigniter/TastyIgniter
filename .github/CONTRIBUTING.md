# Contributing to TastyIgniter

TastyIgniter is a community driven project and accepts contributions of code and documentation from the community. These contributions are made in the form of Issues or [Pull Requests](http://help.github.com/send-pull-requests/) on the [TastyIgniter repository](https://github.com/tastyigniter/TastyIgniter>) on GitHub.

## Reporting a bug

Issues are a quick way to point out a bug. If you find a bug in TastyIgniter then please check a few things first:

1. Search the TastyIgniter forum, ask the community if they have seen the bug or know how to fix it.
2. There is not already an open Issue
3. The issue has already been fixed (check the develop branch, or look for closed Issues)
4. Is it something really obvious that you can fix yourself?

We work hard to process bugs that are reported, to assist with this please ensure the following details are always included:
- Bug summary: Make sure your summary reflects what the problem is and where it is.
- Reproduce steps: Clearly mention the steps to reproduce the bug.
- Version number: The TastyIgniter version affected.
- Expected behavior: How TastyIgniter should behave on above mentioned steps.
- Actual behavior: What is the actual result on running above steps i.e. the bug behavior - include any error messages.

Please be very clear on your commit messages and pull request, empty pull request messages may be rejected without reason.

### Reporting security issues

If you wish to contact us about any security vulnerability in TastyIgniter you may find, please send an e-mail to Samuel Adepoyigi at sam@sampoyigi.com

## Branching

TastyIgniter uses the [Git-Flow](http://nvie.com/posts/a-successful-git-branching-model/) branching model which requires all pull requests to be sent to the "develop" branch. This is where the next planned version will be developed. The "master" branch will always contain the latest stable version and is kept clean so a "hotfix" (e.g: an emergency security patch) can be applied to master to create a new version, without worrying about other features holding it up. For this reason all commits need to be made to "develop" and any sent to "master" will be closed automatically.

## Pull Requests

Your contributions to the TastyIgniter project are very welcome. If you would like to fix a bug or propose a new feature, you can submit a Pull Request.

To help us merge your Pull Request, please make sure you follow these points:

1. Describe the problem clearly in the Pull Request description
2. Please make your fix on the develop branch. As explained above.
3. For any change that you make, please try to also add a test case(s) in the tests/unit directory. This helps us understand the issue and make sure that it will stay fixed forever.

If you change anything that requires a change to documentation then you will need to add it. New classes, methods, parameters, changing default values, etc are all things that will require a change to documentation. The change-log must also be updated for every change. Also PHPDoc blocks must be maintained.

All code must meet the PSR Coding standards. This makes certain that all code follow the same format as the existing code and means it will be as readable as possible.

- [PSR 2 Coding Style Guide](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)
- [PSR 1 Coding Style Guide](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md)
- [PSR 0 Coding Style Guide](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)

### How to contribute

**DO NOT** use GitHub in-line editing to make changes as this could introduce syntax errors, etc, please "clone" instead.

First, you will need to [create a GitHub account](https://github.com/signup/free), if you don't already have one.

1. Set up Git (Windows, Mac & Linux)
2. Go to the TastyIgniter repo
3. Fork it
4. Clone your TastyIgniter repo: `git@github.com:<your-name>/TastyIgniter.git`
5. Checkout the "develop" branch At this point you are ready to start making changes. 
6. Fix existing bugs on the Issue tracker after taking a look to see nobody else is working on them.
7. Commit the files
8. Push your develop branch to your fork
9. Send a pull request [http://help.github.com/send-pull-requests/](http://help.github.com/send-pull-requests/)

If your change fails to meet the guidelines, feedback will be provided to help you improve it.

If not it will be merged into develop and your patch will be part of the next release.

##### Thanks for contributing.

### Keeping your fork up-to-date

If you are using command-line you can do the following:

1. `git remote add tastyigniter git://github.com/tastyigniter/TastyIgniter.git`
2. `git pull tastyigniter develop`
3. `git push origin develop`

Now your fork is up to date. This should be done regularly, or before you send a pull request at least.