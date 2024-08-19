<?php

namespace App\Service;

use Symfony\Contracts\Translation\TranslatorInterface;

class RoleTranslator
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function translate(string $role): string
    {
        return $this->translator->trans('roles.' . $role);
    }
}
