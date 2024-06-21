<?php

namespace Shsom\ClientDataManagment;

class Create {
    private $table_name;

    public function __construct($table_name) {
        $this->table_name = $table_name;
    }

    public function cdm_add_new_client() {
        global $wpdb;
        $table_name = $this->table_name;

        if (isset($_POST['submit'])) {
            // Verify nonce
            check_admin_referer('cdm_add_new_client_action', 'cdm_add_new_client_nonce');

            // Sanitize and validate input data
            $name = sanitize_text_field($_POST['name']);
            $email = sanitize_email($_POST['email']);

            if (is_email($email) && !empty($name)) {
                // Use prepared statements to insert data securely
                $wpdb->insert(
                    $table_name,
                    ['name' => $name, 'email' => $email],
                    ['%s', '%s']
                );
                echo "<script>location.replace('admin.php?page=client-data');</script>";
                exit;
            } else {
                echo "<div class='error'><p>" . __('Invalid input. Please enter a valid name and email.', 'cdm') . "</p></div>";
            }
        }
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('New Client', 'cdm'); ?></h1>
            <form action="" method="post">
                <?php wp_nonce_field('cdm_add_new_client_action', 'cdm_add_new_client_nonce'); ?>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><label for="name"><?php esc_html_e('Name', 'cdm'); ?></label></th>
                            <td><input type="text" name="name" id="name" class="regular-text" value="" required></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="email"><?php esc_html_e('Email', 'cdm'); ?></label></th>
                            <td><input type="email" name="email" id="email" class="regular-text" value="" required></td>
                        </tr>
                    </tbody>
                </table>
                <?php submit_button(__('Add Client', 'cdm'), 'primary', 'submit'); ?>
            </form>
        </div>
        <?php
    }
}
?>
