<?php

namespace System\Models;

use Igniter\Flame\Translation\Models\Translation;

class Translations_model extends Translation
{
    /**
     * Update and lock translation.
     * When loading translations into the database, locked translations will not be overwritten .
     *
     * @param $text
     *
     * @return bool
     * @throws \Exception
     */
    public function updateAndLock($text)
    {
        $this->text = $text;

        return $this->lockState()->save();
    }
}
