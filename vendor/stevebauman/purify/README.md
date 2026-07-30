<h1 align="center">Purify</h1>

<p align="center">
A Laravel wrapper for <a href="https://github.com/ezyang/htmlpurifier" target="_blank">HTMLPurifier</a> by <a href="https://github.com/ezyang" target="_blank">ezyang</a>.
</p>

<p align="center">
<a href="https://github.com/stevebauman/purify/actions" target="_blank"><img src="https://img.shields.io/github/actions/workflow/status/stevebauman/purify/run-tests.yml?branch=master&style=flat-square"/></a>
<a href="https://packagist.org/packages/stevebauman/purify" target="_blank"><img src="https://img.shields.io/packagist/v/stevebauman/purify.svg?style=flat-square"/></a>
<a href="https://packagist.org/packages/stevebauman/purify" target="_blank"><img src="https://img.shields.io/packagist/dt/stevebauman/purify.svg?style=flat-square"/></a>
<a href="https://packagist.org/packages/stevebauman/purify" target="_blank"><img src="https://img.shields.io/packagist/l/stevebauman/purify.svg?style=flat-square"/></a>
</p>

### Index

- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Configuration](#configuration)
- [Cache](#cache)
- [Practices](#practices)
- [Upgrading from v4 to v5](#upgrading-from-v4-to-v5)
- [Upgrading from v5 to v6](#upgrading-from-v5-to-v6)

### Requirements

-   PHP >= 7.4
-   Laravel >= 7.0

### Installation

To install Purify, run the following command in the root of your project:

```bash
composer require stevebauman/purify
```

Then, publish the configuration file using:

```bash
php artisan vendor:publish --provider="Stevebauman\Purify\PurifyServiceProvider"
```

### Usage

##### Cleaning a String

To clean a users input, simply use the clean method:

```php
use Stevebauman\Purify\Facades\Purify;

$input = '<script>alert("Harmful Script");</script> <p style="border:1px solid black" class="text-gray-700">Test</p>';

// Returns '<p>Test</p>'
$cleaned = Purify::clean($input);
```

##### Cleaning an Array

Need to purify an array of user input? Just pass in an array:

```php
use Stevebauman\Purify\Facades\Purify;

$array = [
    '<script>alert("Harmful Script");</script> <p style="border:1px solid black" class="text-gray-700">Test</p>',
    '<script>alert("Harmful Script");</script> <p style="border:1px solid black" class="text-gray-700">Test</p>',
];

$cleaned = Purify::clean($array);

// array [
//  '<p>Test</p>',
//  '<p>Test</p>',
// ]
var_dump($cleaned);
```

##### Dynamic Configuration

Need a different configuration for a single input? Pass in a configuration array to the `config` method:

> **Note**: Configuration passed into the config method
> is **not** merged with your default configuration.

```php
use Stevebauman\Purify\Facades\Purify;

$config = ['HTML.Allowed' => 'div,b,a[href]'];

$cleaned = Purify::config($config)->clean($input);
```

### Configuration

Inside the configuration file, multiple HTMLPurifier configuration sets
can be specified, similar to Laravel's built-in `database`, `mail` and `logging` config.
Simply call `Purify::config($name)->clean($input)` to use another set of configuration.

For example, if we need to have a separate configuration for a comment system, we
can setup this configuration in the `config/purify.php` file:

```php
// config/purify.php

'configs' => [
    // ...

    'comments' => [
        // Some configuration ...
    ],
]
```

Then, utilize it anywhere in your application by its name:

```php
use Stevebauman\Purify\Facades\Purify;

$cleanedContent = Purify::config('comments')->clean(request('content'));
```

For HTMLPurifier configuration documentation, please visit the HTMLPurifier Website:

http://htmlpurifier.org/live/configdoc/plain.html

### Cache

After running Purify once, [HTMLPurifier](https://github.com/ezyang/htmlpurifier) will auto-cache your
serialized `definitions` into the `serializer.cache` definition you have configured in `config/purify.php`.

> [!Important]
>
> If you have configured Purify to utilize the `CacheDefinitionCache` in the `serializer` option, 
> this command will issue a `Cache::clear()` on the cache driver you have configured it to use.
> 
> If you have configured Purify to utilize the `FilesystemDefinitionCache` in the `serializer` option, 
> this command will clear the directory that you have configured it to store in.
>
> It is recommended to setup a unique filesystem path or disk (via `config/filesystems.php`) or cache store 
> (via `config/cache.php`) for Purify if you intended to clear the serialized definitions using this command.

If you ever update the `definitions` configuration option, you must clear this HTMLPurifier cache.

You may do so via a `purify:clear` command:

```shell
php artisan purify:clear
```

#### Disabling Caching

To disable caching all together, you may set the `serializer` path to `null`:

```php
// config/purify.php

'serializer' => null,
```

This will cause your definitions to be serialized upon each application request.

This is especially useful when debugging or tweaking definition files to see immediate results.

> [!Important]
>
> Caching is recommended in production environments.

### Practices

If you're looking into sanitization, you're likely wanting to sanitize inputted user HTML
content that is then stored in your database to be rendered onto your application.

In this scenario, it's likely best practice to sanitize on the _way out_ instead of
the on the _way in_. The **database doesn't care what text it contains**.

This way you can allow anything to be inserted in the database, and have strong sanization rules on the way out.

To accomplish this, you may use the provided `PurifyHtmlOnGet` cast class on your Eloquent model:

```php
use Stevebauman\Purify\Casts\PurifyHtmlOnGet;

class Post extends Model
{
    // Laravel <= 10.x
    protected $casts = [
        'content' => PurifyHtmlOnGet::class,
    ];

    // Laravel >= 11.x
    protected function casts()
    {
        return [
            'content' => PurifyHtmlOnGet::class,
        ];
    }
}
```

Or, implement it yourself via an Eloquent attribute mutator:

```php
use Stevebauman\Purify\Facades\Purify;

class Post extends Model
{
    public function getContentAttribute($value)
    {
        return Purify::clean($value);
    }
}
```

You can even configure the configuration that is used when casting by appending it's name to the cast:

```php
// config/purify.php

'configs' => [
    // ...

    'other' => [
        // Some configuration ...
    ],
]
```

```php
// Laravel <= 10.x
protected $casts = [
    'content' => PurifyHtmlOnGet::class.':other',
];

// Laravel >= 11.x
protected function casts()
{
    return [
        'content' => PurifyHtmlOnGet::class.':other',
    ];
}
```

This helps tremendously if you change your sanization requirements later down
the line, then all rendered content will follow these sanization rules.

If you'd like to purify HTML while setting the value, you can use the inverse `PurifyHtmlOnSet` cast instead.

#### Custom HTML definitions

The `HTML.Doctype` configuration option denotes the schema to ultimately abide to.
You may want to extend these schema definitions to support custom elements or
attributes (e.g. `<foo>...</foo>`, or `<span foo="...">`) by specifying a
custom HTML element "definitions".

Purify ships with additional HTML5 definitions that HTMLPurifier does
not (yet) support of the box (via the `Html5Definition` class).

To create your own HTML definition, create a new class and have it implement `Definition`:

```php
namespace App;

use HTMLPurifier_HTMLDefinition;
use Stevebauman\Purify\Definitions\Definition;

class CustomDefinition implements Definition
{
    /**
     * Apply rules to the HTML Purifier definition.
     *
     * @param HTMLPurifier_HTMLDefinition $definition
     *
     * @return void
     */
    public static function apply(HTMLPurifier_HTMLDefinition $definition)
    {
        // Customize the HTML purifier definition.
    }
}
```

Then, reference this class in the `config/purify.php` file in the `definitions` key:

```php
// config/purify.php

'definitions' => \App\CustomDefinitions::class,
```

If you'd like to extend the built-in default `Html5Definition`, you can apply it to your custom definition:

```php
use Stevebauman\Purify\Definitions\Html5Definition;

class CustomDefinition implements Definition
{
    public static function apply(HTMLPurifier_HTMLDefinition $definition)
    {
        Html5Definition::apply($definition);
        
        // ...
    }
}
```

##### Basecamp Trix Definition

Here's an example for customizing the definition in order to support Basecamp's Trix WYSIWYG editor
(credit to [Antonio Primera](https://github.com/stevebauman/purify/issues/7) & [Daniel Sun](https://github.com/stevebauman/purify/issues/77)):

```php
namespace App;

use HTMLPurifier_HTMLDefinition;
use Stevebauman\Purify\Definitions\Definition;

class TrixPurifierDefinitions implements Definition
{
    /**
     * Apply rules to the HTML Purifier definition.
     *
     * @param HTMLPurifier_HTMLDefinition $definition
     *
     * @return void
     */
    public static function apply(HTMLPurifier_HTMLDefinition $definition)
    {
        $definition->addElement('figure', 'Inline', 'Inline', 'Common');
        $definition->addAttribute('figure', 'class', 'Class');
        $definition->addAttribute('figure', 'data-trix-attachment', 'Text');
        $definition->addAttribute('figure', 'data-trix-attributes', 'Text');

        $definition->addElement('figcaption', 'Inline', 'Inline', 'Common');
        $definition->addAttribute('figcaption', 'class', 'Class');
        $definition->addAttribute('figcaption', 'data-trix-placeholder', 'Text');

        $definition->addAttribute('a', 'rel', 'Text');
        $definition->addAttribute('a', 'tabindex', 'Text');
        $definition->addAttribute('a', 'contenteditable', 'Enum#true,false');
        $definition->addAttribute('a', 'data-trix-attachment', 'Text');
        $definition->addAttribute('a', 'data-trix-content-type', 'Text');
        $definition->addAttribute('a', 'data-trix-id', 'Number');

        $definition->addElement('span', 'Block', 'Flow', 'Common');
        $definition->addAttribute('span', 'data-trix-cursor-target', 'Enum#right,left');
        $definition->addAttribute('span', 'data-trix-serialize', 'Enum#true,false');

        $definition->addAttribute('img', 'data-trix-mutable', 'Enum#true,false');
        $definition->addAttribute('img', 'data-trix-store-key', 'Text');
    }
}
```


#### Custom CSS definitions

It's possible to override the CSS definitions, this allows you to customize what
inline styles you allow and their properties and values. This can help fill in
missing values for properties such as text-align, which by default is missing start
and end values. You can do this by creating a CSS definition.

To create your own CSS definition, create a new class and have it implement `CssDefinition`:

```php
namespace App;

use HTMLPurifier_CSSDefinition;
use Stevebauman\Purify\Definitions\CssDefinition;

class CustomCssDefinition implements CssDefinition
{
    /**
     * Apply rules to the CSS Purifier definition.
     *
     * @param HTMLPurifier_CSSDefinition $definition
     *
     * @return void
     */
    public static function apply(HTMLPurifier_CSSDefinition $definition)
    {
        // Customize the CSS purifier definition.
        $definition->info['text-align'] = new \HTMLPurifier_AttrDef_Enum(
            ['right', 'left', 'center', 'start', 'end'],
            false,
        );
    }
}
```

Then, reference this class in the `config/purify.php` file in the `css-definitions` key:

```php
// config/purify.php

'css-definitions' => \App\CustomCssDefinition::class,
```

See the class HTMLPurifier_CSSDefinition in the HTMLPurifier library for other examples of what can be changed.

### Upgrading from v4 to v5

To upgrade from v4, install the latest version by running the below command in the root of your project:

```bash
composer require stevebauman/purify
```

Then, navigate into your published `config/purify.php` configuration file and
copy the `settings` array -- except for the following keys:

-   `HTML.DocType`:
-   `Core.Encoding`:
-   `Cache.SerializerPath`:

```diff
'settings' => [
-   'Core.Encoding' => 'utf-8',
-   'Cache.SerializerPath' => storage_path('app/purify'),
-   'HTML.Doctype' => 'XHTML 1.0 Strict',
+   'HTML.Allowed' => 'h1,h2,h3,h4,h5,h6,b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span,img[width|height|alt|src]',
+   'HTML.ForbiddenElements' => '',
+   'CSS.AllowedProperties' => 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align',
+   'AutoFormat.AutoParagraph' => false,
+   'AutoFormat.RemoveEmpty' => false,
],
```

> **Important**: If you've created a unique storage path for `Cache.SerializerPath`,
> take note of this as well, so you can migrate it into the new configuration file.

Once copied, delete the `config/purify.php` file, and run the below command:

```bash
php artisan vendor:publish --provider="Stevebauman\Purify\PurifyServiceProvider"
```

Then, inside the newly published `config/purify.php` configuration file, paste
the keys (overwriting the current) into the `configs.default` array:

```diff
'configs' => [
    'default' => [
        'Core.Encoding' => 'utf-8',
        'HTML.Doctype' => 'HTML 4.01 Transitional',
+       'HTML.Allowed' => 'h1,h2,h3,h4,h5,h6,b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span,img[width|height|alt|src]',
+       'HTML.ForbiddenElements' => '',
+       'CSS.AllowedProperties' => 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align',
+       'AutoFormat.AutoParagraph' => false,
+       'AutoFormat.RemoveEmpty' => false,
    ],
],
```

If you've created a unique serializer path (previously set via the old `Cache.SerializerPath` configuration
key mentioned above), then you may reconfigure this in the new `serializer` configuration key:

```php
'serializer' => storage_path('app/purify'),
```

You're all set!

### Upgrading from v5 to v6

In v6, the HTMLPurifier Serializer storage mechanism was updated for Laravel Vapor support, allowing 
you to store the serialized HTMLPurifier definitions in a Redis cache, or an external filesystem.

To upgrade from v5, install the latest version by running the below command in the root of your project:

```bash
composer require stevebauman/purify
```

Then, navigate into your published `config/purify.php` configuration file and 
replace the `serializer` configuration option with the below:

```diff
-    'serializer' => storage_path('app/purify'),

+    'serializer' => [
+       'disk' => env('FILESYSTEM_DISK', 'local'),
+       'path' => 'purify',
+       'cache' => \Stevebauman\Purify\Cache\FilesystemDefinitionCache::class,
+    ],
+
+    // 'serializer' => [
+    //    'driver' => env('CACHE_DRIVER', 'file'),
+    //    'cache' => \Stevebauman\Purify\Cache\CacheDefinitionCache::class,
+    // ],
```

This will update the syntax used to control the serializer cache mechanism. You may now uncomment 
the below `serializer` cache definition if you would like to use a Laravel Cache driver
(such as Redis) to store the serialized definitions.
