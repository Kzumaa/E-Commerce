<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
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


//                Tables\Columns\TextColumn::make('id'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
//                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('View Order')->url(fn (Order $record) => OrderResource::getUrl('view', ['record' => $record]))
                    ->color('info')->icon('heroicon-s-eye'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
