<?php

namespace Shsom\ClientDataManagment;

Class Create {
    private $table_name;
  function __construct($table_name) {
    $this->table_name = $table_name;
  }

  function cdm_add_new_client() {
    global $wpdb;
    $table_name = $this->table_name;

    if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $wpdb->insert($table_name, ['name' => $name, 'email' => $email]);
    echo "<script>location.replace('admin.php?page=client-data');</script>";
    }
    ?>
    <div class="wrap">
        <h1><?php _e('New Client', 'cdm'); ?></h1>
        <form action="" method="post">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><label for="name"><?php _e('Name', 'cdm'); ?></label></th>
                        <td><input type="text" name="name" id="name" class="regular-text" value=""></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="email"><?php _e('Email', 'cdm'); ?></label></th>
                        <td><input type="email" name="email" id="email" class="regular-text" value=""></td>
                    </tr>
                </tbody>
            </table>
            <?php submit_button(__('Add Client', 'cdm'), 'primary', 'submit'); ?>
        </form>
    </div>
    <?php
  }
}