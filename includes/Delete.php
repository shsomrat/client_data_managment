<?php

namespace Shsom\ClientDataManagment;

class Delete {
    private $table_name;

    public function __construct($table_name) {
        $this->table_name = $table_name;
    }

    public function cdm_delete_item() {
        global $wpdb;
        $table_name = $this->table_name;

        if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
            // Verify nonce
            $nonce = $_GET['_wpnonce'];
            if (!wp_verify_nonce($nonce, 'cdm_delete_item_action_' . $_GET['id'])) {
                wp_die(__('Security check failed', 'cdm'));
            }

            $del_id = intval($_GET['id']);
            $wpdb->delete($table_name, ['id' => $del_id]);
            echo "<script>location.replace('admin.php?page=client-data');</script>";
        }
    }
    }
?>
