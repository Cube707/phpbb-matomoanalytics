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
	'ACP_MATOMOANALYTICS_ENABLE_EXPLAIN'	=> 'Enable/disable Matomo for the whole website.',
	'ACP_MATOMOANALYTICS_URL'				=> 'Matomo Tracker URL',
	'ACP_MATOMOANALYTICS_URL_EXPLAIN'		=> 'The URL of your Matomo-instanz. You can find it in the web interface inside the JavaScript-Tracking-Code right behind <i>var u=</i>.',
	'ACP_MATOMOANALYTICS_URL_INVALID'		=> 'The Matomo Tracker URL must match this format: <i>http(s)://example.com/</i> (note the trailing slash)',
	'ACP_MATOMOANALYTICS_SITE_ID'			=> 'Website ID',
	'ACP_MATOMOANALYTICS_SITE_ID_EXPLAIN'	=> 'The ID of your website from Matomo.',
	'ACP_MATOMOANALYTICS_SITE_ID_INVALID'	=> 'ID must be a positive integer.',
	'ACP_MATOMOANALYTICS_NOSCRIPT_ENABLE'	=> 'Enable noscript code, for users without javascript.',
));
