# Contributing to TastyIgniter

TastyIgniter is a community driven project and accepts contributions of code and documentation from the community. These contributions are made in the form of Issues or [Pull Requests](http://help.github.com/send-pull-requests/) on the [TastyIgniter repository](https://github.com/tastyigniter/TastyIgniter>) on GitHub.

## Reporting a bug

Issues are a quick way to point out a bug. If you find a bug in TastyIgniter then please check a few things first:

1. Search the TastyIgniter forum, ask the community if they have seen the bug or know how to fix it.
2. There is not already an open Issue
3. The issue has already been fixed (check the develop branch, or look for closed Issues)
4. Is it something really obvious that you can fix yourself?

Reporting issues is helpful but an even better approach is to send a Pull Request, which is done by "Forking" the main repository and committing to your own copy. This will require you to use the version control system called Git.

Please be very clear on your commit messages and pull request, empty pull request messages may be rejected without reason.

All code must meet the [TastyIgniter coding standards](). This makes certain that all code follow the same format as the existing code and means it will be as readable as possible.

If you change anything that requires a change to documentation then you will need to add it. New classes, methods, parameters, changing default values, etc are all things that will require a change to documentation. The change-log must also be updated for every change. Also PHPDoc blocks must be maintained.

### Branching

TastyIgniter uses the [Git-Flow](http://nvie.com/posts/a-successful-git-branching-model/) branching model which requires all pull requests to be sent to the "develop" branch. This is where the next planned version will be developed. The "master" branch will always contain the latest stable version and is kept clean so a "hotfix" (e.g: an emergency security patch) can be applied to master to create a new version, without worrying about other features holding it up. For this reason all commits need to be made to "develop" and any sent to "master" will be closed automatically. If you have multiple changes to submit, please place all changes into their own branch on your fork.

## How to contribute

There are two ways to make changes, the easy way and the hard way. Either way you will need to [create a GitHub account](https://github.com/signup/free).

Easy way GitHub allows in-line editing of files for making simple typo changes and quick-fixes. This is not the best way as you are unable to test the code works. If you do this you could be introducing syntax errors, etc, but for a Git-phobic user this is good for a quick-fix.

Hard way The best way to contribute is to "clone" your fork of TastyIgniter to your development area. That sounds like some jargon, but "forking" on GitHub means "making a copy of that repo to your account" and "cloning" means "copying that code to your environment so you can work on it".

1. Set up Git (Windows, Mac & Linux)
2. Go to the TastyIgniter repo
3. Fork it
4. Clone your TastyIgniter repo: git@github.com:<your-name>/TastyIgniter.git
5. Checkout the "develop" branch At this point you are ready to start making changes. 
6. Fix existing bugs on the Issue tracker after taking a look to see nobody else is working on them.
7. Commit the files
8. Push your develop branch to your fork
9. Send a pull request [http://help.github.com/send-pull-requests/](http://help.github.com/send-pull-requests/)

If your change fails to meet the guidelines it will be bounced, or feedback will be provided to help you improve it.

If not it will be merged into develop and your patch will be part of the next release.

### Keeping your fork up-to-date

Unlike systems like Subversion, Git can have multiple remotes. A remote is the name for a URL of a Git repository. By default your fork will have a remote named "origin" which points to your fork, but you can add another remote named "tastyigniter" which points to `git://github.com/tastyigniter/TastyIgniter.git`. This is a read-only remote but you can pull from this develop branch to update your own.

If you are using command-line you can do the following:

1. `git remote add tastyigniter git://github.com/tastyigniter/TastyIgniter.git`
2. `git pull tastyigniter develop`
3. `git push origin develop`

Now your fork is up to date. This should be done regularly, or before you send a pull request at least.