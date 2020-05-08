<?php

/**
 * This file is responsible with importing all required helpers ready
 * for the rest of the app to use.
 */

// Load the config file.
require_once 'config/config.php';

// Load the Helper class.
require_once 'helpers/Helper.php';

// Autoload Helpers
spl_autoload_register(function ($className) {
  require_once 'helpers/' . $className . '.php';
});
