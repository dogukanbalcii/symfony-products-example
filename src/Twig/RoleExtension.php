<?php

namespace App\Twig;

use App\Service\RoleTranslator;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class RoleExtension extends AbstractExtension
{
    private RoleTranslator $roleTranslator;

    public function __construct(RoleTranslator $roleTranslator)
    {
        $this->roleTranslator = $roleTranslator;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('translate_role', [$this->roleTranslator, 'translate']),
        ];
    }
}

