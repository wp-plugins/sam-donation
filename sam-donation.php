<?php
defined('ABSPATH') or die("No script kiddies please!");
/**
 * Plugin Name: SAM Donation
 * Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
 * Description: A small plugin that will allow you to drop a recurring South America Mission donation form on your website.  To get started: 1) Click the "Activate" link to the left of this description, 2) Click on Plugins > SAM Donate on the left menu 3) Follow the instructions on the page!
 * Version: 1.0
 * Author: Chris Weissenberger
 * License: GPL2
 */
/*  Copyright 2014  Chris Weissenberger  (email : caweissen@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Retrieve plugin settings from options table
$sam_options = get_option('sam_setting');

/************************
* Includes
************************/

include('sam-admin.php');