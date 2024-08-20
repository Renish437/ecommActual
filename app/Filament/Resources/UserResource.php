<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               Forms\Components\TextInput::make('name')
                ->required(),
              
                Forms\Components\TextInput::make('email')
                ->label('Email Address')
                ->email()
                ->maxlength(255)
                ->unique(ignoreRecord:true)
                ->required(),
              
                Forms\Components\DateTimePicker::make('email_verifed_at')
                ->label('Email Verifed At')
                ->default(now()),

                Forms\Components\TextInput::make('password')
                ->required()
                ->password()
                ->dehydrated(fn($state)=> filled($state)),
                // ->required(fn (Page $livewire): bool => $liveware instanceOf CreateRecord),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('name')
             ->searchable()
             ,
            Tables\Columns\TextColumn::make('email')
             ->searchable(),
             
             Tables\Columns\TextColumn::make('email_verified_at')
            ->dateTime()
            ->sortable(),

             Tables\Columns\TextColumn::make('created_at')
             ->dateTime()
            ->sortable(),

            
            
            //  Tables\Columns\DateTimeColumn::make('email_verfied_at'),

            ])
            ->filters([
                //
            ])
            ->actions([

                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
                    
    
                
                
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
