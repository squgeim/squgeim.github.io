# squgeim.github.io

Personal site that consolidates blog posts, talks, and podcast appearances.

## How it works

Blog posts are Markdown files in `src/content/`. Each file has XML metadata at the top (title, date, tags, optional external URL), separated from the Markdown body by three blank lines. A PHP-based build step compiles everything into static HTML.

```
make        # build
make clean  # remove generated HTML
```

Requires `php` and `make`.
