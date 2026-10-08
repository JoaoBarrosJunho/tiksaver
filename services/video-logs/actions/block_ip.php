<?php

use App\classes\black_list;

$id = $v_logs->ip??0;

$ban = black_list::ban($id);

$success = $ban['success'];
$message = $ban['message'];
