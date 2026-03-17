<?php
/**
*
* Google Analytics extension for the phpBB Forum Software package.
*
* @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
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
	$lang = [];
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

$lang = array_merge($lang, [
	'PHPBB_ANALYTICS_PRIVACY_POLICY' => '
		<br><br>
        <b>Analyse du trafic sur le site (Matomo)</b><br>
        Nous utilisons Matomo Analytics comme silution pour mesurer, collecter, analyser et présenter les données des visiteurs afin de comprendre et d\'optimiser notre site web.
        <br>
        Les informations relatives à l\'utilisation de "%1$s" collectées par Matomo sont stockées sur nos serveurs. Les adresses IP sont anonymisées avant d\'être stockées.
        <br>
        Vous pouvez désactiver Matomo en décochant la case suivante: <div id="matomo-opt-out"></div><script src="%2$s/index.php?module=CoreAdminHome&action=optOutJS&div=matomo-opt-out&showIntro=0&language=en"></script>',
]);
