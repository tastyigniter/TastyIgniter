<?php

declare(strict_types=1);

namespace Core\Authentication;

use CoreInterfaces\Core\Authentication\AuthGroup;
use CoreInterfaces\Core\Authentication\AuthInterface;
use CoreInterfaces\Core\Request\RequestSetterInterface;
use CoreInterfaces\Core\Request\TypeValidatorInterface;
use InvalidArgumentException;

/**
 * Use to group multiple Auth schemes with either `AND` or `OR`
 */
class Auth implements AuthInterface
{
    /**
     * @param self|string ...$auths
     */
    public static function and(...$auths): self
    {
        return new self($auths, AuthGroup::AND);
    }

    /**
     * @param self|string ...$auths
     */
    public static function or(...$auths): self
    {
        return new self($auths, AuthGroup::OR);
    }

    /**
     * @var array
     */
    private $auths;

    /**
     * @var array<string,AuthInterface>
     */
    private $authGroups = [];

    /**
     * @var string
     */
    private $groupType;
    private $isValid = false;

    /**
     * @param array $auths
     * @param string $groupType
     */
    private function __construct(array $auths, string $groupType)
    {
        $this->auths = $auths;
        $this->groupType = $groupType;
    }

    /**
     * @param array<string,AuthInterface> $authManagers
     */
    public function withAuthManagers(array $authManagers): self
    {
        $this->authGroups = array_map(function ($auth) use ($authManagers) {
            if (is_string($auth) && isset($authManagers[$auth])) {
                return $authManagers[$auth];
            } elseif ($auth instanceof Auth) {
                return $auth->withAuthManagers($authManagers);
            }
            throw new InvalidArgumentException("AuthManager not found with name: " . json_encode($auth));
        }, $this->auths);
        return $this;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function validate(TypeValidatorInterface $validator): void
    {
        $success = empty($this->authGroups);
        $errors = array_map(function ($authGroup) use ($validator, &$success) {
            try {
                $authGroup->validate($validator);
                if ($this->groupType == AuthGroup::OR) {
                    $success = true;
                }
                return false;
            } catch (InvalidArgumentException $e) {
                if ($this->groupType == AuthGroup::AND) {
                    throw $e;
                }
                return $e->getMessage();
            }
        }, $this->authGroups);
        if ($success) {
            $this->isValid = true;
            return;
        }
        if ($this->groupType == AuthGroup::AND) {
            $this->isValid = true;
            return;
        }
        throw new InvalidArgumentException("Missing required auth credentials:\n-> " .
            join("\n-> ", array_filter($errors)));
    }

    /**
     * @throws InvalidArgumentException
     */
    public function apply(RequestSetterInterface $request): void
    {
        if (!$this->isValid) {
            return;
        }
        $this->authGroups = array_map(function ($authGroup) use ($request) {
            $authGroup->apply($request);
            return $authGroup;
        }, $this->authGroups);
    }
}
