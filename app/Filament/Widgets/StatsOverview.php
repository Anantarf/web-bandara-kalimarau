<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use App\Models\FlightSchedule;
use App\Models\Post;
use App\Models\PpidDocument;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $unreadMessagesCount = ContactMessage::query()->where('status', 'new')->count();

        return [
            Stat::make('Penerbangan Aktif', FlightSchedule::query()->where('is_active', true)->count())
                ->description('Rute penerbangan aktif')
                ->descriptionIcon('heroicon-o-paper-airplane')
                ->color('success'),

            Stat::make('Berita Diterbitkan', Post::query()->where('status', 'published')->count())
                ->description('Total berita publik')
                ->descriptionIcon('heroicon-o-newspaper')
                ->color('info'),

            Stat::make('Pengaduan Baru', $unreadMessagesCount)
                ->description($unreadMessagesCount > 0 ? "{$unreadMessagesCount} pesan belum dibaca" : 'Semua pesan dibaca')
                ->descriptionIcon('heroicon-o-envelope')
                ->color($unreadMessagesCount > 0 ? 'warning' : 'gray'),

            Stat::make('Dokumen PPID', PpidDocument::query()->where('is_active', true)->count())
                ->description('Dokumen publik aktif')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('primary'),
        ];
    }
}
