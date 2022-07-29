<?php
/**
 * Plugin Name:  ChatPress
 * Plugin URI:   https://wordpress.org/plugins/chatpress
 * Description:  This plugin creates a chatboard that updates with AJAX to embed on pages that keeps the identity of each poster anonymous.
 * Version:      2.1.0
 * Contributors: brothman01
 * Author URI:   http://www.BenRothman.org
 * Text Domain:  chatpress
 * License:      GPL-2.0+
 **/

 // always include
include 'utils/class-chatpress.php';
include 'utils/classes/class-Channel.php';
include 'utils/classes/class-Message.php';

// include on dashboard
if ( is_admin() ) {
    include 'utils/declare-cpts.php';
}

// include on front end


// plugin coderunner
$plugin = new Chatpress();
