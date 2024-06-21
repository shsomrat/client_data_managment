<?php

namespace Shsom\ClientDataManagment;

class Read {
    private $table_name;

    public function __construct($table_name) {
        $this->table_name = $table_name;
    }

    public function cdm_read_data() {
        global $wpdb;
        $table_name = $this->table_name;

        // Fetch total number of rows
        $total_rows = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
        echo '<div class="wrap">';
        echo '<h1 class="wp-heading-inline">' . esc_html__('All Client Data', 'cdm') . '</h1>';
        ?>
        <a href="<?php echo esc_url(admin_url('admin.php?page=add-new-client')); ?>" class="page-title-action"><?php esc_html_e('Add New', 'cdm'); ?></a>
        <?php
        echo '<p>' . esc_html__('This is a custom admin page for showing all client data.', 'cdm') . '</p>';

        // Display results
        $results = $wpdb->get_results("SELECT * FROM $table_name");
        ?>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th><?php esc_html_e('ID', 'cdm'); ?></th>
                    <th><?php esc_html_e('Name', 'cdm'); ?></th>
                    <th><?php esc_html_e('Email', 'cdm'); ?></th>
                    <th><?php esc_html_e('Action', 'cdm'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($results as $row) {
                    echo '<tr>';
                    echo '<td>' . esc_html($row->id) . '</td>';
                    echo '<td>' . esc_html($row->name) . '</td>';
                    echo '<td>' . esc_html($row->email) . '</td>';
                    echo '<td>';
                    $update_url = wp_nonce_url(admin_url('admin.php?page=client-data&action=update&id=' . $row->id), 'cdm_update_item_action_' . $row->id);
                    $delete_url = wp_nonce_url(admin_url('admin.php?page=client-data&action=delete&id=' . $row->id), 'cdm_delete_item_action_' . $row->id);
                    ?>
                    <a href="<?php echo esc_url($update_url); ?>" class="page-title-action"><?php esc_html_e('Update', 'cdm'); ?></a>
                    <a href="<?php echo esc_url($delete_url); ?>" onclick="return confirm('<?php echo esc_js(__('Are you sure you want to delete this item?', 'cdm')); ?>');" class="page-title-action"><?php esc_html_e('Delete', 'cdm'); ?></a>
                    <?php
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
        <?php
        // Display total rows
        echo '<p>' . esc_html__('Total rows:', 'cdm') . ' ' . esc_html($total_rows) . '</p>';
        echo '</div>';
        }
    }
?>
