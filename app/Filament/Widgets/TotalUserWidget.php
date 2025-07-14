<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\Widget;

class TotalUserWidget extends Widget
{
    protected static string $view = 'filament.widgets.total-user-widget';

    public function getTotal(): int
    {
        return User::count();
    }
}
