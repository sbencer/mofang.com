<?php
/*
Plugin Name: Shortcodes in Sidebar
Plugin URI: http://pankajanupam.com/wordpress-plugins/
Description: Shortcodes in Sidebar allows shortcodes to execute in sidebars.
Version: 2.0
Author: BigBrother
Author URI: http://pankajanupam.com
/*  Copyright 2011 PANKAJ ANUPAM (email : info@pankajanupam.in)
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
	add_filter('widget_text', 'do_shortcode', 11);
?>