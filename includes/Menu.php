<?php

namespace Shsom\ClientDataManagment;

require_once __DIR__ . '/../vendor/autoload.php';

use Shsom\ClientDataManagment\Read;
use Shsom\ClientDataManagment\Update;
use Shsom\ClientDataManagment\Delete;
use Shsom\ClientDataManagment\Create;

class Menu {
    private $table_name;

    public function __construct($table_name) {
        $this->table_name = $table_name;
        add_action('admin_menu', [$this, 'cdm_add_admin_menu']);
    }

    public function cdm_add_admin_menu() {
        add_menu_page(
            __('Client Data', 'cdm'),
            __('Client Data', 'cdm'),
            'manage_options',
            'client-data',
            [$this, 'cdm_main_admin_page'],
            'dashicons-admin-generic'
        );

        add_submenu_page(
            'client-data',
            __('Add New Client', 'cdm'),
            __('Add New Client', 'cdm'),
            'manage_options',
            'add-new-client',
            [$this, 'cdm_add_new_client_page']
        );
    }

    public function cdm_main_admin_page() {
        $table_name = $this->table_name;

        $Read = new Read($table_name);
        $Read->cdm_read_data();

        $Update = new Update($table_name);
        $Update->cdm_update_item();

        $Delete = new Delete($table_name);
        $Delete->cdm_delete_item();
    }

    public function cdm_add_new_client_page() {
        $table_name = $this->table_name;
        $Create = new Create($table_name);
        $Create->cdm_add_new_client();
    }
}
