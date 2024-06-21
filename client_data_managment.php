<?php
/*
 * Plugin Name:       Client Data Managment
 * Plugin URI:        https://example.com/plugins/client-data-managment/
 * Description:       Handle the basics with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            S H Somrat
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/client-data-managment/
 * Text Domain:       cdm
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once __DIR__ . '/vendor/autoload.php';

Class Client_Data_List {
  private $table_name;
  private $dbv = '1.0';
  function __construct() {
    global $wpdb;
    $table_name = $this->table_name = $wpdb->prefix . 'client_data_list';

    register_activation_hook(__FILE__, [$this, 'cdm_create_database_tables']);

    new Shsom\ClientDataManagment\Menu($table_name);

    $dbv = get_option('dbv');
    if ($dbv != $this->dbv) {
        $this->cdm_create_database_tables();
        update_option('dbv', $this->dbv);
    }
  }

  function cdm_create_database_tables() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $this->table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(50) NOT NULL,
        email varchar(50) NOT NULL,
        -- phone varchar(15) NOT NULL,
        -- gender varchar(10) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
  }
}

new Client_Data_List();