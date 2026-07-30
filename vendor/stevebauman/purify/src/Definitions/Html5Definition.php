<?php

namespace Stevebauman\Purify\Definitions;

use HTMLPurifier_HTMLDefinition;

class Html5Definition implements Definition
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
        // http://developers.whatwg.org/sections.html
        $definition->addElement('section', 'Block', 'Flow', 'Common');
        $definition->addElement('nav', 'Block', 'Flow', 'Common');
        $definition->addElement('article', 'Block', 'Flow', 'Common');
        $definition->addElement('aside', 'Block', 'Flow', 'Common');
        $definition->addElement('header', 'Block', 'Flow', 'Common');
        $definition->addElement('footer', 'Block', 'Flow', 'Common');
        $definition->addElement('address', 'Block', 'Flow', 'Common');
        $definition->addElement('hgroup', 'Block', 'Required: h1 | h2 | h3 | h4 | h5 | h6', 'Common');

        // http://developers.whatwg.org/grouping-content.html
        $definition->addElement('figure', 'Block', 'Optional: (figcaption, Flow) | (Flow, figcaption) | Flow', 'Common');
        $definition->addElement('figcaption', 'Inline', 'Flow', 'Common');

        // http://developers.whatwg.org/the-video-element.html#the-video-element
        $definition->addElement('video', 'Block', 'Optional: (source, Flow) | (Flow, source) | Flow', 'Common', [
            'src' => 'URI',
            'type' => 'Text',
            'width' => 'Length',
            'height' => 'Length',
            'poster' => 'URI',
            'preload' => 'Enum#auto,metadata,none',
            'controls' => 'Bool',
        ]);
        $definition->addElement('source', 'Block', 'Flow', 'Common', [
            'src' => 'URI',
            'type' => 'Text',
        ]);

        // http://developers.whatwg.org/interactive-elements.html
        $definition->addElement('details', 'Block', 'Flow', 'Common');
        $definition->addElement('summary', 'Inline', 'Flow', 'Common', [
            'open' => 'Bool',
        ]);

        // http://developers.whatwg.org/text-level-semantics.html
        $definition->addElement('u', 'Inline', 'Inline', 'Common');
        $definition->addElement('s', 'Inline', 'Inline', 'Common');
        $definition->addElement('var', 'Inline', 'Inline', 'Common');
        $definition->addElement('sub', 'Inline', 'Inline', 'Common');
        $definition->addElement('sup', 'Inline', 'Inline', 'Common');
        $definition->addElement('mark', 'Inline', 'Inline', 'Common');
        $definition->addElement('wbr', 'Inline', 'Empty', 'Core');

        // http://developers.whatwg.org/edits.html
        $definition->addElement('ins', 'Block', 'Flow', 'Common', ['cite' => 'URI', 'datetime' => 'CDATA']);
        $definition->addElement('del', 'Block', 'Flow', 'Common', ['cite' => 'URI', 'datetime' => 'CDATA']);

        $definition->addAttribute('table', 'height', 'Text');
        $definition->addAttribute('td', 'border', 'Text');
        $definition->addAttribute('th', 'border', 'Text');
        $definition->addAttribute('tr', 'width', 'Text');
        $definition->addAttribute('tr', 'height', 'Text');
        $definition->addAttribute('tr', 'border', 'Text');
    }
}
