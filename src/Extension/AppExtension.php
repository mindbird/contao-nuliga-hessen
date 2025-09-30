<?php

declare(strict_types=1);

namespace Mindbird\ContaoNuligaHessen\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function __construct()
    {
    }

    #[\Override]
    public function getFunctions(): array
    {
        return [
            new TwigFunction('getGermanWeekday', $this->getGermanWeekday(...), ['is_safe' => ['html']]),
        ];
    }

    public function getGermanWeekday(string $weekday): string
    {
        return match ($weekday) {
            'Mon' => 'Montag',
            'Tue' => 'Dienstag',
            'Wed' => 'Mittwoch',
            'Thu' => 'Donnerstag',
            'Fri' => 'Freitag',
            'Sat' => 'Samstag',
            'Sun' => 'Sonntag',
            default => $weekday,
        };
    }
}
