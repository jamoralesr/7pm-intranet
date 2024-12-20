<?php

namespace App\Providers\Filament;

use Filament\Pages;
use BezhanSalleh\FilamentShield\Middleware\SyncShieldTenant;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Panel;
use App\Models\Space;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Http\Middleware\Authenticate;
use App\Filament\Pages\Tenancy\RegisterSpace;
use Illuminate\Session\Middleware\StartSession;
use App\Filament\Pages\Tenancy\EditSpaceProfile;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class IntranetPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('intranet')
            ->path('/')
            ->login()
            ->colors([
                'primary' => Color::Green,
            ])
            ->maxContentWidth(MaxWidth::Full)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->tenant(Space::class)
            ->tenant(Space::class, slugAttribute: 'slug')
            ->tenantRegistration(RegisterSpace::class)
            ->tenantProfile(EditSpaceProfile::class)
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->tenantMiddleware([
                SyncShieldTenant::class,
            ], isPersistent: true)
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
