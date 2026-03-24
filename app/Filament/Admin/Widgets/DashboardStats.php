<?php

namespace App\Filament\Admin\Widgets;

use App\Enums\UserRole;
use App\Models\Calculation;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        $countUsers = User::where('role', UserRole::USER)->count();
        $productsCount = Product::count();
        $calculationCount = Calculation::count();

        return [
            Stat::make('Liczba klientów', $countUsers),
            Stat::make('Ilość dostępnych produktów', $productsCount),
            Stat::make('Wykonane kalkulacje', $calculationCount),
        ];
    }
}
