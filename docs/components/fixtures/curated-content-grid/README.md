# Curated Content Grid fixtures

This optional fixture supplies realistic local posts for testing the Curated
Content Grid without making the component depend on sample content.

## Imported content

- Eight published posts with stable fixture slugs
- Strategy, Design, and Technology categories with fixture-specific slugs
- Authored excerpts except for one deliberate missing-excerpt case
- Six featured-image assignments using existing local media
- Two deliberate missing-image cases
- One deliberately long title
- A private post-meta marker used for safe repeat imports and cleanup

The fixture manager creates or refreshes its own marked posts. It refuses to
overwrite an unrelated post if one already uses a fixture slug. Re-running the
import does not create duplicate posts.

## Import

From the WordPress installation root, run:

```sh
wp eval-file wp-content/themes/acf-module-workbench/docs/components/fixtures/curated-content-grid/manage.php import
```

The script uses the first existing WordPress user as the post author. It does
not create users, modify unrelated posts, or create media attachments.

## Verify

Verify the expected post, category, excerpt, long-title, and featured-image
counts after importing:

```sh
wp eval-file wp-content/themes/acf-module-workbench/docs/components/fixtures/curated-content-grid/manage.php verify
```

## Cleanup

Cleanup permanently deletes only posts carrying the fixture marker and then
removes the three fixture-specific categories. It requires an
explicit confirmation argument:

```sh
wp eval-file wp-content/themes/acf-module-workbench/docs/components/fixtures/curated-content-grid/manage.php cleanup --apply
```

The reused media attachments are not deleted.
