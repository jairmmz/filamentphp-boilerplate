<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageGeneralSettings extends SettingsPage
{
    use HasPageShield;

    protected static ?int $navigationSort = 160;

    protected static string $settings = GeneralSettings::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|\UnitEnum|null $navigationGroup = 'Configuraciones';

    protected static ?string $navigationLabel = 'Sistema';

    protected static ?string $title = 'Sistema';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información General')
                    ->description('Datos principales del sitio web.')
                    ->icon(Heroicon::GlobeAlt)
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('site_name')
                                ->label('Nombre del sitio')
                                ->placeholder('Mi Empresa S.A.')
                                ->prefixIcon(Heroicon::Identification)
                                ->required()
                                ->maxLength(100)
                                ->validationMessages([
                                    'required' => 'El nombre del sitio es obligatorio.',
                                    'max' => 'El nombre no puede superar los 100 caracteres.',
                                ]),

                            TextInput::make('site_tagline')
                                ->label('Eslogan')
                                ->placeholder('Tu mejor opción en el mercado')
                                ->prefixIcon(Heroicon::ChatBubbleLeftEllipsis)
                                ->maxLength(160)
                                ->validationMessages([
                                    'max' => 'El eslogan no puede superar los 160 caracteres.',
                                ]),
                        ]),

                        Textarea::make('site_description')
                            ->label('Descripción del sitio')
                            ->placeholder('Breve descripción sobre qué hace tu sitio web...')
                            ->rows(2)
                            ->maxLength(500)
                            ->validationMessages([
                                'max' => 'La descripción no puede superar los 500 caracteres.',
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Información de Contacto')
                    ->description('Datos de contacto visibles en el sitio.')
                    ->icon(Heroicon::Phone)
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('contact_email')
                                ->label('Email de contacto')
                                ->placeholder('contacto@miempresa.com')
                                ->prefixIcon(Heroicon::Envelope)
                                ->email()
                                ->maxLength(254)
                                ->validationMessages([
                                    'email' => 'Ingresa un correo electrónico válido.',
                                    'max' => 'El email no puede superar los 254 caracteres.',
                                ]),

                            TextInput::make('contact_phone')
                                ->label('Teléfono de contacto')
                                ->placeholder('+51 987 654 321')
                                ->prefixIcon(Heroicon::Phone)
                                ->tel()
                                ->maxLength(20),

                            TextInput::make('address')
                                ->label('Dirección')
                                ->placeholder('Av. Principal 123, Lima, Perú')
                                ->prefixIcon(Heroicon::MapPin)
                                ->maxLength(255)
                                ->validationMessages([
                                    'max' => 'La dirección no puede superar los 255 caracteres.',
                                ]),
                        ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Branding y Medios')
                    ->description('Logotipos, favicon e imagen para redes sociales.')
                    ->icon(Heroicon::Photo)
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        Grid::make(2)->schema([
                            FileUpload::make('logo')
                                ->label('Logo (claro)')
                                ->helperText('Recomendado: PNG transparente, mín. 200×60 px.')
                                ->image()
                                ->imageEditor()
                                ->acceptedFileTypes(['image/png', 'image/svg+xml', 'image/webp'])
                                ->maxSize(2048)
                                ->directory('settings/logos')
                                ->validationMessages([
                                    'max' => 'El logo no debe superar los 2 MB.',
                                    'mimes' => 'Solo se permiten imágenes PNG, SVG o WebP.',
                                ]),

                            FileUpload::make('logo_dark')
                                ->label('Logo (oscuro)')
                                ->helperText('Versión del logo para fondos oscuros.')
                                ->image()
                                ->imageEditor()
                                ->acceptedFileTypes(['image/png', 'image/svg+xml', 'image/webp'])
                                ->maxSize(2048)
                                ->directory('settings/logos')
                                ->validationMessages([
                                    'max' => 'El logo oscuro no debe superar los 2 MB.',
                                    'mimes' => 'Solo se permiten imágenes PNG, SVG o WebP.',
                                ]),

                            FileUpload::make('favicon')
                                ->label('Favicon')
                                ->helperText('Recomendado: ICO o PNG de 32×32 px.')
                                ->image()
                                ->acceptedFileTypes(['image/x-icon', 'image/png', 'image/vnd.microsoft.icon'])
                                ->maxSize(512)
                                ->directory('settings/favicons')
                                ->validationMessages([
                                    'max' => 'El favicon no debe superar los 512 KB.',
                                    'mimes' => 'Solo se permiten archivos ICO o PNG.',
                                ]),

                            FileUpload::make('og_image')
                                ->label('Imagen OG (Open Graph)')
                                ->helperText('Recomendado: 1200×630 px, JPG o PNG.')
                                ->image()
                                ->imageEditor()
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                ->maxSize(4096)
                                ->directory('settings/og-images')
                                ->validationMessages([
                                    'max' => 'La imagen OG no debe superar los 4 MB.',
                                    'mimes' => 'Solo se permiten imágenes JPG, PNG o WebP.',
                                ]),
                        ]),
                    ])
                    ->columnSpanFull(),

                Section::make('SEO — Metadatos')
                    ->description('Información para motores de búsqueda.')
                    ->icon(Heroicon::MagnifyingGlass)
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('meta_title')
                                ->label('Meta título')
                                ->placeholder('Mi Empresa | Mejor opción del mercado')
                                ->prefixIcon(Heroicon::DocumentText)
                                ->maxLength(70)
                                ->helperText('Máximo recomendado: 60–70 caracteres.')
                                ->validationMessages([
                                    'max' => 'El meta título no puede superar los 70 caracteres.',
                                ]),

                            TextInput::make('meta_author')
                                ->label('Meta autor')
                                ->placeholder('Mi Empresa S.A.')
                                ->prefixIcon(Heroicon::User)
                                ->maxLength(100)
                                ->validationMessages([
                                    'max' => 'El meta autor no puede superar los 100 caracteres.',
                                ]),
                        ]),

                        Textarea::make('meta_description')
                            ->label('Meta descripción')
                            ->placeholder('Descripción breve del sitio para los resultados de búsqueda...')
                            ->rows(2)
                            ->maxLength(160)
                            ->helperText('Máximo recomendado: 150–160 caracteres.')
                            ->validationMessages([
                                'max' => 'La meta descripción no puede superar los 160 caracteres.',
                            ]),

                        TextInput::make('meta_keywords')
                            ->label('Meta palabras clave')
                            ->placeholder('empresa, servicios, lima, perú')
                            ->prefixIcon(Heroicon::Tag)
                            ->maxLength(255)
                            ->helperText('Separadas por comas. Uso limitado por Google actualmente.')
                            ->validationMessages([
                                'max' => 'Las palabras clave no pueden superar los 255 caracteres.',
                            ]),
                        Grid::make(2)
                            ->schema([
                                Select::make('meta_robots')
                                    ->label('Meta robots')
                                    ->placeholder('Selecciona una directiva...')
                                    ->prefixIcon(Heroicon::Cog6Tooth)
                                    ->options([
                                        'index,follow' => 'index, follow (predeterminado)',
                                        'index,nofollow' => 'index, nofollow',
                                        'noindex,follow' => 'noindex, follow',
                                        'noindex,nofollow' => 'noindex, nofollow',
                                        'noarchive' => 'noarchive',
                                        'nosnippet' => 'nosnippet',
                                        'noodp' => 'noodp',
                                        'none' => 'none (noindex, nofollow)',
                                    ])
                                    ->native(false)
                                    ->helperText('Controla cómo los bots indexan y siguen los enlaces.')
                                    ->validationMessages([
                                        'in' => 'Selecciona una directiva válida de robots.',
                                    ]),

                                TextInput::make('canonical_url')
                                    ->label('URL canónica')
                                    ->placeholder('https://www.miempresa.com')
                                    ->prefixIcon(Heroicon::Link)
                                    ->url()
                                    ->maxLength(255)
                                    ->helperText('URL principal del sitio para evitar contenido duplicado.')
                                    ->validationMessages([
                                        'url' => 'Ingresa una URL válida (debe incluir https://).',
                                        'max' => 'La URL no puede superar los 255 caracteres.',
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Open Graph')
                    ->description('Metadatos para compartir en Facebook, LinkedIn y similares.')
                    ->icon(Heroicon::Share)
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('og_title')
                                ->label('OG Título')
                                ->placeholder('Mi Empresa — Mejor opción')
                                ->prefixIcon(Heroicon::DocumentText)
                                ->maxLength(95)
                                ->helperText('Máximo recomendado: 95 caracteres.')
                                ->validationMessages([
                                    'max' => 'El OG título no puede superar los 95 caracteres.',
                                ]),

                            Select::make('og_type')
                                ->label('OG Tipo')
                                ->placeholder('Selecciona un tipo...')
                                ->prefixIcon(Heroicon::Square3Stack3d)
                                ->options([
                                    'website' => 'website',
                                    'article' => 'article',
                                    'product' => 'product',
                                    'profile' => 'profile',
                                    'book' => 'book',
                                    'music.song' => 'music.song',
                                    'video.movie' => 'video.movie',
                                ])
                                ->native(false)
                                ->validationMessages([
                                    'in' => 'Selecciona un tipo OG válido.',
                                ]),
                        ]),

                        Textarea::make('og_description')
                            ->label('OG Descripción')
                            ->placeholder('Descripción que aparecerá al compartir en redes sociales...')
                            ->rows(2)
                            ->maxLength(200)
                            ->helperText('Máximo recomendado: 200 caracteres.')
                            ->validationMessages([
                                'max' => 'La OG descripción no puede superar los 200 caracteres.',
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Analytics y Seguimiento')
                    ->description('IDs de plataformas de analítica y publicidad.')
                    ->icon(Heroicon::ChartBar)
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('google_analytics_id')
                                    ->label('Google Analytics ID')
                                    ->placeholder('G-XXXXXXXXXX')
                                    ->prefixIcon(Heroicon::Signal)
                                    ->regex('/^(UA-\d{4,10}-\d{1,4}|G-[A-Z0-9]{10})$/')
                                    ->maxLength(20)
                                    ->helperText('Formato: G-XXXXXXXXXX (GA4) o UA-XXXXXX-X.')
                                    ->validationMessages([
                                        'regex' => 'Ingresa un ID de Google Analytics válido (ej: G-XXXXXXXXXX).',
                                        'max' => 'El ID no puede superar los 20 caracteres.',
                                    ]),

                                TextInput::make('google_tag_manager_id')
                                    ->label('Google Tag Manager ID')
                                    ->placeholder('GTM-XXXXXXX')
                                    ->prefixIcon(Heroicon::Tag)
                                    ->regex('/^GTM-[A-Z0-9]{7}$/')
                                    ->maxLength(15)
                                    ->helperText('Formato: GTM-XXXXXXX.')
                                    ->validationMessages([
                                        'regex' => 'Ingresa un ID de GTM válido (ej: GTM-XXXXXXX).',
                                        'max' => 'El ID no puede superar los 15 caracteres.',
                                    ]),

                                TextInput::make('facebook_pixel_id')
                                    ->label('Facebook Pixel ID')
                                    ->placeholder('123456789012345')
                                    ->prefixIcon(Heroicon::CurrencyDollar)
                                    ->numeric()
                                    ->minLength(15)
                                    ->maxLength(16)
                                    ->helperText('ID numérico de 15–16 dígitos.')
                                    ->validationMessages([
                                        'numeric' => 'El Facebook Pixel ID debe ser numérico.',
                                        'min_digits' => 'El Pixel ID debe tener al menos 15 dígitos.',
                                        'max' => 'El Pixel ID no puede superar los 16 dígitos.',
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
