---
title: "Automation"
section: "extensions"
sortOrder: 20
---

## Installation

You can install the extension via composer using the following command:

```bash
composer require tastyigniter/ti-ext-automation -W
```

Run the database migrations to create the required tables:
  
```bash
php artisan igniter:up
```

## Automation workflow

The Automation extension follows a specific workflow when an automation is triggered:

1. The extension registers associated actions, conditions, and events using the registerAutomationRules method.
2. When a system event is triggered, the parameters of the event are captured, along with any global parameters.
3. These captured parameters are then attached to a job and placed onto the queue for background processing.
4. The job retrieves all automation rules that match the triggered system event and runs them.
5. The automation conditions are checked to ensure that any required conditions are met.
6. Finally, the automation actions associated with the triggered rules are executed using the captured parameters.

## Getting started

From your TastyIgniter Admin, you can manage automation rules by navigating to _Tools > Automations_.
You can create new automation rules, edit existing ones, and manage the events, actions, and conditions associated with each rule.
You can also view the history of automation runs, which shows the status of each run and any errors that occurred.
You must configure and run a queue worker to process automation jobs. You can read more about this in the [Queue worker section of the TastyIgniter installation documentation](https://tastyigniter.com/docs/installation#setting-up-the-queue-daemon).

## Usage

This section covers how to integrate the Automation Extension API into your extension if you're building an extension that provides automation rules, events, actions, or conditions. The Automation extension provides a simple API for defining and managing automation rules, events, actions, and conditions.

### Defining events

An event class is responsible for preparing the parameters passed to the conditions and actions.

Automation Event classes are typically stored in the `src/AutomationRules/Events` directory of an extension. The Event class is a simple class that extends `Igniter\Automation\Classes\BaseEvent` and defines the `eventDetails` and `makeParamsFromEvent` methods.

Here is an example of an event class:

```php
namespace Author\Extension\AutomationRules\Events;

class CustomerRegisteredEvent extends \Igniter\Automation\Classes\BaseEvent
{
    public function eventDetails(): array
    {
        return [
            'name' => 'Registered',
            'description' => 'When a customer registers',
            'group' => 'customer'
        ];
    }

    public static function makeParamsFromEvent(array $args, $eventName = null): array
    {
        return [
            'user' => array_get($args, 0)
        ];
    }
}
```

The `eventDetails` method returns information about the event, including the name and description. The `makeParamsFromEvent` method prepares the captured parameters passed to the conditions and actions.

These are the available options for the `eventDetails` method:

- `name` - The name of the event. This is displayed in the admin panel.
- `description` - A description of the event. This is displayed in the admin panel.
- `group` - The group to which the event belongs. This is used to group events in the admin panel.

### Defining actions

A action class defines the final step in an automation and performs the automation.

Action classes are typically stored in the `src/AutomationRules/Actions` directory of an extension. The Action class is a simple class that extends `Igniter\Automation\Classes\BaseAction` and defines the `actionDetails`, `defineFormFields`, and `triggerAction` methods.

```php
namespace Author\Extension\AutomationRules\Actions;

class SendMailTemplate extends \Igniter\Automation\Classes\BaseAction
{
    public function actionDetails(): array
    {
        return [
            'name' => 'Compose a mail message',
            'description' => 'Send a message to a recipient',
        ];
    }

    public function defineFormFields(): array
    {
        return [
            'fields' => [
                'template' => [
                    'label' => 'lang:igniter.user::default.label_template',
                    'type' => 'select',
                ],
                'send_to' => [
                    'label' => 'lang:igniter.user::default.label_send_to',
                    'type' => 'select',
                ],
            ],
        ];
    }

    public function triggerAction($params)
    {
        $email = $this->model->send_to;
        $template = $this->model->template;

        // Send mail
    }
}
```

The `actionDetails` method returns information about the action, including the name and description. The `defineFormFields` method defines the form fields required for the action, see [TastyIgniter's available form field types](https://tastyigniter.com/docs/extend/forms#available-field-types). You can access fields defined in the `defineFormFields` method using `$this->model->field_name`. The `triggerAction` method performs the automation action.

These are the available options for the `actionDetails` method:

- `name` - The name of the action. This is displayed in the admin panel.
- `description` - A description of the action. This is displayed in the admin panel.

### Defining conditions

A condition class is used to check whether a condition is true or false.

Automation condition classes are typically stored in the extensions's `src/AutomationRules/Conditions` directory. The Condition class is a simple class that extends `Igniter\Automation\Classes\BaseCondition` and defines the `conditionDetails` and `isTrue` methods.

```php
namespace Author\Extension\AutomationRules\Conditions;

class MyCondition extends \Igniter\Automation\Classes\BaseCondition
{
    public function conditionDetails(): array
    {
        return [
            'name' => 'Condition',
            'description' => 'My Condition is checked',
        ];
    }

    public function isTrue(&$params): bool
    {
        return true;
    }
}
```

The `conditionDetails` method returns information about the condition, including the name and description. The `isTrue` method checks whether the condition is true for the specified parameters.

These are the available options for the `conditionDetails` method:

- `name` - The name of the condition. This is displayed in the admin panel.
- `description` - A description of the condition. This is displayed in the admin panel.

### Defining model attribute conditions

Just like the condition class above, a model attribute condition class applies conditions to sets of model attributes.

Automation model attribute condition classes are typically stored in the extensions's `src/AutomationRules/Conditions` directory. The model attribute condition class is a simple class that extends `Igniter\Automation\Classes\BaseCondition` and defines the `conditionDetails`, `defineModelAttributes`, and `isTrue` methods.

```php
namespace Author\Extension\AutomationRules\Conditions;

class CustomerAttribute extends \Igniter\Automation\Classes\BaseCondition
{
    public function conditionDetails(): array
    {
        return [
            'name' => 'Customer attribute',
        ];
    }
    
    public function defineModelAttributes(): array
    {
        return [
            'first_name' => [
                'label' => 'First Name',
            ],
            'last_name' => [
                'label' => 'Last Name',
            ],
        ];
    }

    public function isTrue(&$params): bool
    {
        return true;
    }
}
```

The `defineModelAttributes` method defines the model attributes and labels required for the condition.

### Registering automation events, actions, and conditions

After creating the [event](#defining-events), [action](#defining-actions) and [condition](#defining-conditions) classes, you can make them available in the admin panel by registering them in the `registerAutomationRules` method of the extension class.

The `registerAutomationRules` method should return an array with the following keys:

- `events` - an array of event class that triggers an automation.
- `actions` - an array of action class that performs a task when an automation is triggered.
- `conditions` - an array of condition class that checks whether a condition is true or false before an action is performed.
- `presets` - predefined automation rules available in the admin panel.

```php
public function registerAutomationRules(): array
{
    return [
        'events' => [
            \Igniter\User\AutomationRules\Events\CustomerRegistered::class,
        ],
        'actions' => [
            \Igniter\User\AutomationRules\Actions\SendMailTemplate::class,
        ],
        'conditions' => [
            \Igniter\User\AutomationRules\Conditions\CustomerAttribute::class
        ],
        'presets' => [
            'registration_email' => [
                'name' => 'Send customer registration email',
                'event' => \Igniter\User\AutomationRules\Events\CustomerRegistered::class,
                'actions' => [
                    \Igniter\User\AutomationRules\Actions\SendMailTemplate::class => [
                        'template' => 'igniter.user::mail.registration_email'
                    ],
                ]
            ]
        ],
    ];
}
```

### Registering global parameters

Global parameters are available to all automation rules. You can register global parameters in the `boot` method of the extension class.

```php
use Igniter\User\Facades\Auth;
use Igniter\Automation\Classes\EventManager;

public function boot()
{
    resolve(EventManager::class)->registerGlobalParams([
        'customer' => Auth::customer()
    ]);
}
```

### Permissions

The Automation extension registers the following permissions:

- `Igniter.Automation.Manage`: Control who can manage automations in the admin area.

For more on restricting access to the admin area, see the [TastyIgniter Permissions](https://tastyigniter.com/docs/customize/permissions) documentation.
