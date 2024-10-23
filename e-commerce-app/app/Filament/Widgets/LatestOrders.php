<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;

class LatestOrders extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->searchable()->label("Order ID"),
                TextColumn::make('total_price')->sortable()->searchable()->money(fn (Model $record): string => $record->currency),
                Tables\Columns\TextColumn::make('status')->badge()->color(fn (string $state): string => match ($state) {
                    "new" => "info",
                    "processing" => "warning",
                    "shipped", "delivered" => "success",
                    "cancelled" => "danger",
                })->icon(fn (string $state): string => match ($state) {
                    "new" => "heroicon-m-sparkles",
                    "processing" => "heroicon-m-arrow-path",
                    "shipped" => "heroicon-m-truck",
                    "delivered" => "heroicon-m-check-badge",
                    "cancelled" => "heroicon-m-x-circle",
                })->sortable(),

                Tables\Columns\TextColumn::make('payment_method')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('payment_status')->sortable()->searchable()->badge(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),


            ])
            ->actions([
                Tables\Actions\Action::make('View Order')->url(fn (Order $record) => OrderResource::getUrl('view', ['record' => $record]))
                    ->color('info')->icon('heroicon-s-eye'),
            ]);
    }
}
