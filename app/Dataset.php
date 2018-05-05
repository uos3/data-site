<?php

namespace App;

use Carbon\Carbon;
use App\SatConfig;
use App\SatGPS;
use App\SatHealth;
use App\SatIMG;
use App\SatStatus;

class Dataset {
  public $packets = [
    'sat_status'=>[],
    'sat_config'=>[],
    'sat_health'=>[],
    'sat_gps'=>[],
    'sat_img'=>[],
    'sat_imu'=>[],
  ];

  public function __construct() {
    foreach (Packet::$payloads as $p_key=>$p_info) {
      $this->packets[$p_info['name']] = Packet::last($p_key);
    }
  }

  public function toArray() {
    $output = [];
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
