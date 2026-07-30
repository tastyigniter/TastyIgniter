<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic\Processors;

use Igniter\Flame\Pagic\Finder;
use Igniter\Flame\Pagic\Parsers\SectionParser;

class Processor
{
    /**
     * Process the results of a singular "select" query.
     */
    public function processSelect(Finder $finder, ?array $result): ?array
    {
        if ($result === null) {
            return null;
        }

        $fileName = array_get($result, 'fileName');

        return [$fileName => $this->parseTemplateContent($result, $fileName, $finder)];
    }

    /**
     * Process the results of a "select" query.
     */
    public function processSelectAll(Finder $finder, array $results): ?array
    {
        $items = [];

        foreach ($results as $result) {
            $fileName = array_get($result, 'fileName');
            $items[$fileName] = $this->parseTemplateContent($result, $fileName, $finder);
        }

        return $items;
    }

    /**
     * Helper to break down template content in to a useful array.
     */
    protected function parseTemplateContent(array $result, string $fileName, Finder $finder): array
    {
        $content = array_get($result, 'content');

        $processed = SectionParser::parse($content);

        return [
            'fileName' => $fileName,
            'mTime' => array_get($result, 'mTime'),
            'content' => $content,
            'markup' => $processed['markup'],
            'code' => $processed['code'],
            'settings' => $processed['settings'],
        ];
    }

    /**
     * Process the data in to an insert action.
     */
    public function processInsert(Finder $finder, array $data): string
    {
        return SectionParser::render($data);
    }

    /**
     * Process the data in to an update action.
     */
    public function processUpdate(Finder $finder, array $data): string
    {
        $existingData = $finder->getModel()->attributesToArray();

        return SectionParser::render($data + $existingData);
    }
}
