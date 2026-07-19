<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use App\Models\FlightSchedule;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Penerbangan Aktif', FlightSchedule::count())
                ->description('Total jadwal penerbangan')
                ->descriptionIcon('heroicon-m-paper-airplane')
                ->color('primary'),

            Stat::make('Berita Diterbitkan', Post::count())
                ->description('Total berita/artikel')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('success'),

            Stat::make('Pesan Masuk', ContactMessage::count())
                ->description('Total pesan kontak')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('warning'),
        ];
    }
}
