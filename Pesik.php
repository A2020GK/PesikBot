<?php
echo base64_decode("KyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tICsNCnwgQTIwMjBHSyBUZWxlZ3JhbSBCb3QgICB8DQp8IEJhc2VkIG9uIE1hZGVsaW5lUHJvdG8gfA0KKyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tICsNCg==");
echo "> Loading Composer autoloader... ";

require_once __DIR__."/vendor/autoload.php";
echo "Done. \n";

use App\Bot;
define("BOT_ADMIN",readline("> Admin peer = "));
define("CHANNEL_ID",readline("> Channel ID = "));

Bot::startAndLoop("data");