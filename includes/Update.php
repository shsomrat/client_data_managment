<?php

namespace Shsom\ClientDataManagment;

Class Update {
  private $table_name;
  function __construct($table_name) {
    $this->table_name = $table_name;
  }

  function cdm_update_item() {
    global $wpdb;
    $table_name =  $this->table_name;

    if (isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id']))  {
      $upt_id = $_GET['id'];
      $query = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $upt_id);
      $result = $wpdb->get_results($query);
      foreach($result as $print) {
        $name = $print->name;
        $email = $print->email;
      }
      echo "
      <br/>
      <div class='wrap'>
      <h2 class='wp-heading-inline'>Update The Data</h2>
      <br/>
      <table class='wp-list-table widefat striped'>
        <thead>
          <tr>
            <th width='25%'>User ID</th>
            <th width='25%'>Name</th>
            <th width='25%'>Email Address</th>
            <th width='25%'>Actions</th>
          </tr>
        </thead>
        <tbody>
          <form action='' method='post'>
            <tr>
              <td width='25%'>$print->id <input type='hidden' id='uptid' name='upid' value='$print->id'></td>
              <td width='25%'><input type='text' id='uptname' name='upname' value='$print->name'></td>
              <td width='25%'><input type='text' id='uptemail' name='upemail' value='$print->email'></td>
              <td width='25%'><button class='button' id='upsubmit' name='upsubmit' type='submit'>UPDATE</button> <a href='admin.php?page=client-data'><button class='button' type='button'>CANCEL</button></a></td>
            </tr>
          </form>
        </tbody>
      </table>
      </div>";
    }
    if(isset($_POST['upsubmit']))  {
      $id = $_POST['upid'];
      $name = $_POST['upname'];
      $email = $_POST['upemail'];
      $wpdb->update($table_name, ['name' => $name, 'email' => $email],['id'=> $id]);
      echo "<script>location.replace('admin.php?page=client-data');</script>";
    }

  }
}