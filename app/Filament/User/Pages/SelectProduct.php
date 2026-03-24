<?php

namespace App\Filament\User\Pages;

use App\Models\Product;
use Filament\Pages\Page;

class SelectProduct extends Page
{
    protected static ?string $title = 'Kalkulator';
    protected static ?string $navigationIcon = 'heroicon-o-calculator';
    protected static string $view = 'filament.user.pages.select-product';
    protected static ?string $slug = 'kalkulator';

    public $products;

    public function mount(): void
    {
        $this->products = Product::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }
}
