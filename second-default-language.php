<?php
/**
 * Plugin Name: Second default language
 * Description: Define the second site language, which will be used if the installed plugins don't have translations for the first site language.
 * Version: 1.0.5
 * Author: Gesundheit Bewegt GmbH
 * Author URI: http://gesundheit-bewegt.com/
 * Text Domain: sdl
*/

if(!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

require_once __DIR__ . '/SecondDefaultLanguage.php';

new \SDL\SecondDefaultLanguage();