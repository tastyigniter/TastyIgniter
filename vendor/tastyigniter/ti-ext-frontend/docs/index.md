---
title: "Frontend"
section: "extensions"
sortOrder: 50
---

## Installation

You can install the extension via composer using the following command:

```bash
composer require tastyigniter/ti-ext-frontend -W
```

Run the database migrations to create the required tables:
  
```bash
php artisan igniter:up
```

## Getting started

### Homepage Slider and Banners

From your TastyIgniter Admin, you can manage banners and images for the slider. Manage sliders on the _Design > Sliders & Banners_ page and banners on the _Design > Sliders & Banners > Banners_ page.

### reCaptcha

Navigate to the _Manage > Settings > reCaptcha Settings_ admin settings page to enter your `Site Key` and `Secret Key`. Selecting a
language is optional. Please follow the on-page instructions to get these keys.

### MailChimp

Navigate to the _Manage > Settings > MailChimp Settings_ admin settings page to enter your `API Key` and `List ID`. Please follow the on-page instructions to get these keys.

The Orange theme provides the following components to display:

- [Slider](https://tastyigniter.com/docs/themes/orange#slider)
- [Banner](https://tastyigniter.com/docs/themes/orange#banner-preview)
- [Newsletter Subscribe Form](https://tastyigniter.com/docs/themes/orange#newsletter-subscribe-form)
- [Contact Form](https://tastyigniter.com/docs/themes/orange#contact)
- [Captcha](https://tastyigniter.com/docs/themes/orange#captcha)

## Usage

This section covers how to integrate the Frontend extension API into your own extension if you need to create banners, sliders, subscribe to MailChimp, display reCaptcha, or send contact form emails. The Frontend extension provides a simple API for managing banners, sliders, and other front-end features.

### Banners

#### Creating banners

You can programmatically create a banner using the `Igniter\Frontend\Models\Banner` model:

```php
use Igniter\Frontend\Models\Banner;

$banner = Banners::create([
    'name' => 'Banner Name',
    'code' => 'unique-code',
    'type' => 'image',
    'image_code' => 'path/to/image.jpg',
    'click_url' => 'https://example.com',
    'language_id' => 1,
    'status' => true,
]);
```

The following attributes are available on the `Igniter\Frontend\Models\Banner` model:

- `name`: _(string)_ The name of the banner. **Required.**
- `code`: _(string)_ A unique code for the banner. **Required.**
- `language_id` _(integer)_: The language ID for the banner. **Required.**
- `status` _(boolean)_: Whether the banner is displayed. **Required.**
- `type`: _(string)_ The type of banner. **Required.** Available options are `image`, `custom`.
- `custom_code`: _(string)_ The HTML markup for a custom banner. **Required if type is `custom`.**
- `click_url`: _(string)_ The URL to redirect to when the image banner is clicked. **Required if type is `image`.**
- `alt_text` _(string)_: The alt text for the image banner. **Required if type is `image`.**
- `image_code` _(string)_: The path to the image file. **Required if type is `image`.**

#### Displaying banners

You can display banners on your front-end pages using the `Igniter\Frontend\Models\Banner` model to fetch the banner by code:

```php
use Igniter\Frontend\Models\Banner;

$banner = Banners::isEnabled()->whereCode('unique-code')->first();
```

You can then display the banner in your blade view file using the following code:

```blade
@if($banner->isCustom())
    {!! $banner->custom_code !!}
@elseif($banner->isImage())
    @foreach((array)$banner->image_code as $bannerUrl)
        <a href="{{ $banner->click_url }}">
            <img src="{{ media_thumb($bannerUrl, ['width' => 96, 'height' => 96]) }}" alt="{{ $banner->alt_text }}">
        </a>
    @endforeach
@endif
```

### Sliders

#### Creating sliders

You can programmatically create a slider using the `Igniter\Frontend\Models\Slider` model:

```php
use Igniter\Frontend\Models\Slider;

$slider = Slider::create([
    'name' => 'Slider Name',
    'code' => 'unique-code',
]);

$slideOne = $model->newMediaInstance();
$slideOne->addFromFile('path/to/file.jpg', 'images')

$slideTwo = $model->newMediaInstance();
$slideTwo->addFromFile('path/to/file-2.jpg', 'images')

$slider->media()->saveMany([$slide, $slideTwo]);
```

The following attributes are available on the `Igniter\Frontend\Models\Slider` model:

- `name`: _(string)_ The name of the slider. **Required.**
- `code`: _(string)_ A unique code for the slider. **Required.**
- `images`: _(Collection)_ An array of `Media` models for the slider.

#### Displaying sliders

You can display sliders on your front-end pages using the `Igniter\Frontend\Models\Slider` model to fetch the slider by code:

```php
use Igniter\Frontend\Models\Slider;

$slider = Slider::whereCode('unique-code')->first();
```

You can then display the slider in your blade view file using the following code:

```blade
@if($slider)
    <div class="slider">
        @foreach($slider->images as $slide)
            <img src="{{ $slide->getThumb() }}" alt="{{ $slide->getCustomProperty('title') }}">
        @endforeach
    </div>
@endif
```

### MailChimp

#### Subscribing to MailChimp

You can programmatically subscribe an email to a MailChimp list using the `Igniter\Frontend\Models\Subscribe` model:

```php
use Igniter\Frontend\Models\Subscribe;

$subscribe = Subscribe::firstOrCreate([
    'email' => 'email@example.com',
]);

$subscribe->subscribeToMailchimp($listId, $options);
```

### reCaptcha

#### Displaying reCaptcha

To display a reCaptcha on your front-end pages, you can use the `recaptcha` component in your theme:

```blade
@php
    $captchaSettings = \Igniter\Frontend\Models\CaptchaSettings::instance();
@endphp

<div class="g-recaptcha" data-sitekey="{{ $captchaSettings->api_site_key }}"></div>
<div class="text-danger">{{ $errors->first('g-recaptcha-response') }}</div>
<script
    type="text/javascript"
    src="https://www.google.com/recaptcha/api.js?hl={{ $captchaSettings->lang }}"
    async defer
></script>
```

#### Validating reCaptcha

You can validate a reCaptcha token using the `recaptcha` validation rule:

```php
$request->validate([
    'g-recaptcha-response' => ['required', 'recaptcha'],
]);
```

### Contact Form

#### Sending contact form emails

You can programmatically send a contact form email using the `Igniter\Frontend\Actions\SendContactMail` action:

```php
use Igniter\Frontend\Actions\SendContactMail;

(new SendContactMail())([
    'full_name' => 'John Doe',
    'contact_topic' => 'General Inquiry',
    'contact_email' => 'email@example.com',
    'contact_telephone' => '1234567890',
    'contact_message' => 'Hello, this is a test message.',
]);
```

### Mail templates

The Frontend extension registers the following mail templates:

- `igniter.frontend::mail.contact` - Contact form email template

You can send this email template using the [`SendContactMail` action](#sending-contact-form-emails).

### Permissions

The Frontend extension registers the following permissions:

- `Igniter.FrontEnd.ManageSettings`: Control who can manage reCaptcha and MailChimp settings in the admin area.
- `Igniter.FrontEnd.ManageBanners`: Control who can manage banners in the admin area.
- `Igniter.FrontEnd.ManageSlideshow`: Control who can manage sliders in the admin area.

For more on restricting access to the admin area, see the [TastyIgniter Permissions](https://tastyigniter.com/docs/customize/permissions) documentation.
