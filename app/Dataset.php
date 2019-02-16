<?php

namespace App;

use Carbon\Carbon;
use App\SatConfig;
use App\SatGPS;
use App\SatHealth;
use App\SatIMG;
use App\SatStatus;

use Exception;

class Dataset {
  public $packets = [
    'sat_config'=>[],
    'sat_health'=>[],
    'sat_gps'=>[],
    'sat_img'=>[],
    'sat_imu'=>[],
  ];

  public $sat_status = [];

  public function __construct() {
    $latest_submit = NULL;
    foreach (Packet::$payloads as $p_key=>$p_info) {
      $packet = Packet::last($p_key);
      $this->packets[$p_info['name']] = $packet;
      if ($latest_submit === NULL || $packet->last_submitted > $latest_submit) {
        error_log("latest submit larger");
        $this->sat_status = $packet->sat_status;
        $latest_submit = $packet->last_submitted;
      }
    }
  }

  public function toArray() {
    $output = [];
    $output['sat_status'] = $this->sat_status;
    foreach ($this->packets as $payload_type_name=>$packet) {
      if (!$packet) {
        $output[$payload_type_name] = [];
        //set empty
      } else {
        $payload = $packet->$payload_type_name;
        if ($payload == null) {
          throw new Exception("It seems the payload content is missing! Please let the admins know about this.");
        } else {
          $output[$payload_type_name] = $payload->toArray();
        }
      }
    }    
    return $output;
  }

  public function toFlatArray() {
    $output = [];
    foreach ($this->packets as $payload_type_name=>$packet) {
      if ($packet) {
        $payload = $packet->$payload_type_name;
        if ($payload == null) {
          return response("It seems the payload content is missing! Please let the admins know about this",500);
        }
        //flatten
        $payload_array = $packet->$payload_type_name->toArray();
        foreach ($payload_array as $key => $value) {
          $output[$payload_type_name.".".$key] = $value;
        }
      }
    };
    return $output;
  }

}
