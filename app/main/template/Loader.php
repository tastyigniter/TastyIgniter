<?php namespace Main\Template;

use Main\Contracts\TemplateLoader;
use Main\Contracts\TemplateSource;
use Main\Template\Partial as PartialTemplate;

/**
 * This class implements a template loader for the main app.
 */
class Loader extends \Igniter\Flame\Pagic\Loader implements TemplateLoader
{
    /**
     * @var \Main\Template\Model A object to load the template from.
     */
    protected $source;

    /**
     * Sets a object to load the template from.
     *
     * @param \Main\Contracts\TemplateSource $source Specifies the Template object.
     */
    public function setSource(TemplateSource $source)
    {
        $this->source = $source;
    }

    public function getMarkup($name)
    {
        if (!$this->validateTemplateSource($name))
            return parent::getContents($name);

        return $this->source->getMarkup();
    }

    public function getContents($name)
    {
        if (!$this->validateTemplateSource($name))
            return parent::getContents($name);

        return $this->source->getContent();
    }

    public function getFilename($name)
    {
        if (!$this->validateTemplateSource($name))
            return parent::getFilename($name);

        return $this->source->getFilePath();
    }

    public function getCacheKey($name)
    {
        if (!$this->validateTemplateSource($name))
            return parent::getCacheKey($name);

        return $this->source->getTemplateCacheKey();
    }

    public function isFresh($name, $time)
    {
        if (!$this->validateTemplateSource($name))
            return parent::isFresh($name, $time);

        return $this->source->mTime <= $time;
    }

    public function exists($name)
    {
        return $this->source->exists;
    }

    /**
     * Internal method that checks if the template name matches
     * the loaded object, with fallback support to partials.
     *
     * @param $name
     *
     * @return bool
     */
    protected function validateTemplateSource($name)
    {
        if ($name == $this->source->getFilePath()) {
            return TRUE;
        }

        if ($fallbackObj = $this->findFallbackObject($name)) {
            $this->source = $fallbackObj;

            return TRUE;
        }

        return FALSE;
    }

    /**
     * Looks up a fallback partial object.
     *
     * @param $name
     *
     * @return bool|\Main\Template\Partial
     */
    protected function findFallbackObject($name)
    {
        if (strpos($name, '::') !== FALSE)
            return FALSE;

        if (array_key_exists($name, $this->fallbackCache))
            return $this->fallbackCache[$name];

        return $this->fallbackCache[$name] = PartialTemplate::find($name);
    }
}
