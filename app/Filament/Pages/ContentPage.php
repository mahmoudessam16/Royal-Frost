<?php

namespace App\Filament\Pages;

use App\Models\SiteContent;
use App\Support\Content;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Components\Attributes\Unexposed;
use Illuminate\Support\Str;
use UnitEnum;

/**
 * Edits the copy of one website page, in English and Arabic.
 *
 * The form is generated from the default texts in the site language files, so every
 * sentence on the page shows up here automatically. Only the differences from the
 * defaults are stored in the database.
 */
abstract class ContentPage extends Page
{
    protected static string | UnitEnum | null $navigationGroup = 'Website content';

    /** @var array<string, mixed> | null */
    public ?array $data = [];

    /** Top-level groups of the site language files that this page edits. */
    abstract protected static function groups(): array;

    /** Lists the admin may add to or remove from; every other list keeps its length. */
    private const FLEXIBLE_LISTS = ['chips', 'tags', 'regions'];

    private const LABELS = [
        'eyebrow' => 'Small label above the title',
        'accent' => 'Highlighted text (orange)',
        'title2' => 'Second line of title',
        'body' => 'Body text',
        'cta' => 'Button text',
        'desc' => 'Description',
        'lead' => 'Lead paragraph',
        'map_alt' => 'Map description (for accessibility)',
        'ph' => 'Placeholder',
        'name' => 'Name',
    ];

    public function mount(): void
    {
        $this->form->fill($this->currentData());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Tabs::make('Language')
                    ->persistTabInQueryString()
                    ->tabs([
                        Tab::make('English')->statePath('en')->schema($this->localeComponents('en')),
                        Tab::make('العربية (Arabic)')->statePath('ar')->schema($this->localeComponents('ar')),
                    ]),
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
                        Action::make('save')
                            ->label('Save changes')
                            ->submit('save')
                            ->keyBindings(['mod+s']),
                    ])->sticky()->key('form-actions'),
                ]),
        ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();

        foreach (Content::LOCALES as $locale) {
            $defaults = Content::defaults($locale);

            foreach (static::groups() as $group) {
                $edited = static::normalize($state[$locale][$group] ?? []);
                $changes = static::diff($defaults[$group] ?? [], $edited);

                if ($changes === []) {
                    SiteContent::where(['locale' => $locale, 'group' => $group])->get()->each->delete();
                } else {
                    SiteContent::updateOrCreate(['locale' => $locale, 'group' => $group], ['data' => $changes]);
                }
            }
        }

        Content::flush();

        Notification::make()->title('Saved. The website is updated.')->success()->send();
    }

    // ---------------------------------------------------------------- form data

    private function currentData(): array
    {
        $data = [];
        foreach (Content::LOCALES as $locale) {
            $data[$locale] = array_intersect_key(Content::forLocale($locale), array_flip(static::groups()));
        }

        return $data;
    }

    /** Repeater state is keyed by UUID; turn it back into plain lists. */
    private static function normalize(mixed $value): mixed
    {
        if (! is_array($value)) {
            return $value;
        }

        $value = array_map(fn ($v) => static::normalize($v), $value);

        $looksLikeRepeater = $value !== [] && collect(array_keys($value))->every(
            fn ($k) => is_string($k) && (Str::isUuid($k) || str_starts_with($k, 'record-') || str_starts_with($k, 'item-'))
        );

        return $looksLikeRepeater ? array_values($value) : $value;
    }

    /** Keep only what differs from the defaults. Lists are compared as a whole. */
    private static function diff(array $default, array $edited): array
    {
        $changes = [];

        foreach ($edited as $key => $value) {
            $base = $default[$key] ?? null;

            if (is_array($value) && is_array($base) && ! array_is_list($base)) {
                $nested = static::diff($base, $value);
                if ($nested !== []) {
                    $changes[$key] = $nested;
                }
            } elseif (static::clean($value) !== static::clean($base)) {
                $changes[$key] = static::clean($value);
            }
        }

        return $changes;
    }

    /** Treat an empty optional field the same as a missing one. */
    private static function clean(mixed $value): mixed
    {
        if (! is_array($value)) {
            return $value ?? '';
        }

        $isList = array_is_list($value);
        $clean = [];

        foreach ($value as $key => $item) {
            $item = static::clean($item);

            if (! $isList && ($item === null || $item === '')) {
                continue;
            }

            $clean[$key] = $item;
        }

        return $clean;
    }

    // ------------------------------------------------------------ form building

    private function localeComponents(string $locale): array
    {
        $defaults = Content::defaults($locale);
        $groups = static::groups();

        return collect($groups)->map(function (string $group) use ($defaults, $locale, $groups) {
            $fields = $this->components($defaults[$group] ?? [], $locale, $group, 0);

            return count($groups) > 1
                ? Section::make($this->label($group))->statePath($group)->collapsible()->collapsed()->schema($fields)
                : Group::make($fields)->statePath($group);
        })->all();
    }

    private function components(array $node, string $locale, string $path, int $depth): array
    {
        $components = [];

        foreach ($node as $key => $value) {
            $childPath = $path.'.'.$key;
            $label = $this->label((string) $key);

            if (is_array($value)) {
                if (! array_is_list($value)) {
                    $components[] = Section::make($label)
                        ->statePath((string) $key)
                        ->collapsible()
                        ->collapsed($depth === 0)
                        ->schema($this->components($value, $locale, $childPath, $depth + 1));
                } else {
                    $components[] = $this->listComponent((string) $key, $label, $value, $locale, $childPath);
                }

                continue;
            }

            $components[] = $this->input((string) $key, $label, (string) $value, $locale);
        }

        return $components;
    }

    private function input(string $key, string $label, string $default, string $locale): TextInput | Textarea
    {
        $long = mb_strlen($default) > 60 || in_array($key, ['body', 'lead', 'desc', 'text', 'result'], true);

        $field = $long
            ? Textarea::make($key)->rows(3)->autosize()
            : TextInput::make($key);

        if ($locale === 'ar') {
            $field->extraInputAttributes(['dir' => 'rtl']);
        }

        return $field->label($label);
    }

    private function listComponent(string $key, string $label, array $items, string $locale, string $path): Repeater
    {
        $flexible = in_array($key, self::FLEXIBLE_LISTS, true);

        $repeater = Repeater::make($key)
            ->label($label)
            ->collapsible()
            ->addable($flexible)
            ->deletable($flexible)
            ->reorderable($flexible);

        $first = $items[0] ?? '';

        // List of plain texts (chips, tags, regions, ...)
        if (! is_array($first)) {
            return $repeater->simple($this->input('value', 'Text', (string) $first, $locale));
        }

        // List of records. Union of keys, so optional fields (like a case study's description) can be filled.
        $template = array_replace(...array_map(fn ($i) => (array) $i, array_reverse($items)));
        $positional = array_is_list($template);
        $names = $positional ? $this->positionalLabels($path, count($template)) : [];

        $fields = $positional
            ? collect($template)->map(fn ($v, $i) => $this->input((string) $i, $names[$i] ?? 'Text '.($i + 1), (string) $v, $locale))->all()
            : $this->components($template, $locale, $path, 1);

        return $repeater
            ->schema($fields)
            ->itemLabel(function (array $state) {
                foreach (['title', 'label', 'index', 0, 1] as $candidate) {
                    if (isset($state[$candidate]) && is_string($state[$candidate]) && $state[$candidate] !== '') {
                        return Str::limit($state[$candidate], 50);
                    }
                }

                return 'Item';
            });
    }

    private function positionalLabels(string $path, int $count): array
    {
        return match (true) {
            str_ends_with($path, 'stats') => ['Number', 'Label'],
            str_ends_with($path, 'info') => ['Label', 'Value'],
            str_ends_with($path, 'story.items') => ['Year', 'Title', 'Text'],
            $count === 3 => ['Year', 'Title', 'Text'],
            default => ['Title', 'Text'],
        };
    }

    private function label(string $key): string
    {
        foreach (self::LABELS as $needle => $label) {
            if ($key === $needle || ($needle === 'ph' && str_ends_with($key, '_ph'))) {
                return $needle === 'ph' ? Str::headline(Str::beforeLast($key, '_ph')).' placeholder' : $label;
            }
        }

        return Str::headline($key);
    }
}
