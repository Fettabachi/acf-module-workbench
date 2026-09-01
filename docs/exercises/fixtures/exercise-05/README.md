# Exercise 05 content fixtures

This fixture supplies realistic local posts for the Curated Content Grid
exercise without making the eventual block depend on sample content.

## Imported content

- Eight published posts with stable `exercise-05-` slugs
- Strategy, Design, and Technology categories with exercise-specific slugs
- Authored excerpts except for one deliberate missing-excerpt case
- Six featured-image assignments using the local Exercise 04 media library
- Two deliberate missing-image cases
- One deliberately long title
- A private post-meta marker used for safe repeat imports and cleanup

The fixture manager creates or refreshes its own marked posts. It refuses to
overwrite an unrelated post if one already uses a fixture slug. Re-running the
import does not create duplicate posts.

## Import

From the WordPress installation root, run:

```sh
wp eval-file wp-content/themes/cr-practice/docs/exercises/fixtures/exercise-05/manage.php import
```

The script uses the first existing WordPress user as the post author. It does
not create users, modify unrelated posts, or create media attachments.

## Verify

Verify the expected post, category, excerpt, long-title, and featured-image
counts after importing:

```sh
wp eval-file wp-content/themes/cr-practice/docs/exercises/fixtures/exercise-05/manage.php verify
```

## Cleanup

Cleanup permanently deletes only posts carrying the Exercise 05 fixture marker
and then removes the three exercise-specific categories. It requires an
explicit confirmation argument:

```sh
wp eval-file wp-content/themes/cr-practice/docs/exercises/fixtures/exercise-05/manage.php cleanup --apply
```

The reused media attachments are not deleted.
