<?php

// Load Composer autoloader.
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

add_action('after_setup_theme', function () {
    global $admin;

    $admin = new Inggo\WordPress\PSBADRM\Admin;
    $admin->init();

    remove_action('after_setup_theme', 'psba_manila_admin_setup', 10);
}, 9);

add_action('after_setup_theme', function () {
    global $child_theme;

    $child_theme = new Inggo\WordPress\PSBADRM\Theme;
    $child_theme->init();
}, 11);
