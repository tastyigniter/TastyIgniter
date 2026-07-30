<?php

declare(strict_types=1);

namespace Igniter\System\Mail;

use Igniter\Flame\Mail\Mailable;
use Igniter\System\Classes\MailManager;
use Igniter\System\Helpers\ViewHelper;
use Igniter\System\Models\MailTemplate;
use Override;
use ReflectionClass;
use ReflectionProperty;

class TemplateMailable extends Mailable
{
    protected string $templateCode;

    protected ?MailTemplate $mailTemplate = null;

    public static function getVariables(): array
    {
        return static::getPublicProperties();
    }

    public function getTemplateCode(): string
    {
        return $this->templateCode;
    }

    public function getMailTemplate(): MailTemplate
    {
        return $this->mailTemplate ?? $this->resolveTemplateModel();
    }

    protected function resolveTemplateModel(): MailTemplate
    {
        return $this->mailTemplate = MailTemplate::findOrMakeTemplate($this->getTemplateCode());
    }

    #[Override]
    protected function buildView()
    {
        $template = $this->getMailTemplate();

        $manager = $this->getMailManager();

        $viewData = $this->buildViewData();

        $this->html = $manager->renderTemplate($template, $viewData)->toHtml();
        $this->textView = $manager->renderTextTemplate($template, $viewData); // @phpstan-ignore assign.propertyType

        return parent::buildView();
    }

    #[Override]
    protected function buildSubject($message): self
    {
        if ($subject = $this->getMailTemplate()->subject) {
            $this->subject($this->getMailManager()->renderView($subject, $this->buildViewData())->toHtml());
        }

        return parent::buildSubject($message);
    }

    #[Override]
    public function buildViewData(): array
    {
        $data = parent::buildViewData();

        $globalVars = ViewHelper::getGlobalVars();
        if (!empty($globalVars)) {
            $data += $globalVars;
        }

        return $data;
    }

    protected static function getPublicProperties(): array
    {
        $class = new ReflectionClass(static::class);

        return collect($class->getProperties(ReflectionProperty::IS_PUBLIC))
            ->filter(fn($property) => $property->getDeclaringClass()->getName() !== self::class)
            ->map(fn($property) => $property->getName())
            ->values()
            ->all();
    }

    protected function getMailManager(): MailManager
    {
        return resolve(MailManager::class);
    }
}
