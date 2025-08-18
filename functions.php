<?php

require_once get_template_directory() . '/include/acf-loader-helpers.php';

function am_theme_enqueue_production_scripts(): void
{
  $json_manifest = json_decode(file_get_contents(get_template_directory() . '/dist/.vite/manifest.json'), true);
  $entry_assets = $json_manifest['resources/app/index.ts'];
  $entry_css = $entry_assets['css'];
  wp_enqueue_script_module($entry_assets['name'], get_theme_file_uri('/dist/') . $entry_assets['file'], array(), null);
  wp_enqueue_style($entry_assets['name'], get_theme_file_uri('/dist/') . $entry_css[0], array(), null);
}

function am_theme_enqueue_development_scripts(): void
{
  $resources_path = '/resources';
  $id_vite_client = 'vite-client';
  $vite_host_url = 'http://localhost:5173';

  wp_enqueue_script_module($id_vite_client, $vite_host_url . '/@vite/client', array(), null);
  wp_enqueue_script_module('index', $vite_host_url . $resources_path . '/app/index.ts', array(), null);
  wp_enqueue_style('theme-main', $vite_host_url . $resources_path . '/css/main.css', [], null);
}

function am_theme_handle_scripts(): void
{
  if (WP_ENVIRONMENT == 'production') {
    am_theme_enqueue_production_scripts();
  } else {
    am_theme_enqueue_development_scripts();
  }
}
add_action('wp_enqueue_scripts', 'am_theme_handle_scripts');

function allow_svg($svg_mime)
{
  $svg_mime['svg'] = 'image/svg+xml';
  return $svg_mime;
}
add_filter('upload_mimes', 'allow_svg');

function load_acf_blocks_landing_page()
{
  generate_hero_section('Hero Section');
}

add_action('acf/init', function (): void {
  $acf_modules = array(
    "hero-section",
    "prose-block",
    "product-teaser",
    "gallery-slider"
  );
  include_acf_modules_landing_page($acf_modules);
  load_acf_blocks_landing_page();
});
