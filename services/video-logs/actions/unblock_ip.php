<?php

use App\classes\black_list;

$id = $v_logs->ip??0;

$unblock = black_list::remove($id);

$success = $unblock['success'];
$message = $unblock['message'];
