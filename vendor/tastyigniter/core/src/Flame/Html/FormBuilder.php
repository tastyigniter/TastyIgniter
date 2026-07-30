<?php

declare(strict_types=1);

namespace Igniter\Flame\Html;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Traits\Macroable;

class FormBuilder
{
    public $payload;

    use Macroable;

    /**
     * The session store implementation.
     */
    protected ?Session $session = null;

    /**
     * The current model instance for the form.
     */
    protected mixed $model;

    /**
     * The reserved form open attributes.
     *
     * @var array
     */
    protected $reserved = ['method', 'url', 'route', 'action', 'files'];

    /**
     * The form methods that should be spoofed, in uppercase.
     *
     * @var array
     */
    protected $spoofedMethods = ['DELETE', 'PATCH', 'PUT'];

    /**
     * The types of inputs to not fill values on by default.
     *
     * @var array
     */
    protected $skipValueTypes = ['file', 'password', 'checkbox', 'radio'];

    /**
     * Input Type.
     */
    protected $type;

    /**
     * Create a new form builder instance.
     */
    public function __construct(
        /**
         * The HTML builder instance.
         */
        protected HtmlBuilder $html,
        /**
         * The URL generator instance.
         */
        protected UrlGenerator $url,
        /**
         * The View factory instance.
         */
        protected Factory $view,
        /**
         * The CSRF token used by the form builder.
         */
        protected ?string $csrfToken,
        protected ?Request $request = null
    ) {}

    /**
     * Open up a new HTML form.
     */
    public function open(array $options = []): HtmlString
    {
        $method = array_get($options, 'method', 'post');

        // We need to extract the proper method from the attributes. If the method is
        // something other than GET or POST we'll use POST since we will spoof the
        // actual method since forms don't support the reserved methods in HTML.
        $attributes['method'] = $this->getMethod($method);

        $attributes['action'] = $this->getAction($options);

        $attributes['accept-charset'] = 'UTF-8';

        // If the method is PUT, PATCH or DELETE we will need to add a spoofer hidden
        // field that will instruct the Symfony request to pretend the method is a
        // different method than it actually is, for convenience from the forms.
        $append = $this->getAppendage($method);

        if (isset($options['files']) && $options['files']) {
            $options['enctype'] = 'multipart/form-data';
        }

        // Finally we're ready to create the final form HTML field. We will attribute
        // format the array of attributes. We will also add on the appendage which
        // is used to spoof requests for this PUT, PATCH, etc. methods on forms.
        $attributes = array_merge(
            $attributes, array_except($options, $this->reserved),
        );

        // Finally, we will concatenate all of the attributes into a single string so
        // we can build out the final form open statement. We'll also append on an
        // extra value for the hidden _method field if it's needed for the form.
        $attributes = $this->html->attributes($attributes);

        return $this->toHtmlString('<form'.$attributes.'>'.$append);
    }

    /**
     * Close the current form.
     */
    public function close(): HtmlString
    {
        $this->model = null;

        return $this->toHtmlString('</form>');
    }

    /**
     * Generate a hidden field with the current CSRF token.
     */
    public function token(): HtmlString
    {
        $token = !empty($this->csrfToken) ? $this->csrfToken : $this->session->token();

        return $this->hidden('_token', $token);
    }

    /**
     * Create a form input field.
     *
     * @param string $type
     * @param string $name
     * @param string $value
     * @param array $options
     */
    public function input($type, $name, $value = null, $options = []): HtmlString
    {
        $this->type = $type;

        if (!isset($options['name'])) {
            $options['name'] = $name;
        }

        // We will get the appropriate value for the given field. We will look for the
        // value in the session for the value in the old input data then we'll look
        // in the model instance if one is set. Otherwise we will just use empty.
        $id = $this->getIdAttribute($name, $options);

        if (!in_array($type, $this->skipValueTypes)) {
            $value = $this->getValueAttribute($name, $value);
        }

        // Once we have the type, value, and ID we can merge them into the rest of the
        // attributes array so we can convert them into their HTML attribute format
        // when creating the HTML element. Then, we will return the entire input.
        $merge = ['type' => $type, 'value' => $value, 'id' => $id];

        $options = array_merge($options, $merge);

        return $this->toHtmlString('<input'.$this->html->attributes($options).'>');
    }

    /**
     * Create a hidden input field.
     *
     * @param string $name
     * @param string $value
     * @param array $options
     */
    public function hidden($name, $value = null, $options = []): HtmlString
    {
        return $this->input('hidden', $name, $value, $options);
    }

    /**
     * Parse the form action method.
     *
     * @param string $method
     */
    protected function getMethod($method): string
    {
        $method = strtoupper($method);

        return $method !== 'GET' ? 'POST' : $method;
    }

    /**
     * Get the form action from the options.
     *
     * @return string
     */
    protected function getAction(array $options)
    {
        // We will also check for a "route" or "action" parameter on the array so that
        // developers can easily specify a route or controller action when creating
        // a form providing a convenient interface for creating the form actions.
        if (isset($options['url'])) {
            return $this->getUrlAction($options['url']);
        }

        if (isset($options['route'])) {
            return $this->getRouteAction($options['route']);
        }

        // If an action is available, we are attempting to open a form to a controller
        // action route. So, we will use the URL generator to get the path to these
        // actions and return them from the method. Otherwise, we'll use current.
        elseif (isset($options['action'])) {
            return $this->getControllerAction($options['action']);
        }

        return $this->url->current();
    }

    /**
     * Get the action for a "url" option.
     *
     * @param array|string $options
     *
     * @return string
     */
    protected function getUrlAction($options)
    {
        if (is_array($options)) {
            return $this->url->to($options[0], array_slice($options, 1));
        }

        return $this->url->to($options);
    }

    /**
     * Get the action for a "route" option.
     *
     * @param array|string $options
     *
     * @return string
     */
    protected function getRouteAction($options)
    {
        if (is_array($options)) {
            return $this->url->route($options[0], array_slice($options, 1));
        }

        return $this->url->route($options);
    }

    /**
     * Get the action for an "action" option.
     *
     * @param array|string $options
     *
     * @return string
     */
    protected function getControllerAction($options)
    {
        if (is_array($options)) {
            return $this->url->action($options[0], array_slice($options, 1));
        }

        return $this->url->action($options);
    }

    /**
     * Get the form appendage for the given method.
     *
     * @param string $method
     */
    protected function getAppendage($method): string
    {
        [$method, $appendage] = [strtoupper($method), ''];

        // If the HTTP method is in this list of spoofed methods, we will attach the
        // method spoofer hidden input to the form. This allows us to use regular
        // form to initiate PUT and DELETE requests in addition to the typical.
        if (in_array($method, $this->spoofedMethods)) {
            $appendage .= $this->hidden('_method', $method);
        }

        // If the method is something other than GET we will go ahead and attach the
        // CSRF token to the form, as this can't hurt and is convenient to simply
        // always have available on every form the developers creates for them.
        if ($method !== 'GET') {
            $appendage .= $this->token();
        }

        return $appendage;
    }

    /**
     * Get the ID attribute for a field name.
     *
     * @param string $name
     *
     * @return ?string
     */
    public function getIdAttribute($name, array $attributes)
    {
        return $attributes['id'] ?? null;
    }

    /**
     * Get the value that should be assigned to the field.
     *
     * @param string $name
     * @param string $value
     *
     * @return mixed
     */
    public function getValueAttribute($name, $value = null)
    {
        if (is_null($name)) {
            return $value;
        }

        $old = $this->old($name);

        if (!is_null($old) && $name != '_method') {
            return $old;
        }

        if (function_exists('app')) {
            $hasNullMiddleware = app(Kernel::class)
                ->hasMiddleware(ConvertEmptyStringsToNull::class);

            if ($hasNullMiddleware
                && is_null($old)
                && is_null($value)
                && !is_null($this->view->shared('errors'))
                && count($this->view->shared('errors')) > 0
            ) {
                return null;
            }
        }

        $request = $this->request($name);
        if (!is_null($request)) {
            return $request;
        }

        if (!is_null($value)) {
            return $value;
        }

        return null;
    }

    /**
     * Get value from current Request
     *
     * @return array|null|string
     */
    protected function request($name)
    {
        if (!isset($this->request)) {
            return null;
        }

        return $this->request->input($this->transformKey($name));
    }

    /**
     * Get a value from the session's old input.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function old($name)
    {
        if (isset($this->session)) {
            $key = $this->transformKey($name);
            $payload = $this->session->getOldInput($key);

            if (is_array($payload) && !in_array($this->type, ['select', 'checkbox'])) {
                if (!isset($this->payload[$key])) {
                    $this->payload[$key] = collect($payload);
                }

                if (!empty($this->payload[$key])) {
                    return $this->payload[$key]->shift();
                }
            }

            return $payload;
        }

        return null;
    }

    /**
     * Determine if the old input is empty.
     */
    public function oldInputIsEmpty(): bool
    {
        return isset($this->session) && count($this->session->getOldInput()) === 0;
    }

    /**
     * Transform key from array to dot syntax.
     *
     * @param string $key
     */
    protected function transformKey($key): string
    {
        return str_replace(['.', '[]', '[', ']'], ['_', '', '.', ''], $key);
    }

    /**
     * Transform the string to an Html serializable object
     */
    protected function toHtmlString($html): HtmlString
    {
        return new HtmlString($html);
    }

    /**
     * Get the session store implementation.
     *
     * @return Session $session
     */
    public function getSessionStore(): ?Session
    {
        return $this->session;
    }

    /**
     * Set the session store implementation.
     */
    public function setSessionStore(Session $session): static
    {
        $this->session = $session;

        return $this;
    }
}
