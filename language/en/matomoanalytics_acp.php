<?php
/**
*
* Matomo Analytics extension for the phpBB Forum Software package.
*
* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'ACP_MATOMOANALYTICS'					=> 'Matomo Analytics',
	'ACP_MATOMOANALYTICS_ENABLE'			=> 'Use Matomo',
	'ACP_MATOMOANALYTICS_ENABLE_EXPLAIN'	=> 'Enable/disable Matomo for the howle website.',
	'ACP_MATOMOANALYTICS_URL'				=> 'Matomo Tracker URL',
	'ACP_MATOMOANALYTICS_URL_EXPLAIN'		=> 'The URL of your Matomo-instanz. You can find it in the webinterface inside the JavaScript-Tracking-Code right behind <i>var u=</i>.',
	'ACP_MATOMOANALYTICS_URL_INVALID'		=> 'The Matomo Tracker URL musst match this fomat: <i>http(s)://example.com/</i> (note the trailing slash)',
	'ACP_MATOMOANALYTICS_SITE_ID'			=> 'Website ID',
	'ACP_MATOMOANALYTICS_SITE_ID_EXPLAIN'	=> 'The ID of your website from Matomo.',
	'ACP_MATOMOANALYTICS_SITE_ID_INVALID'	=> 'ID bust be a positiv integer.',
	'ACP_MATOMOANALYTICS_USER_ID_ENABLED'	=> 'Include Username into statistics. Only if the user is logged',
	'ACP_MATOMOANALYTICS_HEARTBEAT'			=> 'Enable a heartbeat timer to get more accurate visit lengths by sending periodical HTTP ping requests as long as the site is opened. Enter the time between the pings in seconds (Matomo default: 15) to enable or 0 to disable this feature. Note: This will cause a lot of additional HTTP requests on your site.'
));
