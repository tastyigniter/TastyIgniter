<?php

namespace othernamespace;

use namespacetest\model\Group;

class Programmers extends Group
{
    /**
     * @maps language
     * @var string
     */
    public $language;

    /**
     * @maps languageUser
     * @var \namespacetest\model\User
     */
    public $languageUser;
}
