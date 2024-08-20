<?php

namespace App\Filament\Resources;



use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Illuminate\Support\Str;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

use Filament\Forms\Components\Placeholder;
use Illuminate\Support\Number;
use App\Models\Product; 



use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\SelectColumn;

use Filament\Forms\Components\Hidden;
use Illuminate\Support\Facades\Log; // For logging
 // For string operations (if needed)




// use Filament\Forms\Component\Product;




class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
Group::make()->schema([
    Section::make('Order Information')->schema([
        Select::make('user_id')
        ->label('Customer')
        ->relationship('user','name')
        ->searchable()
        ->preload()
        ->required(),

        Select::make('payment_method')
        ->options([
            'strive'=>'Stripe',
            'cod'=>'Cash On Delivery',

        ])
        ->required(),

        Select::make('payment_status')
        ->options([
            'pending'=>'Pending',
            'paid'=>'Paid',
            'falied'=>'Failed',
        ])
        ->default('pending')
        ->required(),

        ToggleButtons::make('status')
        ->inline()
        ->default('new')
        ->required()
        ->options([
            'new'=>'New',
            'processing'=>'Processing',
            'shipped'=>'Shipped',
            'delivered'=>'Delivered',
            'cancelled'=>'Cancelled',
        ])
        ->colors([
            'new'=>'info',
            'processing'=>'warning',
            'shipped'=>'success',
            'delivered'=>'success',
            'cancelled'=>'danger',
        ])
        ->icons([
            'new'=>'heroicon-m-sparkles',
            'processing'=>'heroicon-m-arrow-path',
            'shipped'=>'heroicon-m-truck',
            'delivered'=>'heroicon-m-check-badge',
            'cancelled'=>'heroicon-m-x-circle',

        ]),
        Select::make('currency')
        ->Options([
            'npr'=>'NPR',
            'inr'=>'INR',
            'usd'=>'USD',
            'eur'=>'EUR',
        ])
        ->default('npr')
        ->required(),

        Select::make('shipping_method')
        ->options([
            'fedex'=>'FedEx',
            'ups'=>'UPS',
            'dhl'=>'DHL',
            'usps'=>'USPS',
        ]),

        Textarea::make('notes')
       
        ->columnSpanFull(),
       
    ]) ->columns(2),
    Section::make('Order Items')->schema([
        Repeater::make('items')
        ->relationship()
        ->schema([
        //     Select::make('product_id')
        //     ->relationship('product','name')
        //     ->searchable()
        //     ->preload()
        //     ->required()
        //     ->distinct()
        //     ->disableOptionsWhenSelectedInSiblingRepeaterItems()
        //     ->columnSpan(4)
        //     ->reactive()
        //     ->afterStateUpdated(fn($state, Set $set) => $set('unit_amount', ($product = Product::find($state)) ? $product->price : 0)),


        //     TextInput::make('quantity')
        //     ->numeric()
        //     ->required()
        //     ->default(1)
        //     ->minValue(1)
        //     ->columnSpan(2)
        //     ->reactive()
        //     ->afterStateUpdated(fn($state, Set $set, Get $get) => 
        //     $set('total_amount', $state * $get('unit_amount'))  // Calculate total_amount as quantity * unit_amount
        // ),

        //     TextInput::make('unit_amount')
        //     ->numeric()
        //     ->required()
        //     ->disabled()
        //     ->columnSpan(3),

        //     TextInput::make('total_amount')
        //     ->numeric()
        //     ->required()
        //     ->columnSpan(3),


        Select::make('product_id')
    ->relationship('product', 'name')
    ->searchable()
    ->preload()
    ->required()
    ->distinct()
    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
    ->columnSpan(4)
    ->reactive()
    ->afterStateUpdated(function ($state, callable $set, callable $get) {
        $product = Product::find($state);
        $unitPrice = $product ? $product->price : 0;

        // Set unit amount based on the selected product
        $set('unit_amount', $unitPrice);

        // Recalculate total amount based on the quantity and unit price
        $quantity = $get('quantity') ?? 1;
        $set('total_amount', $unitPrice * $quantity);
    }),
    
    


TextInput::make('quantity')
    ->numeric()
    ->required()
    ->default(1)
    ->minValue(1)
    ->columnSpan(2)
    ->reactive()
    ->afterStateUpdated(function ($state, callable $set, callable $get) {
        // Fetch and ensure numeric value for unit amount
        $unitPrice = $get('unit_amount');
        if (!is_numeric($unitPrice)) {
            $unitPrice = 0;
        }

        // Ensure the state is numeric
        $quantity = is_numeric($state) ? $state : 0;

        // Debug values
        \Log::info('Quantity:', ['quantity' => $quantity]);
        \Log::info('Unit Price:', ['unitPrice' => $unitPrice]);

        // Calculate total amount
        $totalAmount = $quantity * $unitPrice;

        // Debug total amount
        \Log::info('Total Amount:', ['totalAmount' => $totalAmount]);

        // Set total amount
        $set('total_amount', $totalAmount);
    }),


    // ->afterStateUpdated(function ($state, callable $set, callable $get) {
    //     $unitPrice = $get('unit_amount') ?? 0;

    //     // Recalculate total amount based on the quantity and unit price
    //     $set('total_amount', $state * $unitPrice);
    // }),

TextInput::make('unit_amount')
    ->numeric()
    ->required()
    ->disabled()
    ->columnSpan(3)
    ->dehydrated(),// Format to remove decimal places


TextInput::make('total_amount')
    ->numeric()
    ->required()
    ->disabled() 
    ->dehydrated() // Disable to prevent manual editing
    ->columnSpan(3),

            

        ])->columns(12),

        Placeholder::make('grand_total_placeholder')
        ->label('Grand Total')
        ->content(function (Get $get,Set $set) {
            $total = 0;
            $repeaters = $get('items');
    
            if ($repeaters) {
                foreach ($repeaters as $key => $repeater) {
                    $total += $get("items.{$key}.total_amount");
                }
                $set('grand_total',$total);
            }
            
            // Format total as currency
            return Number::currency($total, 'NPR');
           
        }),

        Hidden::make('grand_total')
        ->default(0)
    
    ])
])->columnSpanFull()
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                ->label('Customer')
                ->sortable()
                ->searchable(),
                TextColumn::make('grand_total')
                ->numeric()
                ->sortable()
                ->money('NPR'),

                TextColumn::make('payment_method')
                ->searchable()
                ->sortable(),

                TextColumn::make('payment_status')
                ->searchable()
                ->sortable(),

                TextColumn::make('currency')
                ->sortable()
                ->searchable(),
                TextColumn::make('shipping_method')
                ->sortable()
                ->searchable(),


                SelectColumn::make('status')
                ->options([
                    'new'=>'New',
            'processing'=>'Processing',
            'shipped'=>'Shipped',
            'delivered'=>'Delivered',
            'cancelled'=>'Cancelled',
                ])
                ->searchable()
                ->sortable(),

                TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

                //
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

                // Tables\Actions\ViewAction::make(),
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

    public static function getNavigationBadge(): ?string{
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null {
        return static::getModel()::count()>10 ?'success':'danger';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
