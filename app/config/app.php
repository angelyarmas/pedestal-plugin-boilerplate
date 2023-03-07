<?php

return [
  /**
   * Plugin's official name.
   */
  'name' => 'Pedestal',

  /**
   * Plugin version, used to evaluate the current plugin and
   * changes the internal assets versions.
   */
  'version' => '0.0.1',

  /**
   * Plugins' text domain, used to load the correct language file.
   */
  'text_domain' => 'pedestal',

  /**
   * Define the current enviroment mode. Options:
   * - production: Do not show any error logging.
   * - dev: Show error logging on the site or log errors to a file.
   * - maintenance: Disable all the plugin hooks and elements.
   */
  'mode' => 'production',

  /**
   * The API namespace for your plugin's rest routes.
   */
  'rest_namespace' => 'pedestal/v1',
];