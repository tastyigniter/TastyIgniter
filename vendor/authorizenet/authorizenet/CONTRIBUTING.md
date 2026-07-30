Thanks for contributing to the Authorize.Net PHP SDK.

Before you submit a pull request, we ask that you consider the following:

- Submit an issue to state the problem your pull request solves or the funtionality that it adds. We can then advise on the feasability of the pull request, and let you know if there are other possible solutions.
- Part of the SDK is auto-generated based on the XML schema. Due to this auto-generation, we cannot merge contributions for request or response classes. You are welcome to open an issue to report problems or suggest improvements. Auto-generated classes include all files inside [contract/v1](https://github.com/AuthorizeNet/sdk-php/tree/master/lib/net/authorize/api/contract/v1)  and [controller](https://github.com/AuthorizeNet/sdk-php/tree/master/lib/net/authorize/api/controller) folders, except [controller/base](https://github.com/AuthorizeNet/sdk-php/tree/master/lib/net/authorize/api/controller/base).
- Files marked as deprecated are no longer supported. Issues and pull requests for changes to these deprecated files will be closed.
- Recent changes will be in future branch. Check the code in *future* branch first to see if a fix has already been merged, before suggesting changes to a file.
- **Always create pull request to the future branch.** The pull request will be merged to future, and later pushed to master as part of the next release.
