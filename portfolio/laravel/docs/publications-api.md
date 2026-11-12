# Publications: translations and the add-article API

## How translations work

- Each article is one row in `publications`. It stores the URL, which is shared by all languages.
- Each language has its own row in `publication_translations`, unique per `(publication_id, locale)`.
- Supported locales: `fa` and `en`.
- Each translation has a `status` of `approved` or `draft`. Only approved translations are shown.
- An article appears on the public site only when both are true:
  1. `is_published` is `true` (set in the admin dashboard Visibility control), and
  2. the requested locale's translation is `approved`.
- There is no fallback. An English request never shows Persian text. A missing English translation hides the article in English.
- `GET /api/publications?locale=fa|en` returns up to 4 items. The default locale is `fa`. An invalid locale returns 422.

### Admin controls

Open an article at `/dashboard/publications/{id}/edit`:

- **Visibility:** publishes or unpublishes the article for both languages.
- **FA / EN panels:** edit the translation text and save it.
- **Approve toggle:** switches the translation between `approved` and `draft`.

## Adding an article through the API

Endpoint:

```
POST /api/publications/addArticle/{token}/{target}?locale=fa|en
```

| Part | Meaning |
| --- | --- |
| `{token}` | The value of `PUBLICATION_IMPORT_TOKEN` in `.env`. A wrong token returns 401. |
| `{target}` | The article URL, URL-encoded. Must use `http` or `https` and a public host. |
| `?locale=` | `fa` or `en`. Defaults to `fa`. |

What the endpoint does:

1. Fetches the page and reads its title, venue, category, and description.
2. Creates a publication row, or reuses the existing one with the same URL.
3. Saves the translation for the given locale as `approved`.
4. Returns `201` with the article in the same shape as the public API.

Example:

```
POST http://0.0.0.0:3000/api/publications/addArticle/YOUR_TOKEN/https%3A%2F%2Freact.dev%2Flearn?locale=en
```

PowerShell example:

```powershell
$token = 'YOUR_TOKEN'
$target = [uri]::EscapeDataString('https://react.dev/learn')
Invoke-RestMethod -Method Post -Uri "http://0.0.0.0:3000/api/publications/addArticle/$token/$target?locale=en"
```

### Important notes

- **Visibility:** articles added through this endpoint are created unpublished. Open the admin dashboard and turn on Visibility before they appear on the site.
- **No translation:** the endpoint does not translate text. Each locale's text comes from the page it fetched. To add the other language, call the endpoint again with the other `locale`.
- **Private hosts:** hosts that resolve to private or local addresses are rejected with 422. On some machines, DNS maps public sites to private ranges, so requests can fail locally.
- **Limit:** only the 4 most recent publications are kept. Older ones are deleted when a new one is added.
