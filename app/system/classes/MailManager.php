<?php

namespace System\Classes;

use Igniter\Flame\Support\PagicHelper;
use Igniter\Flame\Support\StringParser;
use Igniter\Flame\Traits\Singleton;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use System\Helpers\ViewHelper;
use System\Models\Mail_partials_model;
use System\Models\Mail_templates_model;
use System\Models\Mail_themes_model;

class MailManager
{
    use Singleton;

    /**
     * @var array A cache of templates.
     */
    protected $templateCache = [];

    /**
     * @var array Cache of registration callbacks.
     */
    protected $callbacks = [];

    /**
     * @var array List of registered templates in the system
     */
    protected $registeredTemplates;

    /**
     * @var array List of registered partials in the system
     */
    protected $registeredPartials;

    /**
     * @var array List of registered layouts in the system
     */
    protected $registeredLayouts;

    /**
     * @var bool Internal marker for rendering mode
     */
    protected $isRenderingHtml = FALSE;

    /**
     * The partials being rendered.
     *
     * @var array
     */
    protected $partialStack = [];

    /**
     * The original data passed to the partial.
     *
     * @var array
     */
    protected $partialData = [];

    public function addContentToMailer($message, $code, $data, $plainOnly = FALSE)
    {
        if (isset($this->templateCache[$code])) {
            $template = $this->templateCache[$code];
        }
        else {
            $this->templateCache[$code] = $template = Mail_templates_model::findOrMakeTemplate($code);
        }

        if (!$template)
            return FALSE;

        return $this->addContentToMailerInternal($message, $template, $data);
    }

    public function addRawContentToMailer($message, $content, $data)
    {
        $template = new Mail_templates_model();

        $template->fillFromContent($content);

        return $this->addContentToMailerInternal($message, $template, $data);
    }

    public function applyMailerConfigValues()
    {
        $config = App::make('config');
        $settings = App::make('system.setting');
        $config->set('mail.driver', $settings->get('protocol'));
        $config->set('mail.from.name', $settings->get('sender_email'));
        $config->set('mail.from.address', $settings->get('sender_name'));

        switch ($settings->get('protocol')) {
            case 'sendmail':
                $config->set('mail.sendmail', $settings->get('sendmail_path'));
                break;
            case 'smtp':
                $config->set('mail.host', $settings->get('smtp_host'));
                $config->set('mail.port', $settings->get('smtp_port'));
                $config->set('mail.encryption', strlen($settings->get('smtp_encryption'))
                    ? $settings->get('smtp_encryption') : null
                );
                $config->set('mail.username', strlen($settings->get('smtp_user'))
                    ? $settings->get('smtp_user') : null
                );
                $config->set('mail.password', strlen($settings->get('smtp_pass'))
                    ? $settings->get('smtp_pass') : null
                );
                break;
            case 'mailgun':
                $config->set('services.mailgun.domain', $settings->get('mailgun_domain'));
                $config->set('services.mailgun.secret', $settings->get('mailgun_secret'));
                break;
            case 'ses':
                $config->set('services.ses.key', $settings->get('ses_key'));
                $config->set('services.ses.secret', $settings->get('ses_secret'));
                $config->set('services.ses.region', $settings->get('ses_region'));
                break;
        }
    }

    /**
     * @param \Illuminate\Mail\Message $message
     * @param $template
     * @param $data
     * @param bool $plainOnly
     * @return bool
     */
    protected function addContentToMailerInternal($message, $template, $data, $plainOnly = FALSE)
    {
        $globalVars = ViewHelper::getGlobalVars();
        if (!empty($globalVars)) {
            $data = (array)$data + $globalVars;
        }

        // Subject
        $swiftMessage = $message->getSwiftMessage();
        if (empty($swiftMessage->getSubject())) {
            $message->subject($this->renderView($template->subject, $data));
        }

        $data += ['subject' => $swiftMessage->getSubject()];

        // HTML contents
        if (!$plainOnly) {
            $html = $this->renderTemplate($template, $data);
            $message->setBody($html, 'text/html');
        }

        // Text contents
        $text = $this->renderTextTemplate($template, $data);
        $message->addPart($text, 'text/plain');

        return TRUE;
    }

    //
    // Rendering
    //

    /**
     * Render the Markdown template into HTML.
     *
     * @param string $content
     * @param array $data
     * @return string
     */
    public function render($content, $data = [])
    {
        if (!$content)
            return '';

        $html = $this->renderView($content, $data);

        $html = Markdown::parse($html);

        return $html;
    }

    /**
     * Render the Markdown template into text.
     * @param $content
     * @param array $data
     * @return string
     */
    public function renderText($content, $data = [])
    {
        if (!$content) {
            return '';
        }

        $text = $this->renderView($content, $data);

        $text = html_entity_decode(preg_replace("/[\r\n]{2,}/", "\n\n", $text), ENT_QUOTES, 'UTF-8');

        return $text;
    }

    public function renderTemplate($template, $data = [])
    {
        $this->isRenderingHtml = TRUE;

        $html = $this->render($template->body, $data);

        if ($template->layout) {
            $html = $this->renderView($template->layout->layout, [
                    'body' => $html,
                    'layout_css' => $template->layout->layout_css,
                    'custom_css' => Mail_themes_model::renderCss(),
                ] + (array)$data);
        }

        return $html;
    }

    public function renderTextTemplate($template, $data = [])
    {
        $this->isRenderingHtml = FALSE;

        $templateText = $template->plain_body;
        if (!strlen($template->plain_body))
            $templateText = $template->body;

        $text = $this->renderText($templateText, $data);

        if ($template->layout) {
            $text = $this->renderView($template->layout->plain_layout, [
                    'body' => $text,
                ] + (array)$data);
        }

        /*        $cleanText = preg_replace('/<br\s?\/?>/i', "\r\n", $text);*/

        return $text;
    }

    protected function renderView($content, $data)
    {
        $this->registerBladeDirectives();

        $content = PagicHelper::parse($content, $data);

        return (new StringParser)->parse($content, $data);
    }

    public function startPartial($code, array $params = [])
    {
        if (ob_start()) {
            $this->partialStack[] = $code;

            $currentPartial = count($this->partialStack) - 1;
            $this->partialData[$currentPartial] = $params;
        }
    }

    public function renderPartial()
    {
        $this->isRenderingHtml = TRUE;

        $code = array_pop($this->partialStack);
        if (!$partial = Mail_partials_model::findOrMakePartial($code))
            return '<!-- Missing partial: '.$code.' -->';

        $currentPartial = count($this->partialStack);
        $params = $this->partialData[$currentPartial];
        $params['slot'] = new HtmlString(trim(ob_get_clean()));

        $content = $partial->text ?: $partial->html;
        $content = $this->isRenderingHtml ? $partial->html : $content;

        if (!strlen(trim($content)))
            return '';

        return $this->renderView($content, $params);
    }

    //
    // Registration
    //

    /**
     * Loads registered templates from extensions
     * @return void
     */
    public function loadRegisteredTemplates()
    {
        foreach ($this->callbacks as $callback) {
            $callback($this);
        }

        $extensions = ExtensionManager::instance()->getExtensions();
        foreach ($extensions as $extensionCode => $extensionObj) {
            $this->processRegistrationMethodValues($extensionObj, 'registerMailLayouts');
            $this->processRegistrationMethodValues($extensionObj, 'registerMailTemplates');
            $this->processRegistrationMethodValues($extensionObj, 'registerMailPartials');
        }
    }

    /**
     * Returns a list of the registered layouts.
     * @return array
     */
    public function listRegisteredLayouts()
    {
        if (is_null($this->registeredLayouts))
            $this->loadRegisteredTemplates();

        return $this->registeredLayouts;
    }

    /**
     * Returns a list of the registered templates.
     * @return array
     */
    public function listRegisteredTemplates()
    {
        if (is_null($this->registeredTemplates))
            $this->loadRegisteredTemplates();

        return $this->registeredTemplates;
    }

    /**
     * Returns a list of the registered partials.
     * @return array
     */
    public function listRegisteredPartials()
    {
        if (is_null($this->registeredPartials))
            $this->loadRegisteredTemplates();

        return $this->registeredPartials;
    }

    /**
     * Registers mail views and manageable layouts.
     * @param array $definitions
     */
    public function registerMailLayouts(array $definitions)
    {
        if (!$this->registeredLayouts) {
            $this->registeredLayouts = [];
        }

        $this->registeredLayouts = $definitions + $this->registeredLayouts;
    }

    /**
     * Registers mail views and manageable templates.
     * @param array $definitions
     */
    public function registerMailTemplates(array $definitions)
    {
        if (!$this->registeredTemplates) {
            $this->registeredTemplates = [];
        }

        $this->registeredTemplates = $definitions + $this->registeredTemplates;
    }

    /**
     * Registers mail views and manageable partials.
     * @param array $definitions
     */
    public function registerMailPartials(array $definitions)
    {
        if (!$this->registeredPartials) {
            $this->registeredPartials = [];
        }

        $this->registeredPartials = $definitions + $this->registeredPartials;
    }

    /**
     * Registers a callback function that defines templates.
     * The callback function should register templates by calling the manager's
     * registerMailTemplates() function. This instance is passed to the
     * callback function as an argument. Usage:
     * <pre>
     *   MailManager::instance()->registerCallback(function($manager){
     *       $manager->registerMailTemplates([...]);
     *   });
     * </pre>
     *
     * @param callable $callback A callable function.
     */
    public function registerCallback(callable $callback)
    {
        $this->callbacks[] = $callback;
    }

    protected function registerBladeDirectives()
    {
        Blade::directive('partial', function ($expression) {
            return "<?php \System\Classes\MailManager::instance()->startPartial({$expression}); ?>";
        });

        Blade::directive('endpartial', function () {
            return "<?php echo \System\Classes\MailManager::instance()->renderPartial(); ?>";
        });
    }

    protected function processRegistrationMethodValues($extension, $method)
    {
        if (!method_exists($extension, $method))
            return;

        $results = $extension->$method();
        if (is_array($results)) {
            $this->$method($results);
        }
    }
}
