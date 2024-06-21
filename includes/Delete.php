<?php

namespace Shsom\ClientDataManagment;

Class Delete {
  private $table_name;
  function __construct($table_name) {
    $this->table_name = $table_name;
  }

  function cdm_delete_item() {
    global $wpdb;
    $table_name =  $this->table_name;

    if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id']))  {
      $del_id = $_GET['id'];
      $wpdb->delete($table_name, ['id' => $del_id]);
      echo "<script>location.replace('admin.php?page=client-data');</script>";
    }
  }

}