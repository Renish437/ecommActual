<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Intervention\Image\ImageManagerStatic as Image;





class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Grid::make()
                    ->schema([
                        TextInput::make('name')
                        ->required()
                        ->maxLength(255) // Removed the extra comma here
                        ->live(onBlur: true) // This will work now
                        ->afterStateUpdated(fn (string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                    
                    TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->disabled()
                        ->dehydrated()
                        ->unique(Category::class, 'slug', ignoreRecord: true),
                    
                    ]),
                    // FileUpload::make('image')
                    // ->image()
                    // ->directory('categories'),

                    

FileUpload::make('image')
    ->image()
    ->directory('categories')
    ->saveUploadedFileUsing(function ($file, $state, $set) {
        // Get the file's extension
        $extension = $file->getClientOriginalExtension();
        
        // Check if the extension is jfif
        if ($extension === 'jfif') {
            // Load and convert jfif image to jpg
            $image = Image::make($file)->encode('jpg');
            
            // Define the path for saving the image
            $path = 'categories/' . uniqid() . '.jpg';

            // Save the image to the disk
            \Storage::disk('public')->put($path, (string) $image);

            // Update the state with the new file path
            $set('image', $path);

            return $path;
        }

        // Save the image as usual for other formats
        return $file->storeAs('categories', $file->getClientOriginalName(), 'public');
    }),


                    Toggle::make('is_active')
                    ->required()
                    ->default(true),
                ])
               
           
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                    Tables\Columns\ImageColumn::make('image'),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),

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
                //
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
