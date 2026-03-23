<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\CalendarWidget;

class CalendarPage extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $title = 'Bakım Takvimi';
    protected static ?string $navigationLabel = 'Takvim';
    protected static ?string $slug = 'takvim';

    protected string $view = 'filament.pages.calendar-page';

    protected function getHeaderWidgets(): array
    {
        return [
            CalendarWidget::class,
        ];
    }
}
