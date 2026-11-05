<?php

namespace App\Filament\Pages;

use App\Models\SiteImage;
use App\Support\ImageOptimizer;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Schema;
use Filament\Support\Components\Attributes\Unexposed;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\HtmlString;
use UnitEnum;

/**
 * Replace any photo on the website. Leave a slot empty to keep the original design image.
 * Uploads are resized and converted to WebP automatically.
 */
class ManageImages extends Page
{
    protected static ?string $navigationLabel = 'Images';

    protected static ?string $title = 'Website images';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static string | UnitEnum | null $navigationGroup = 'Website content';

    protected static ?int $navigationSort = 6;

    protected static ?string $slug = 'content/images';

    /** @var array<string, mixed> | null */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(SiteImage::overrides());
    }

    public function form(Schema $schema): Schema
    {
        $sections = [];

        foreach (SiteImage::catalog() as $section => $images) {
            $fields = [];

            foreach ($images as $key => [$label, $hint]) {
                $fields[] = FileUpload::make($key)
                    ->label($label)
                    ->helperText(new HtmlString(
                        e($hint).' · <a href="'.e(SiteImage::defaultUrl($key)).'" target="_blank" rel="noopener" style="text-decoration:underline">see original</a>'
                    ))
                    ->image()
                    ->imageEditor()
                    ->imagePreviewHeight('140')
                    ->disk('uploads')
                    ->directory('site')
                    ->visibility('public')
                    ->maxSize(12288)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']);
            }

            $sections[] = Section::make($section)
                ->collapsible()
                ->collapsed($section !== array_key_first(SiteImage::catalog()))
                ->schema([Grid::make(['default' => 1, 'md' => 2, 'xl' => 3])->schema($fields)]);
        }

        return $schema
            ->statePath('data')
            ->components([
                Text::make('Upload a photo to replace the original. Clear the slot (the × on the preview) to go back to the original image. JPG, PNG or WebP up to 12 MB; photos are shrunk and converted to WebP for speed.'),
                ...$sections,
            ]);
    }

    #[Unexposed]
    public function content(Schema $schema): Schema
    {
        return $schema->components([
            Form::make([EmbeddedSchema::make('form')])
                ->id('form')
                ->livewireSubmitHandler('save')
                ->footer([
                    Actions::make([
                        Action::make('save')->label('Save images')->submit('save')->keyBindings(['mod+s']),
                    ])->sticky()->key('form-actions'),
                ]),
        ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();
        $current = SiteImage::overrides();

        foreach (SiteImage::catalog() as $images) {
            foreach (array_keys($images) as $key) {
                $path = $state[$key] ?? null;
                if (is_array($path)) {
                    $path = reset($path) ?: null;
                }
                $old = $current[$key] ?? null;

                if (blank($path)) {
                    if ($old) {
                        @unlink(public_path('uploads/'.$old));
                        SiteImage::where('key', $key)->delete();
                    }

                    continue;
                }

                if ($path === $old) {
                    continue; // unchanged
                }

                $final = ImageOptimizer::optimize(public_path('uploads/'.$path), $key === 'hero' ? 2560 : 2000);
                $relative = 'site/'.basename($final);

                if ($old && $old !== $relative) {
                    @unlink(public_path('uploads/'.$old));
                }

                SiteImage::updateOrCreate(['key' => $key], ['path' => $relative]);
            }
        }

        $this->form->fill(SiteImage::overrides());

        Notification::make()->title('Images saved. The website is updated.')->success()->send();
    }
}
