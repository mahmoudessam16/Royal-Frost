<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages\ListContactMessages;
use App\Models\ContactMessage;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $modelLabel = 'message';

    protected static ?string $navigationLabel = 'Messages';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedInbox;

    protected static ?int $navigationSort = 0;

    private const NEEDS = ['supplies' => 'General Supplies', 'contracting' => 'Contracting', 'export' => 'Export'];

    public static function getNavigationBadge(): ?string
    {
        $unread = ContactMessage::whereNull('read_at')->count();

        return $unread ? (string) $unread : null;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(2)->schema([
                TextEntry::make('name'),
                TextEntry::make('company')->placeholder('-'),
                TextEntry::make('email')->copyable(),
                TextEntry::make('phone')->placeholder('-'),
                TextEntry::make('need')->label('Interested in')->formatStateUsing(fn ($state) => self::NEEDS[$state] ?? $state),
                TextEntry::make('created_at')->label('Received')->dateTime('d M Y, H:i'),
                TextEntry::make('locale')->label('Site language')->formatStateUsing(fn ($state) => $state === 'ar' ? 'Arabic' : 'English'),
                TextEntry::make('emailed')->label('Emailed to the team')->formatStateUsing(fn ($state) => $state ? 'Yes' : 'No (saved here only)'),
            ]),
            TextEntry::make('subject')->placeholder('-')->columnSpanFull(),
            TextEntry::make('message')->placeholder('-')->columnSpanFull()->extraAttributes(['style' => 'white-space: pre-wrap']),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->emptyStateHeading('No messages yet')
            ->emptyStateDescription('Messages sent from the website contact form will appear here.')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->weight(fn (ContactMessage $record) => $record->read_at ? null : 'bold')
                    ->description(fn (ContactMessage $record) => $record->company),
                TextColumn::make('email')->searchable()->copyable(),
                TextColumn::make('need')
                    ->label('Interested in')
                    ->badge()
                    ->formatStateUsing(fn ($state) => self::NEEDS[$state] ?? $state),
                TextColumn::make('subject')->limit(40)->placeholder('-'),
                TextColumn::make('read_at')
                    ->label('Status')
                    ->badge()
                    ->state(fn (ContactMessage $record) => $record->read_at ? 'Read' : 'New')
                    ->color(fn (string $state) => $state === 'New' ? 'warning' : 'gray'),
                TextColumn::make('created_at')->label('Received')->since()->sortable(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->modalHeading(fn (ContactMessage $record) => 'Message from '.$record->name)
                    ->after(fn (ContactMessage $record) => $record->read_at ?: $record->update(['read_at' => now()])),
                Action::make('toggleRead')
                    ->label(fn (ContactMessage $record) => $record->read_at ? 'Mark as new' : 'Mark as read')
                    ->action(fn (ContactMessage $record) => $record->update(['read_at' => $record->read_at ? null : now()])),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return ['index' => ListContactMessages::route('/')];
    }
}
