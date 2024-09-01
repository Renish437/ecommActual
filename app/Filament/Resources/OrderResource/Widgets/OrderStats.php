<?php

namespace App\Filament\Resources\OrderResource\Widgets;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;


class OrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            //
            Stat::make('New Orders',Order::query()->where('status','new')->count()),
            Stat::make('Order Processing', Order::query()->where('status', 'processing')->count()),
            Stat::make('Order Delivered', Order::query()->where('status', 'delivered')->count()),
            Stat::make('Order Shipped', Order::query()->where('status', 'shipped')->count()),
            Stat::make('Order Cancelled', Order::query()->where('status', 'cancelled')->count()),
            Stat::make('Average Price', function () {
                $avgPrice = Order::query()->avg('grand_total');
                return 'NPR ' . number_format($avgPrice, 2); }),
                // Stat::make('Total Orders', Order::query()->where('status', 'grand_total')->count()),
            // Stat::make('Average Price', Number::currency(Order::query()->avg('grand_total')),'NPR'),
        ];
    }
}
