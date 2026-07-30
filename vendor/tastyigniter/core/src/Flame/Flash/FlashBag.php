<?php

declare(strict_types=1);

namespace Igniter\Flame\Flash;

use Illuminate\Support\Collection;

class FlashBag
{
    protected string $sessionKey = '_ti_flash';

    public ?Collection $messages = null;

    public function __construct(protected FlashStore $store) {}

    public function setSessionKey(string $key): self
    {
        $this->sessionKey = $key;

        return $this;
    }

    public function getSessionKey(): string
    {
        return $this->sessionKey;
    }

    public function messages(): Collection
    {
        if (!is_null($this->messages)) {
            return $this->messages;
        }

        return $this->messages = $this->store->get($this->sessionKey, collect());
    }

    /**
     * Gets all the flash messages
     */
    public function all(): Collection
    {
        $messages = $this->messages();

        $this->clear();

        return $messages;
    }

    public function set(?string $level = null, ?string $message = null): FlashBag
    {
        return $this->message($message, $level);
    }

    /**
     * Flash a generic message.
     */
    public function alert(string $message): self
    {
        return $this->message($message);
    }

    /**
     * Flash an information message.
     */
    public function info(string $message): self
    {
        return $this->message($message, 'info');
    }

    /**
     * Flash a success message.
     */
    public function success(string $message): self
    {
        return $this->message($message, 'success');
    }

    /**
     * Flash an error message.
     */
    public function error(string $message): self
    {
        return $this->message($message, 'danger');
    }

    /**
     * Flash an error message.
     */
    public function danger(string $message): self
    {
        return $this->error($message);
    }

    /**
     * Flash a warning message.
     */
    public function warning(string $message): self
    {
        return $this->message($message, 'warning');
    }

    /**
     * Flash a general message.
     */
    public function message(null|string|Message $message = null, ?string $level = null): self
    {
        // If no message was provided, we should update
        // the most recently added message.
        if (is_null($message)) {
            return $this->updateLastMessage(['level' => $level]);
        }

        if (!$message instanceof Message) {
            $message = new Message(['message' => $message, 'level' => $level]);
        }

        $this->messages()->push($message);

        return $this->flash();
    }

    /**
     * Modify the most recently added message.
     */
    protected function updateLastMessage(array $overrides = []): self
    {
        $this->messages()->last()->update($overrides);

        return $this;
    }

    /**
     * Flash an overlay modal.
     */
    public function overlay(?string $message = null, string $title = '', string $level = 'success'): FlashBag
    {
        if (!$message) {
            $this->updateLastMessage(['title' => $title, 'level' => $level, 'overlay' => true, 'important' => true]);

            return $this->message(new OverlayMessage($this->messages()->last()->toArray()))->important();
        }

        return $this->message(new OverlayMessage(['title' => $title, 'level' => $level, 'message' => $message]))->important();
    }

    /**
     * Add a "now" flash to the store.
     */
    public function now(): self
    {
        return $this->updateLastMessage(['now' => true]);
    }

    /**
     * Add an "important" flash to the store.
     */
    public function important(): self
    {
        return $this->updateLastMessage(['important' => true]);
    }

    public function actionUrl(string $url, ?string $text = null): self
    {
        return $this->updateLastMessage(['actionUrl' => $url, 'actionText' => $text]);
    }

    /**
     * Clear all registered messages.
     */
    public function clear(): self
    {
        $this->store->forget($this->sessionKey);

        $this->messages = collect();

        return $this;
    }

    /**
     * Flash all messages to the store.
     */
    protected function flash(): self
    {
        $this->store->flash($this->sessionKey, $this->messages());

        return $this;
    }
}
