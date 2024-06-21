<?php

namespace Shsom\ClientDataManagment;

class Update {
    private $table_name;

    public function __construct($table_name) {
        $this->table_name = $table_name;
    }

    public function cdm_update_item() {
        global $wpdb;
        $table_name = $this->table_name;

        if (isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id'])) {
            $upt_id = intval($_GET['id']);

            // Verify nonce
            if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'cdm_update_item_action_' . $upt_id)) {
                wp_die(__('Security check failed', 'cdm'));
            }

            $query = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $upt_id);
            $result = $wpdb->get_results($query);

            if ($result) {
                $print = $result[0];
                $name = esc_attr($print->name);
                $email = esc_attr($print->email);

                echo "
                <br/>
                <div class='wrap'>
                <h2 class='wp-heading-inline'>" . esc_html__('Update The Data', 'cdm') . "</h2>
                <br/>
                <table class='wp-list-table widefat striped'>
                    <thead>
                        <tr>
                            <th width='25%'>" . esc_html__('User ID', 'cdm') . "</th>
                            <th width='25%'>" . esc_html__('Name', 'cdm') . "</th>
                            <th width='25%'>" . esc_html__('Email Address', 'cdm') . "</th>
                            <th width='25%'>" . esc_html__('Actions', 'cdm') . "</th>
                        </tr>
                    </thead>
                    <tbody>
                        <form action='' method='post'>
                            " . wp_nonce_field('cdm_update_item_action_' . $upt_id, 'cdm_update_item_nonce', true, false) . "
                            <tr>
                                <td width='25%'>" . esc_html($print->id) . "<input type='hidden' id='uptid' name='upid' value='" . esc_attr($print->id) . "'></td>
                                <td width='25%'><input type='text' id='uptname' name='upname' value='" . esc_attr($print->name) . "'></td>
                                <td width='25%'><input type='email' id='uptemail' name='upemail' value='" . esc_attr($print->email) . "'></td>
                                <td width='25%'><button class='button' id='upsubmit' name='upsubmit' type='submit'>" . esc_html__('UPDATE', 'cdm') . "</button> <a href='" . esc_url(admin_url('admin.php?page=client-data')) . "'><button class='button' type='button'>" . esc_html__('CANCEL', 'cdm') . "</button></a></td>
                            </tr>
                        </form>
                    </tbody>
                </table>
                </div>";
            } else {
                echo '<div class="error"><p>' . esc_html__('No data found for the given ID.', 'cdm') . '</p></div>';
            }
        }

        if (isset($_POST['upsubmit'])) {
            // Verify nonce
            if (!isset($_POST['cdm_update_item_nonce']) || !wp_verify_nonce($_POST['cdm_update_item_nonce'], 'cdm_update_item_action_' . $_POST['upid'])) {
                wp_die(__('Security check failed', 'cdm'));
            }

            $id = intval($_POST['upid']);
            $name = sanitize_text_field($_POST['upname']);
            $email = sanitize_email($_POST['upemail']);

            if (!empty($name) && is_email($email)) {
                $wpdb->update(
                    $table_name,
                    ['name' => $name, 'email' => $email],
                    ['id' => $id],
                    ['%s', '%s'],
                    ['%d']
                );
                echo "<script>location.replace('admin.php?page=client-data');</script>";
                exit;
            } else {
                echo '<div class="error"><p>' . esc_html__('Invalid input data.', 'cdm') . '</p></div>';
            }
        }
    }
}