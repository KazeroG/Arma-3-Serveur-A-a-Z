<?php

// DATABASE

define("DB_HOST", "localhost");
define("DB_NAME", "altisfrance");
define("DB_USER", 'root');
define("DB_PASSWORD", 'root');

// TABLES

define("SPONSORSHIP_TABLE", "sponsorship");
define("GANGS_TABLE", "gangs");
define("HOUSES_TABLE", "houses");
define("MESSAGES_TABLE", "messages");
define("PLAYERS_TABLE", "players");
define("VEHICLES_TABLE", "vehicles");
define("ADMIN_TABLE","admins");
define("IMPOTS_TABLE","impots");
define("CODE_TABLE","code");
define("SANCTION_TABLE","sanctions");
define("TICKET_TABLE","tickets");
define("NOTIFICATION_TABLE","notification");
define("NOTIFICATION_BYADMIN_TABLE","notification_by_admin");
define("DC_DONATIONS_TABLE","dc_donations");

// CONFIG

define("GODSON_REWARD",20000);
define("GODFATHER_REWARD",20000);

// MAIL SERVER

define("SMTP_HOST","smtp.domain.dev");
define("SMTP_PORT","port");
define("SMTP_AUH",false);
define("SMTP_USER","SMTPUSER");
define("SMTP_PASSWORD","SMTPPASSWORD");

// INCLUDE CLASS

require_once('class.admin.php');
require_once('class.db.php');
require_once('class.code.php');
require_once('class.donation.php');
require_once('class.player.php');
require_once('class.mail.php');
require_once('class.notification.php');
require_once('class.tools.php');
require_once('class.sanction.php');
require_once('class.vehicles.php');
require_once('class.ticket.php');
