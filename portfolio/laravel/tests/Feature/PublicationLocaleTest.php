<?php

namespace Tests\Feature;

use App\Models\Publication;
use App\Models\PublicationTranslation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PublicationLocaleTest extends TestCase
{
    use RefreshDatabase;

    private const TOKEN = 'test-import-token';

    protected function setUp(): void
    {
        parent::setUp();
        config(['services.publication_import.token' => self::TOKEN]);
        \Illuminate\Support\Facades\RateLimiter::clear('');
        app('cache')->flush();
    }

    private function addArticleUrl(string $target, string $locale): string
    {
        return '/api/publications/addArticle/'.self::TOKEN.'/'.rawurlencode($target).'?locale='.$locale;
    }

    private function publication(string $url, array $attributes = []): Publication
    {
        return Publication::create(array_merge([
            'url' => $url,
            'url_hash' => hash('sha256', $url),
            'icon' => 'fas fa-newspaper',
            'title' => 'عنوان فارسی',
            'venue' => 'وبلاگ',
            'category' => 'وب',
            'description' => 'توضیح فارسی',
            'is_published' => true,
        ], $attributes));
    }

    private function translation(Publication $publication, string $locale, array $attributes = []): PublicationTranslation
    {
        return PublicationTranslation::create(array_merge([
            'publication_id' => $publication->id,
            'locale' => $locale,
            'title' => "{$locale} title",
            'venue' => "{$locale} venue",
            'category' => "{$locale} category",
            'description' => "{$locale} description",
            'status' => 'approved',
        ], $attributes));
    }

    public function test_index_returns_only_approved_translations_for_requested_locale(): void
    {
        $both = $this->publication('https://example.com/both');
        $this->translation($both, 'fa', ['title' => 'فارسی']);
        $this->translation($both, 'en', ['title' => 'English']);

        $persianOnly = $this->publication('https://example.com/fa-only');
        $this->translation($persianOnly, 'fa', ['title' => 'فقط فارسی']);

        $draftEnglish = $this->publication('https://example.com/draft');
        $this->translation($draftEnglish, 'fa', ['title' => 'پیش‌نویس']);
        $this->translation($draftEnglish, 'en', ['status' => 'draft', 'title' => 'Draft']);

        $this->getJson('/api/publications?locale=en')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'English')
            ->assertJsonPath('data.0.url', 'https://example.com/both')
            ->assertJsonMissing(['title' => 'فارسی'])
            ->assertJsonMissing(['title' => 'فقط فارسی'])
            ->assertJsonMissing(['title' => 'Draft']);
    }

    public function test_index_defaults_to_persian_and_returns_the_existing_shape(): void
    {
        $publication = $this->publication('https://example.com/persian');
        $this->translation($publication, 'fa', [
            'title' => 'عنوان',
            'venue' => 'منبع',
            'category' => 'دسته',
            'description' => 'شرح',
        ]);

        $this->getJson('/api/publications')
            ->assertOk()
            ->assertExactJson([
                'data' => [
                    [
                        'icon' => 'fas fa-newspaper',
                        'title' => 'عنوان',
                        'venue' => 'منبع',
                        'category' => 'دسته',
                        'desc' => 'شرح',
                        'url' => 'https://example.com/persian',
                        'delay' => '',
                    ],
                ],
            ]);
    }

    public function test_index_never_falls_back_to_base_persian_text_for_english(): void
    {
        $this->publication('https://example.com/untranslated');

        $this->getJson('/api/publications?locale=en')
            ->assertOk()
            ->assertExactJson(['data' => []]);
    }

    public function test_index_hides_unpublished_articles_until_admin_approves(): void
    {
        $hidden = $this->publication('https://example.com/unpublished', ['is_published' => false]);
        $this->translation($hidden, 'en');

        $this->getJson('/api/publications?locale=en')
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }
    public function test_index_rejects_unsupported_locale(): void
    {
        $this->getJson('/api/publications?locale=de')
            ->assertUnprocessable()
            ->assertJsonPath('message', 'Invalid locale.');
    }

    public function test_index_limits_results_to_four_items(): void
    {
        foreach (range(1, 5) as $i) {
            $publication = $this->publication("https://example.com/item-{$i}");
            $this->translation($publication, 'en');
        }

        $this->getJson('/api/publications?locale=en')
            ->assertOk()
            ->assertJsonCount(4, 'data');
    }

    public function test_import_stores_english_translation_without_changing_persian(): void
    {
        $publication = $this->publication('https://93.184.216.34/shared', ['title' => 'Persian base']);
        $this->translation($publication, 'fa', ['title' => 'عنوان فارسی']);

        $this->postJson('/api/publications/import', [
            'url' => 'https://93.184.216.34/shared',
            'locale' => 'en',
            'title' => 'English title',
            'venue' => 'English venue',
            'category' => 'Web',
            'description' => 'English description',
        ], ['Authorization' => 'Bearer '.self::TOKEN])
            ->assertCreated()
            ->assertJsonPath('data.title', 'English title');

        $this->assertDatabaseCount('publications', 1);
        $this->assertDatabaseHas('publication_translations', [
            'publication_id' => $publication->id,
            'locale' => 'en',
            'title' => 'English title',
            'status' => 'approved',
        ]);
        $this->assertDatabaseHas('publication_translations', [
            'publication_id' => $publication->id,
            'locale' => 'fa',
            'title' => 'عنوان فارسی',
        ]);
    }

    public function test_import_defaults_to_persian_when_locale_is_omitted(): void
    {
        $this->postJson('/api/publications/import', [
            'url' => 'https://93.184.216.34/default-locale',
            'title' => 'Default title',
            'venue' => 'Venue',
            'category' => 'Category',
            'description' => 'Description',
        ], ['Authorization' => 'Bearer '.self::TOKEN])
            ->assertCreated();

        $this->assertDatabaseHas('publication_translations', [
            'locale' => 'fa',
            'title' => 'Default title',
            'status' => 'approved',
        ]);
    }

    public function test_import_rejects_missing_or_wrong_token(): void
    {
        $payload = ['url' => 'https://93.184.216.34/unauthorized', 'title' => 'T'];

        $this->postJson('/api/publications/import', $payload)->assertUnauthorized();
        $this->postJson('/api/publications/import', $payload, ['Authorization' => 'Bearer wrong'])
            ->assertUnauthorized();

        $this->assertDatabaseCount('publications', 0);
    }

    public function test_import_rejects_invalid_locale(): void
    {
        $this->postJson('/api/publications/import', [
            'url' => 'https://93.184.216.34/bad-locale',
            'locale' => 'de',
            'title' => 'T',
            'venue' => 'V',
            'category' => 'C',
            'description' => 'D',
        ], ['Authorization' => 'Bearer '.self::TOKEN])
            ->assertUnprocessable();

        $this->assertDatabaseCount('publications', 0);
    }

    public function test_add_article_stores_translation_for_requested_locale(): void
    {
        Http::fake([
            'https://93.184.216.34/add-article' => Http::response(
                '<html><head><meta property="og:title" content="Fetched title">'
                .'<meta property="og:description" content="Fetched description"></head></html>',
                200
            ),
        ]);

        $target = 'https://93.184.216.34/add-article';

        $this->postJson($this->addArticleUrl($target, 'en'))
            ->assertCreated()
            ->assertJsonPath('data.title', 'Fetched title');

        $publication = Publication::where('url', $target)->firstOrFail();
        $this->assertDatabaseHas('publication_translations', [
            'publication_id' => $publication->id,
            'locale' => 'en',
            'title' => 'Fetched title',
            'status' => 'approved',
        ]);
    }

    public function test_add_article_fetches_and_stores_both_english_and_persian_content(): void
    {
        $target = 'https://93.184.216.34/bilingual';
        $englishHtml = '<html><head><title>English article</title>'
            .'<meta property="og:description" content="'.str_repeat('English paragraph line. ', 12).'"></head></html>';
        $persianHtml = '<html><head><title>مقاله فارسی</title>'
            .'<meta property="og:description" content="'.str_repeat('پاراگراف فارسی. ', 12).'"></head></html>';

        Http::fake(['https://93.184.216.34/bilingual' => Http::sequence()
            ->push($persianHtml, 200)
            ->push($englishHtml, 200)]);

        $this->withHeaders([])->postJson($this->addArticleUrl($target, 'fa'))->assertCreated();
        $this->postJson($this->addArticleUrl($target, 'en'))->assertCreated();

        $publication = Publication::where('url_hash', hash('sha256', $target))->firstOrFail();
        $this->assertDatabaseHas('publication_translations', [
            'publication_id' => $publication->id,
            'locale' => 'fa',
            'title' => 'مقاله فارسی',
        ]);
        $this->assertDatabaseHas('publication_translations', [
            'publication_id' => $publication->id,
            'locale' => 'en',
            'title' => 'English article',
        ]);
    }
    public function test_add_article_rejects_wrong_token_and_invalid_locale(): void
    {
        $target = 'https://93.184.216.34/add-denied';

        $this->postJson('/api/publications/addArticle/wrong/'.rawurlencode($target).'?locale=en')
            ->assertUnauthorized();

        Http::fake(['https://93.184.216.34/add-denied' => Http::response('<html></html>', 200)]);

        $this->postJson($this->addArticleUrl($target, 'de'))
            ->assertUnprocessable();

        $this->assertDatabaseCount('publications', 0);
    }
}



