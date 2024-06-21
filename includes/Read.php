<?php

namespace Shsom\ClientDataManagment;

Class Read {
    private $table_name;
    function __construct($table_name) {
      $this->table_name = $table_name;
    }


  function cdm_read_data() {
    global $wpdb;
    $table_name =  $this->table_name;

    $total_rows = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    echo '<div class="wrap">';
    echo '<h1 class="wp-heading-inline">All Client Data</h1>';
    ?><a href="<?php echo admin_url( 'admin.php?page=add-new-client' ); ?>" class="page-title-action"><?php _e( 'Add New', 'cdm' ); ?></a><?php
    echo '<p>This is a custom admin page for show all client data.</p>';


    //display results
    $results = $wpdb->get_results("SELECT * FROM {$table_name}");
    // $results = $wpdb->get_results("SELECT * FROM $wpdb->custom_table");
    ?>
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($results as $row) {
                echo '<tr>';
                echo '<td>' . esc_html($row->id) . '</td>';
                echo '<td>' . esc_html($row->name) . '</td>';
                echo '<td>' . esc_html($row->email) . '</td>';
                echo '<td>'
                ?><a href="<?php echo admin_url( 'admin.php?page=client-data&action=update&id=' . esc_html($row->id)  ); ?>" class="page-title-action"><?php _e( 'Update', 'cdm' ); ?></a><a href="<?php echo admin_url( 'admin.php?page=client-data&action=delete&id=' . esc_html($row->id) ); ?>" onclick="return confirm('Are you sure you want to delete this item?');" class="page-title-action"><?php _e( 'Delete', 'cdm' ); ?></a><?php
                '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    <?php
    //display total rows
    echo '<p>Total rows: ' . esc_html($total_rows) . '</p>';
    echo '</div>';
  }

}