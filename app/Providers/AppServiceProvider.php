<?php

namespace App\Providers;

use App\Rules\FieldRules\Blinds25\AluminiumAndWood25MountingTooltipRule;
use App\Rules\FieldRules\Blinds50\AluminiumAndWood50TooltipRule;
use App\Rules\FieldRules\CassetteBlinds\CassetteHeightRangeRule;
use App\Rules\FieldRules\CassetteBlinds\CassetteWidthRangeRule;
use App\Rules\FieldRules\CassetteBlinds\CassettePomiarCTooltipRule;
use App\Rules\FieldRules\CassetteBlinds\CassetteDimensionCValidationRule;
use App\Rules\FieldRules\CassetteBlinds\CassetteWymiarFMessageRule;
use App\Rules\FieldRules\FieldRuleManager;
use App\Rules\FieldRules\PleatedBlinds\PleatedDimensionTooltipRule;
use App\Rules\FieldRules\PleatedBlinds\PleatedDimensionUValidationRule;
use App\Rules\FieldRules\PleatedBlinds\PleatedHeightRangeRule;
use App\Rules\FieldRules\PleatedBlinds\PleatedWidthRangeRule;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use App\Rules\FieldRules\Blinds25\Aluminium25WidthRangeRule;
use App\Rules\FieldRules\Blinds25\Aluminium25HeightRangeRule;
use App\Rules\FieldRules\Blinds25\Wood25WidthRangeRule;
use App\Rules\FieldRules\Blinds25\Wood25HeightRangeRule;
use App\Rules\FieldRules\Blinds50\Aluminium50WidthRangeRule;
use App\Rules\FieldRules\Blinds50\Aluminium50HeightRangeRule;
use App\Rules\FieldRules\Blinds50\Wood50WidthRangeRule;
use App\Rules\FieldRules\Blinds50\Wood50HeightRangeRule;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FieldRuleManager::class, function () {
            return new FieldRuleManager([
                new CassetteWidthRangeRule(),
                new CassetteHeightRangeRule(),
                new CassettePomiarCTooltipRule(),
                new CassetteDimensionCValidationRule(),
                new CassetteWymiarFMessageRule(),
                new PleatedWidthRangeRule(),
                new PleatedHeightRangeRule(),
                new PleatedDimensionUValidationRule(),
                new PleatedDimensionTooltipRule(),
                new Aluminium25WidthRangeRule(),
                new Aluminium25HeightRangeRule(),
                new AluminiumAndWood25MountingTooltipRule(),
                new Wood25WidthRangeRule(),
                new Wood25HeightRangeRule(),
                new Aluminium50WidthRangeRule(),
                new Aluminium50HeightRangeRule(),
                new Wood50WidthRangeRule(),
                new Wood50HeightRangeRule(),
                new AluminiumAndWood50TooltipRule(),
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production' && config('app.url') !== 'http://localhost') {
            URL::forceScheme('https');
        }

        Event::listen(Login::class, function (Login $event): void {
            activity()
                ->causedBy($event->user)
                ->log('Logowanie do systemu');
        });
    }
}
