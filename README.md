# CODJA Add User From Post
Plugin allow to add users from edit post page. Users are added with the role 'editor'.

## Metabox on edit post page
Default, the metabox are displayed only on edit post page. For add metabox on edit pages of other post types, add them using filter `cj_aufp_post_types`

```php
add_filter('cj_aufp_post_types', function($post_types) {
  $post_types[] = 'page';
  $post_types[] = 'product';

  return $post_types;
});
```