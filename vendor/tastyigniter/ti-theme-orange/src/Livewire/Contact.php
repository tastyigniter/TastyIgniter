<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire;

use Igniter\Frontend\Actions\SendContactMail;
use Igniter\Local\Models\Location;
use Igniter\Main\Traits\ConfigurableComponent;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

final class Contact extends Component
{
    use ConfigurableComponent;

    #[Validate('required|max:128', as: 'igniter.orange::default.contact.text_select_subject')]
    public ?string $subject = null;

    #[Validate('required|email:filter|max:96', as: 'igniter.orange::default.contact.label_email')]
    public ?string $email = null;

    #[Validate('required|min:2|max:255', as: 'igniter.orange::default.contact.label_full_name')]
    public ?string $fullName = null;

    #[Validate('required', as: 'igniter.orange::default.contact.label_telephone')]
    public ?string $telephone = null;

    #[Validate('max:1500', as: 'igniter.orange::default.contact.label_comment')]
    public ?string $comment = null;

    public array $subjects = [
        'igniter.orange::default.contact.text_general_enquiry',
        'igniter.orange::default.contact.text_comment',
        'igniter.orange::default.contact.text_technical_issues',
    ];

    public ?string $message = null;

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::contact',
            'name' => 'igniter.orange::default.component_contact_title',
            'description' => 'igniter.orange::default.component_contact_desc',
        ];
    }

    public function render(): View
    {
        return view('igniter-orange::livewire.contact', [
            'locationDefault' => Location::getDefault(),
        ]);
    }

    public function onSubmit(): void
    {
        $this->validate();

        $data = [
            'full_name' => $this->fullName,
            'contact_topic' => $this->subject,
            'contact_email' => $this->email,
            'contact_telephone' => $this->telephone,
            'contact_message' => $this->comment,
        ];

        (new SendContactMail)($data);

        $this->reset();

        $this->message = lang('igniter.orange::default.contact.alert_contact_sent');
    }
}
