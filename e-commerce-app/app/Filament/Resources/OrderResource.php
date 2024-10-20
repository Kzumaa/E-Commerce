<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\Product;
use Cassandra\Numeric;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make("Order Information")->schema([
                        Select::make('user_id')->label('Customer')->required()
                            ->relationship('user', 'name')->preload()
                            ->searchable(),

                        Select::make('payment_method')->label('Payment method')->required()
                            ->options([
                                "cod" => "Cash on delivery",
                                "paypal" => "Paypal",
                                "stripe" => "Stripe",
                            ]),
                        Select::make('payment_status')->label('Payment status')->required()
                            ->options([
                                "pending" => "Pending",
                                "paid" => "Paid",
                                "failed" => "Failed",
                            ])->required()->default('pending'),

                        ToggleButtons::make('status')
                            ->label('Status')->inline()
                            ->options([
                                "new" => "New",
                                "processing" => "Processing",
                                "shipped" => "Shipped",
                                "delivered" => "Delivered",
                                "cancelled" => "Cancelled",
                            ])->required()->default('new')
                            ->colors([
                                "new" => "info",
                                "processing" => "warning",
                                "shipped" => "success",
                                "delivered" => "success",
                                "cancelled" => "danger",
                            ])->icons([
                                    "new" => "heroicon-m-sparkles",
                                    "processing" => "heroicon-m-arrow-path",
                                    "shipped" => "heroicon-m-truck",
                                    "delivered" => "heroicon-m-check-badge",
                                    "cancelled" => "heroicon-m-x-circle",
                            ]),

                        Select::make('currency')->label('Currency')->required()
                            ->options([
                                "usd" => "USD",
                                "eur" => "EUR",
                                "gbp" => "GBP",
                                "vnd" => "VND",
                                "yen" => "YEN",
                            ])->default('usd'),

                        Select::make("shipping_method")->label('Shipping method')
                            ->options([
                                "ups" => "UPS",
                                "fedex" => "FEDEX",
                                "amazon" => "AMAZON",
                            ]),

                        Forms\Components\Textarea::make('notes')->label('Note')->required()->columnSpanFull(),

                    ])->columns(2),

                    Section::make("Order Items")->schema([
                        Repeater::make("items")->relationship()->schema([
                            Select::make('product_id')->label('Product')->required()
                                ->relationship('product', 'name')->preload()->distinct()
                                ->searchable()->disableOptionsWhenSelectedInSiblingRepeaterItems()->columnSpan(4)
                                ->reactive()->afterStateUpdated(fn($state, Set $set) => $set('unit_amount', Product::find($state)?->price ?? 0) )
                                ->reactive()->afterStateUpdated(fn($state, Set $set) => $set('total_amount', Product::find($state)?->price ?? 0) )
                            ,
                            TextInput::make('quantity')->label('Quantity')->required()->numeric()->default(1)
                                ->minValue(1)->columnSpan(2)->reactive()->afterStateUpdated(fn ($state, Set $set, Get $get) => $set('total_amount', $state * $get('unit_amount'))),

                            TextInput::make("unit_amount")->label('Unit amount')->required()->disabled()->dehydrated()->columnSpan(3),

                            TextInput::make("total_amount")->label('Total amount')->required()->dehydrated()->columnSpan(3),
                        ])->columns(12),

                        Placeholder::make('total_price_placeholder')->label("Total price")
                            ->content(function (Get $get, Set $set) {
                                $total = 0;
                                if (!$repeaters = $get('items')) {
                                    return $total;
                                }

                                foreach ($repeaters as $key => $repeater) {
                                    $total += $get("items.{$key}.total_amount");
                                }

                                $set('total_price', $total);
                                return Number::currency($total, $get('currency'));
                            }),

                        Forms\Components\Hidden::make('total_price')->default(0),


                    ]),
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->sortable()->searchable()->label('Customer name'),

                Tables\Columns\TextColumn::make('total_price')->sortable()->numeric()->label('Total price')->money(fn (Model $record): string => $record->currency),

                Tables\Columns\TextColumn::make('payment_method')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('payment_status')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('currency')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('shipping_method')->searchable()->sortable(),

                Tables\Columns\SelectColumn::make('status')->options([
                        "new" => "New",
                        "processing" => "Processing",
                        "shipped" => "Shipped",
                        "delivered" => "Delivered",
                        "cancelled" => "Cancelled",
                    ])->searchable()->sortable(),

                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make(
                    [
                        Tables\Actions\ViewAction::make(),
                        Tables\Actions\EditAction::make(),
                        Tables\Actions\DeleteAction::make(),
                    ]
                ),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
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
