## Submitting issues

This is quite a popular project, but it's not my job, so please read the below before posting an issue. Thank you!

- If you have high-level implementation questions about your project ("How do I add this to WordPress", "I've got a form that takes an email address...") you're best to ask somewhere like StackOverflow.
- If you have purchased a commercial product or template that uses this code and now have a problem, *I'm not going to help you with it, sorry.* Talk to the person who took your money. None of it came to me. :smile:
- If your question is about the MailChimp API itself, please check out the [MailChimp Guides](http://developer.mailchimp.com/documentation/mailchimp/guides/). This project doesn't handle any of that logic - we're just helping you form the requests.

If, however, you think you've found a bug, or would like to discuss a change or improvement, feel free to raise an issue and we'll figure it out between us.

## Pull requests

This is a fairly simple wrapper, but it has been made much better by contributions from those using it. If you'd like to suggest an improvement, please raise an issue to discuss it before making your pull request.

Pull requests for bugs are more than welcome - please explain the bug you're trying to fix in the message.

There are a small number of PHPUnit unit tests. To get up and running, copy `.env.example` to `.env` and add your API key details. Unit testing against an API is obviously a bit tricky, but I'd welcome any contributions to this. It would be great to have more test coverage.