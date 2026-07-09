---
name: "wp-cpt-capabilities"
description: "WordPress CPT capability mapping best practices. Invoke when registering custom post types with custom capabilities, especially when using map_meta_cap."
---

# WordPress CPT Capability Mapping

## Golden Rule

**NEVER override meta capabilities directly in the `capabilities` array.**

Meta capabilities (`edit_post`, `delete_post`, `read_post`, `remove_post`) require a post ID context. WordPress 6.1+ throws a `_doing_it_wrong` notice if `map_meta_cap()` is called for these without a post ID — which happens during admin menu building, admin bar rendering, and other global capability checks.

## Wrong (will cause map_meta_cap notice + broken admin menu)

```php
'capabilities' => array(
    'edit_post'          => 'read',   // ❌ meta cap, needs post ID
    'read_post'          => 'read',   // ❌ meta cap, needs post ID
    'delete_post'        => 'read',   // ❌ meta cap, needs post ID
    'edit_posts'         => 'read',
    'edit_others_posts'  => 'read',
    'publish_posts'      => 'read',
    'read_private_posts' => 'read',
),
'map_meta_cap' => true,
```

## Correct (only override primitive caps)

```php
'capabilities' => array(
    'edit_posts'          => 'read',
    'edit_others_posts'   => 'read',
    'delete_posts'        => 'read',
    'delete_others_posts' => 'read',
    'publish_posts'       => 'read',
    'read_private_posts'  => 'read',
),
'map_meta_cap' => true,
```

## How it works

With `map_meta_cap => true`, WordPress automatically maps meta caps → primitive caps:

| Meta cap | Maps to (author) | Maps to (non-author) |
|----------|------------------|----------------------|
| `edit_post` | `edit_posts` | `edit_others_posts` |
| `delete_post` | `delete_posts` | `delete_others_posts` |
| `read_post` | `read` | `read_private_posts` |
| `remove_post` | `delete_posts` | `delete_others_posts` |

So you only need to set the **primitive** caps. Let `map_meta_cap` do the context-aware mapping.

## Checklist

When registering a CPT with `map_meta_cap => true`:

- [ ] Only `*_posts` caps (primitive) in the `capabilities` array
- [ ] No `edit_post`, `delete_post`, `read_post`, `remove_post` (meta caps)
- [ ] If lowering all caps to `read`: include `delete_posts` + `delete_others_posts`
- [ ] `map_meta_cap` left as `true` to keep authorship checks
