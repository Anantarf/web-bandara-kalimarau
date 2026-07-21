<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PpidDocumentResource\Pages;
use App\Models\PpidDocument;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PpidDocumentResource extends Resource
{
    protected static ?string $model = PpidDocument::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Layanan & Data';
    protected static ?string $modelLabel = 'Dokumen PPID';
    protected static ?string $pluralModelLabel = 'Dokumen PPID';
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Dokumen')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Dokumen')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Singkat')
                            ->columnSpanFull(),
                            
                        Forms\Components\FileUpload::make('file_path')
                            ->label('File Dokumen')
                            ->directory('ppid-documents')
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->maxSize(10240) // 10MB
                            ->required(),
                            
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif (Bisa dicari publik)')
                            ->default(true)
                            ->required(),
                            
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->default(now()),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->lineClamp(3),
                
                Tables\Columns\TextColumn::make('file_path')
                    ->label('File')
                    ->formatStateUsing(fn (string $state): string => 'Lihat/Download')
                    ->url(fn (PpidDocument $record): string => \Illuminate\Support\Facades\Storage::url($record->file_path))
                    ->openUrlInNewTab()
                    ->color('primary'),
                    
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean(),
                    
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPpidDocuments::route('/'),
            'create' => Pages\CreatePpidDocument::route('/create'),
            'edit' => Pages\EditPpidDocument::route('/{record}/edit'),
        ];
    }
}
