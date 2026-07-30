---
title: "Pages"
section: "extensions"
sortOrder: 70
---

## Installation

You can install the extension via composer using the following command:

```bash
composer require tastyigniter/ti-ext-pages -W
```

Run the database migrations to create the required tables:
  
```bash
php artisan igniter:up
```

## Getting started

In the admin area, you can create, edit, or delete frontend pages and navigation menus. Navigate to the _Design > Static Pages_ and _Design > Static Pages > Static Menus_ admin pages to manage pages and navigation menus, respectively.

## Usage

This section covers how to integrate the Pages extension into your own theme if you need to create static pages, display static navigation menus, or create custom menu item types. The Pages extension provides a simple API for managing managing custom navigation menus.

### Creating a Layout

The first step is to create a layout that will host all static pages of the website. The layout file should contain the `@themePage` directive, which renders the content of the static page.

```blade
---
description: Static layout for static pages
---
<html>
    <head>
        <title>{{ $this->page->title }}</title>
    </head>
    <body>
        @themePage
    </body>
</html>
```

### Displaying menu items

The `generateReferences` method of the `Igniter\Pages\Classes\MenuManager` class is used to generate the navigation menu items. The method accepts a `Igniter\Pages\Models\Menu` model instance, `Page` template object and returns an array of navigation menu items with references.

```php
use Igniter\Pages\Classes\MenuManager;
use Igniter\Pages\Models\Menu;

$menu = Menu::with(['items'])->where('code', 'main-menu')->first();

$menuItems = resolve(MenuManager::class)->generateReferences(
    $menu, controller()->getPage()
);
```

The `$menuItems` variable is an array of objects. Each object has the following properties:

- `title` - specifies the menu item title.
- `url` - specifies the absolute menu item URL.
- `isActive` - indicates whether the item corresponds to a page currently being viewed.
- `isChildActive` - indicates whether the item contains an active subitem.
- `extraAttributes` - specifies the menu item extra HTML attributes
- `items` - an array of the menu item subitems, if any. If there are no subitems, the array is empty

You can loop through the menu items and display them in your blade view:

```blade
@foreach ($menuItems as $item)
   <li><a href="{{ $item->url }}">{{ $item->title }}</a></li>
@endforeach
```

### Setting the active menu item

In some cases, you may want to tag a particular menu item explicitly as active. You can do that in the `onInit()`
function of the layout, by assigning a value to the `activeMenuItem` layout variable matching the menu item code that you
want to activate.

```php
function onInit()
{
    $this['activeMenuItem'] = 'about-us';
}
```

### Creating menu item types

The Pages extension provides a simple way to create custom menu item types. Extensions can register new menu item type using the events triggered by this extension. The following events are available and should have their listeners registered in the `boot` method of the extension's class:

- `pages.menuitem.listType`: Register new menu item types.
- `pages.menuitem.getTypeInfo`: Return information about an item type.
- `pages.menuitem.resolveItem`: Resolve each menu item, retuning the actually item URL, title and indicator if the item is active or has subitems.

The following example demonstrates how to register a new menu item type for theme pages:

```php
Event::listen('pages.menuitem.listTypes', function () {
    return [
        'theme-page' => 'igniter::main.pages.text_theme_page',
    ];
});

Event::listen('pages.menuitem.getTypeInfo', function ($type) {
    return Page::getMenuTypeInfo((string)$type);
});

Event::listen('pages.menuitem.resolveItem', function ($item, $url, $theme) {
    if ($item->type == 'theme-page' && $theme) {
        return Page::resolveMenuItem($item, $url, $theme);
    }
});
```

#### Registering New menu item types

First, you need to register a new menu item type using the `pages.menuitem.listTypes` event. The event listener should return an array of menu item types with the key as the type code and the value as the type name. It is recommended to use the extension code as prefix of the type code to avoid conflicts with other extensions.

```php
Event::listen('pages.menuitem.listTypes', function () {
    return [
        'my-extension-item-type' => 'My extension menu item type',
    ];
});
```

#### Returning information about an item type

After registering the new menu item type, you need to return information about the item type using the `pages.menuitem.getTypeInfo` event. The event listener receives the item type code as a parameter and should return an array in the following format:

```php
Event::listen('pages.menuitem.getTypeInfo', function ($type) {
    if ($type == 'my-extension-item-type') {
        return [
            'references' => [
                11 => 'Item reference 1',
                12 => 'Item reference 2',
                22 => 'Item reference 3',
            ]
        ];
    }
});
```

The `references` key should contain an array of references for the menu item. The key of each reference should be unique and the value should be the reference name. For example, the theme page menu item type returns an array of page ID and name as the reference.

#### Resolving menu items

When generating navigation menus on the frontend, the `pages.menuitem.resolveItem` event is used to resolve each menu item, returning the actual item URL, title, and indicator if the item is active or has subitems. The event listener receives the menu item object, the URL of the current page, and the theme object as parameters.

```php
Event::listen('pages.menuitem.resolveItem', function ($item, $currentUrl, $theme) {
    if ($item->type == 'my-extension-item-type') {
        return [
            'url' => 'my-extension-item-url',
            'title' => 'My extension item title',
            'isActive' => $currentUrl === 'my-extension-item-url',
        ];
    }
});
```

The `url` anf `isActive` keys are required for menu items that points to a specific page. The `title` key is optional and can be used to set the menu item title.

### Overriding generated references

You can override the generated references for a specific menu item type by listening to the `pages.menu.referencesGenerated` event. The event listener receives the generated menu items as parameter.

```php
Event::listen('pages.menuitem.referencesGenerated', function (&$items) {
    // ...
});
```

### Permissions

The Pages extension registers the following permissions:

- `Igniter.Pages.Manage`: Control who can manage static pages in the admin area.

For more on restricting access to the admin area, see the [TastyIgniter Permissions](https://tastyigniter.com/docs/customize/permissions) documentation.
