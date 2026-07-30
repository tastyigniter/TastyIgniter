---
title: "Orange"
section: "themes"
sortOrder: 10
---

## Installation

You can install the theme via composer using the following command:

```bash
composer require tastyigniter/ti-theme-orange -W
```

## Usage

This section covers how to use the Orange theme in your TastyIgniter installation.

### Setting featured items

### Bundling theme assets

## Components

Orange theme provides several component that are used to display various blocks on the page. These components are available from the Theme Editor and can be configured to display the desired content.

{.grid-3}
- [Account Dashboard](#account-dashboard)
- [Account Settings](#account-settings)
- [Address Book](#address-book)
- [Banner Preview](#banner-preview)
- [Booking](#booking)
- [Captcha](#captcha)
- [Cart Preview](#cart-preview)
- [Cart Box](#cart-box)
- [Cart Item Modal](#cart-item-modal)
- [Category List](#category-list)
- [Checkout](#checkout)
- [Contact](#contact)
- [Featured Items](#featured-items)
- [Fulfillment](#fulfillment)
- [Fulfillment Modal](#fulfillment-modal)
- [Leave Review](#leave-review)
- [Local Header](#local-header)
- [Local Search](#local-search)
- [Location List](#location-list)
- [Login](#login)
- [Menu Item List](#menu-item-list)
- [Newsletter Subscribe Form](#newsletter-subscribe-form)
- [Order List](#order-list)
- [Order Preview](#order-preview)
- [Register](#register)
- [Reservation List](#reservation-list)
- [Reservation Preview](#reservation-preview)
- [Reset Password](#reset-password)
- [Review List](#review-list)
- [Slider](#slider)
- [Socialite](#socialite)

### Account Dashboard

`igniter-orange::account-dashboard` component displays the account dashboard of the logged-in customer.

This component has no configurable properties.

### Account Settings

`igniter-orange::account-settings` component displays the settings form to update account details belonging to the logged-in customer.

The following properties can be configured:

- `loginPage` - _(string)_ The page to redirect to when the customer changes their email address or password. Default is `account.login`.

### Address Book

`igniter-orange::address-book` component displays a list of addresses belonging to the logged-in customer with options to add, edit, and delete addresses.

The following properties can be configured:

- `itemsPerPage` - _(integer)_ Number of addresses to display per page.
- `sortOrder` - _(string)_ Default sort order of addresses. Default is `created_at desc`.

### Banner Preview

`igniter-orange::banner-preview` component displays the banner created in the admin area.

The following properties can be configured:

- `code` - _(string)_ The unique banner code to display.
- `width` - _(integer)_ The width of the banner image.
- `height` - _(integer)_ The height of the banner image.

### Booking

`igniter-orange::booking` component displays the booking form to make a reservation.

The following properties can be configured:

- `useCalenderView` - _(boolean)_ Use the calendar view for date selection. Default is `true`.
- `weekStartOn` - _(integer)_ Day of the week to start on. Default is `0` (Sunday).
- `minGuestSize` - _(integer)_ Minimum number of guests allowed for a reservation. Default is `2`.
- `maxGuestSize` - _(integer)_ Maximum number of guests allowed for a reservation. Default is `20`.
- `noOfSlots` - _(integer)_ Number of time slots to display in the reduced timeslots view. Default is `6`.
- `telephoneIsRequired` - _(boolean)_ Require telephone number for booking. Default is `true`.
- `successPage` - _(string)_ Page to redirect to when the booking is successful. Default is `reservation.success`.

### Captcha

`igniter-orange::captcha` component displays the Google reCAPTCHA form field.

This component has no configurable properties.

### Cart Preview

`igniter-orange::cart-preview` component displays the cart preview on the checkout page. The cart preview displays the cart items and totals.

This component has no configurable properties.

### Cart Box

`igniter-orange::cart-box` component displays the cart box. The cart box displays the cart items, coupon form, cart totals, and checkout button.

The following properties can be configured:

- `checkoutPage` - _(string)_ Page to redirect to when the checkout button is clicked. Default is `checkout.checkout`.

### Cart Item Modal

`igniter-orange::cart-item-modal` component displays the cart item modal. This component is used to display the cart item details when the user clicks on the cart item or when the user clicks on the add to cart button.

The following properties can be configured:

- `showThumb` - _(boolean)_ Display menu item image in the popup. Default is `false`.
- `thumbWidth` - _(integer)_ Menu item image width. Default is `720`.
- `thumbHeight` - _(integer)_ Menu item image height. Default is `300`.
- `hideZeroOptionPrices` - _(boolean)_ Hide zero prices on options. Default is `false`.

### Category List

`igniter-orange::category-list` component displays the menu categories navigation.

The following properties can be configured:

- `menusPage` - _(string)_ Page to redirect to when a category is clicked. Default is `local.menus`.
- `hideEmpty` - _(boolean)_ Hide empty categories with no menu items. Default is `false`.
- `useLinkAnchor` - _(boolean)_ Use anchor links for category links. Default is `true`.

### Checkout

`igniter-orange::checkout` component displays the checkout form. The checkout form is used to collect customer and payment details and process the order.

The following properties can be configured:

- `isTwoPageCheckout` - _(boolean)_ Use two-page checkout. Default is `false`.
- `showAddress2Field` - _(boolean)_ Display the address 2 checkout field. Default is `true`.
- `showCityField` - _(boolean)_ Display the city checkout field. Default is `true`.
- `showStateField` - _(boolean)_ Display the state checkout field. Default is `true`.
- `showPostcodeField` - _(boolean)_ Display the postcode checkout field. Default is `true`.
- `showTelephoneField` - _(boolean)_ Display the telephone checkout field. Default is `true`.
- `showCountryField` - _(boolean)_ Display the country checkout field. Default is `false`.
- `showCommentField` - _(boolean)_ Display the comment field. Default is `true`.
- `showDeliveryCommentField` - _(boolean)_ Display the delivery comment field. Default is `true`.
- `telephoneIsRequired` - _(boolean)_ Require telephone number for checkout. Default is `true`.
- `agreeTermsSlug` - _(string)_ Static page for the checkout terms and conditions. Default is `terms-and-conditions`.
- `menusPage` - _(string)_ Page to redirect to when checkout is unavailable. Default is `local.menus`.
- `checkoutPage` - _(string)_ Page to redirect to when the checkout fails. Default is `checkout.checkout`.
- `successPage` - _(string)_ Page to redirect to when the checkout is successful. Default is `checkout.success`.

### Contact

`igniter-orange::contact` component displays the contact form.

This component has no configurable properties.

### Featured Items

`igniter-orange::featured-items` component displays a list of featured menu items. The featured items are displayed on the home page or any other page where the component is added.

The following properties can be configured:

- `title` - _(string)_ Title to display.
- `items` - _(array)_ List of menu item IDs to display.
- `limit` - _(integer)_ Number of items to display. Default is `6`.
- `itemsPerRow` - _(integer)_ Number of items to display per row. Default is `3`.
- `showThumb` - _(boolean)_ Show menu item images. Default is `true`.
- `itemWidth` - _(integer)_ Item width. Default is `400`.
- `itemHeight` - _(integer)_ Item height. Default is `300`.

### Fulfillment

`igniter-orange::fulfillment` component displays the order fulfillment options such as the selected order type (delivery or pick-up), date, and time for the order fulfillment.

This component has no configurable properties.

### Fulfillment Modal

`igniter-orange::fulfillment-modal` component displays the order fulfillment modal. The modal is used to select the order type (delivery or collection), date, and time for the order fulfillment and delivery address.

The following properties can be configured:

- `defaultOrderType` - _(string)_ The default selected order type. Default is `delivery`.
- `menusPage` - _(string)_ Page to redirect to when the delivery address changes. Default is `local.menus`.

### Leave Review

`igniter-orange::leave-review` component displays the leave a review form on the order and reservation detail pages. The form allows customers to leave a review and rating for the order or reservation.

The following properties can be configured:

- `type` - _(string)_ Leave a review for the order or reservation. Default is `order`.

### Local Header

`igniter-orange::local-header` component displays the location header. The location header displays the location name, address, schedule and reviews.

- `showThumb` - _(boolean)_ Display the location image thumb. Default is `true`.
- `localThumbWidth` - _(integer)_ Location thumb width. Default is `320`.
- `localThumbHeight` - _(integer)_ Location thumb height. Default is `160`.
- `reviewPerPage` - _(integer)_ Number of reviews to display per page. Default is `10`.
- `reviewSortOrder` - _(string)_ Default sort order of reviews. Default is `created_at desc`.
- `reviewsPage` - _(string)_ Page to redirect to when the "see more reviews" link is clicked. Default is `local.reviews`.

### Local Search

`igniter-orange::local-search` component displays the search form to search for locations. Users can search for locations by full address, city, or postal code.

The following properties can be configured:

- `hideSearch` - _(boolean)_ Hide the search field and display a view menu button. Default is `false`.
- `menusPage` - _(string)_ Page to redirect to when a location is found. Default is `local.menus`.

### Location List

`igniter-orange::location-list` component displays a list of locations. The component displays the search form, sorting and filter options, and a list of locations matching the search and filters.

The following properties can be configured:

- `menusPage` - _(string)_ Page to redirect to when a location is clicked. Default is `local.menus`.
- `itemPerPage` - _(integer)_ Number of locations to display per page. Default is `20`.
- `showThumb` - _(boolean)_ Display location image thumb. Default is `true`.
- `thumbWidth` - _(integer)_ Location thumb width. Default is `95`.
- `thumbHeight` - _(integer)_ Location thumb height. Default is `80`.
- `sortBy` - _(string)_ The default selected sort order. Default is `distance`.
- `orderType` - _(string)_ The default selected order type. Default is `delivery`.

### Login

`igniter-orange::login` component displays the login form. The login form is used to authenticate customers and grant access to the account dashboard, address book, order history, and reservation history.

The following properties can be configured:

- `redirectPage` - _(string)_ Page to redirect to after login. Default is `account.account`.

### Menu Item List

`igniter-orange::menu-item-list` component displays a list of menu items. The component displays the menu items and search form. Users can search for menu items by name, description, or category.

The following properties can be configured:

- `isGrouped` - _(boolean)_ Group menu items by category. Default is `true`.
- `collapseCategoriesAfter` - _(integer)_ Collapse categories after the specified number of items in group view. Default is `5`.
- `itemsPerPage` - _(integer)_ Number of menu items to display per page. Default is `200`. Set to `0` to disable pagination.
- `sortOrder` - _(string)_ Default sort order of menu items. Default is `menu_priority asc`.
- `showThumb` - _(boolean)_ Display menu item, category and allergen image thumb. Default is `true`.
- `menuThumbWidth` - _(integer)_ Menu item image thumb width. Default is `95`.
- `menuThumbHeight` - _(integer)_ Menu item image thumb height. Default is `80`.
- `categoryThumbWidth` - _(integer)_ Category image thumb width. Default is `1240`.
- `categoryThumbHeight` - _(integer)_ Category image thumb height. Default is `256`.
- `allergenThumbWidth` - _(integer)_ Allergen image thumb width. Default is `28`.
- `allergenThumbHeight` - _(integer)_ Allergen image thumb height. Default is `28`.
- `hideMenuSearch` - _(boolean)_ Hide the menu search form. Default is `false`.

### Newsletter Subscribe Form

`igniter-orange::newsletter` component displays the newsletter subscribe form. The form allows users to subscribe their email address for promotional emails and newsletters. Email addresses are stored in the database and can be added to a mailing list on Mailchimp.

The following properties can be configured:

- `listId` - _(string)_ The Mailchimp list ID to subscribe users to. Default is `null`.

### Order List

`igniter-orange::order-list` component displays a list of orders belonging to the logged-in customer. The component displays the order number, date, status, total, and actions to view the order details.

The following properties can be configured:

- `itemsPerPage` - _(integer)_ Number of orders to display per page. Default is `10`.
- `sortOrder` - _(string)_ Default sort order of orders. Default is `created_at desc`.
- `orderPage` - _(string)_ Page to redirect to when an order is clicked. Default is `account.order`.

### Order Preview

`igniter-orange::order-preview` component displays the order details. The component displays the order details and actions to leave a review, reorder, or cancel the order.

The following properties can be configured:

- `hashParamName` - _(string)_ URL routing parameter that holds the code used for displaying the order confirmation page. Default is `hash`.
- `loginPage` - _(string)_ Page to redirect to when the user clicks the login button. Default is `account.login`.
- `ordersPage` - _(string)_ Page to redirect to when viewing as logged in customer and an order is incomplete or not found. Default is `account.orders`.
- `checkoutPage` - _(string)_ Page to redirect to when viewing as guest and an order is incomplete or not found. Default is `checkout.checkout`.
- `menusPage` - _(string)_ Page to redirect to when the user clicks the reorder button. Default is `local.menus`.
- `hideReorderBtn` - _(boolean)_ When rendering the component on the checkout confirmation page, hide the reorder button. Default is `false`.

### Register

`igniter-orange::register` component displays the registration form to create a new customer account.

The following properties can be configured:

- `redirectPage` - _(string)_ Page to redirect to after registration. Default is `account.account`.
- `agreeTermsSlug` - _(string)_ Static page for the registration terms and conditions. Default is `terms-and-conditions`.
- `activationPage` - _(string)_ Page to generate the email verification link. A `code` parameter will be appended to the URL. Default is `account.register`.
- `loginPage` - _(string)_ Page to redirect to when the user clicks the login button. Default is `account.login`.

### Reservation List

`igniter-orange::reservation-list` component displays a list of reservations belonging to the logged-in customer. The component displays the reservation number, date, time, status, and actions to view the reservation details.

The following properties can be configured:

- `itemsPerPage` - _(integer)_ Number of reservations to display per page. Default is `20`.
- `sortOrder` - _(string)_ Default sort order of reservations. Default is `reserve_date desc`.
- `reservationPage` - _(string)_ Page to redirect to when a reservation is clicked. Default is `account.reservation`.

### Reservation Preview

`igniter-orange::reservation-preview` component displays the reservation details. The component displays the reservation details and actions to leave a review or cancel the reservation.

The following properties can be configured:

- `hashParamName` - _(string)_ URL routing parameter that holds the code used for displaying the reservation confirmation page. Default is `hash`.

### Reset Password

`igniter-orange::reset-password` component displays the reset password form. The form allows users to reset their password if they have forgotten it.

The following properties can be configured:

- `resetPage` - _(string)_ Page to generate the reset password link. The selected page _permalink_ should contain the `code` parameter. Default is `account.reset`.
- `loginPage` - _(string)_ Page to redirect to after the password has been reset also used to generate the login link. Default is `account.login`.

### Review List

`igniter-orange::review-list` component displays a list of reviews belonging to a location. The component displays the review rating, comment, and date.

The following properties can be configured:

- `itemsPerPage` - _(integer)_ Number of reviews to display per page. Default is `20`.
- `sortOrder` - _(string)_ Default sort order of reviews. Default is `created_at desc`.

### Socialite

`igniter-orange::socialite` component displays the social login buttons for Facebook, Google, Twitter, and GitHub.

The following properties can be configured:

- `errorPage` - _(string)_ Page to redirect to when an error occurs during social login. Default is `account.login`.
- `successPage` - _(string)_ Page to redirect to when the social login is successful. Default is `account.account`.
- `confirm` - _(boolean)_ Display the email confirmation form after social login. Default is `false`.

### Slider

`igniter-orange::slider` component displays the slider carousel.

The following properties can be configured:

- `code` - _(string)_ The unique slider code to display. Default is `home-slider`.
- `height` - _(integer)_ The height of the slider. Default is `60vh`.
- `effect` - _(string)_ The effect to use when transitioning between slides. Default is `ease`.
- `delayInterval` - _(integer)_ The delay interval between slides in milliseconds. Default is `5000`.
- `hideControls` - _(boolean)_ Hide the slider controls. Default is `false`.
- `hideIndicators` - _(boolean)_ Hide the slider indicators. Default is `false`.
- `hideCaptions` - _(boolean)_ Hide the slider captions. Default is `false`.
