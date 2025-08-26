<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Support\Collection;
use Filament\Notifications\Notification;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\DateTimePicker::make('email_verified_at')
                            ->label('Email Verified At'),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->maxLength(255),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Admin' => 'success',
                        'User' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label('Email Verification')
                    ->placeholder('All users')
                    ->trueLabel('Verified users')
                    ->falseLabel('Unverified users')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('email_verified_at'),
                        false: fn (Builder $query) => $query->whereNull('email_verified_at'),
                        blank: fn (Builder $query) => $query,
                    ),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Registered From'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Registered Until'),
                    ])
                    ->query(function (EloquentBuilder $query, array $data): EloquentBuilder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (EloquentBuilder $query, $date): EloquentBuilder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (EloquentBuilder $query, $date): EloquentBuilder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['created_from'] ?? null) {
                            $indicators[] = Indicator::make('Registered from ' . \Carbon\Carbon::parse($data['created_from'])->toFormattedDateString())
                                ->removeField('created_from');
                        }
                        if ($data['created_until'] ?? null) {
                            $indicators[] = Indicator::make('Registered until ' . \Carbon\Carbon::parse($data['created_until'])->toFormattedDateString())
                                ->removeField('created_until');
                        }
                        return $indicators;
                    }),
                Tables\Filters\Filter::make('recent_users')
                    ->label('Recent Users')
                    ->form([
                        Forms\Components\Select::make('period')
                            ->label('Period')
                            ->options([
                                'today' => 'Today',
                                'week' => 'This Week',
                                'month' => 'This Month',
                                'quarter' => 'This Quarter',
                            ])
                    ])
                    ->query(function (EloquentBuilder $query, array $data): EloquentBuilder {
                        return $query->when(
                            $data['period'],
                            function (EloquentBuilder $query, $period): EloquentBuilder {
                                return match ($period) {
                                    'today' => $query->whereDate('created_at', today()),
                                    'week' => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
                                    'month' => $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]),
                                    'quarter' => $query->whereBetween('created_at', [now()->startOfQuarter(), now()->endOfQuarter()]),
                                    default => $query,
                                };
                            }
                        );
                    })
                    ->indicateUsing(function (array $data): ?Indicator {
                        if ($data['period'] ?? null) {
                            return Indicator::make('Period: ' . match($data['period']) {
                                'today' => 'Today',
                                'week' => 'This Week',
                                'month' => 'This Month',
                                'quarter' => 'This Quarter',
                                default => $data['period'],
                            })->removeField('period');
                        }
                        return null;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('verify_email')
                        ->label('Verify Email')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->action(function (Collection $records) {
                            $records->each(fn ($record) => $record->update(['email_verified_at' => now()]));
                            Notification::make()
                                ->title('Users email verified successfully')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('unverify_email')
                        ->label('Unverify Email')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function (Collection $records) {
                            $records->each(fn ($record) => $record->update(['email_verified_at' => null]));
                            Notification::make()
                                ->title('Users email unverified successfully')
                                ->warning()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('reset_password')
                        ->label('Reset Password')
                        ->icon('heroicon-o-key')
                        ->color('warning')
                        ->form([
                            Forms\Components\TextInput::make('new_password')
                                ->label('New Password')
                                ->password()
                                ->required()
                                ->minLength(8)
                                ->same('new_password_confirmation'),
                            Forms\Components\TextInput::make('new_password_confirmation')
                                ->label('Confirm New Password')
                                ->password()
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data) {
                            $records->each(fn ($record) => $record->update([
                                'password' => Hash::make($data['new_password'])
                            ]));
                            Notification::make()
                                ->title('User passwords reset successfully')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('send_welcome_email')
                        ->label('Send Welcome Email')
                        ->icon('heroicon-o-envelope')
                        ->color('info')
                        ->action(function (Collection $records) {
                            // Welcome email functionality can be implemented here
                            Notification::make()
                                ->title('Welcome email functionality will be implemented')
                                ->info()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('export')
                        ->label('Export Selected')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('primary')
                        ->action(function (Collection $records) {
                            // Export functionality can be implemented here
                            Notification::make()
                                ->title('Export functionality will be implemented')
                                ->info()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return Gate::allows('manage-users');
    }

    public static function canCreate(): bool
    {
        return Gate::allows('manage-users');
    }

    public static function canEdit($record): bool
    {
        return Gate::allows('manage-users');
    }

    public static function canDelete($record): bool
    {
        return Gate::allows('manage-users');
    }

    // Removed navigation badge to improve performance
    // Badge was calling count() on every page load
    // public static function getNavigationBadge(): ?string
    // {
    //     return static::getModel()::count();
    // }
}