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
	'ACP_MATOMOANALYTICS_ENABLE'			=> 'Activer Matomo',
	'ACP_MATOMOANALYTICS_ENABLE_EXPLAIN'	=> 'Activer/desactiver Matomo pour tout le site.',
	'ACP_MATOMOANALYTICS_URL'				=> 'Matomo Tracker URL',
	'ACP_MATOMOANALYTICS_URL_EXPLAIN'		=> 'URL de votre instance Matomo. Vous pouvez la trouver dans l\'interface web, à l\'intérieur du code de suivi JavaScript, juste derrière.<i>var u=</i>.',
	'ACP_MATOMOANALYTICS_URL_INVALID'		=> 'L\'URL doit valider ce format: <i>http(s)://example.com/</i> (faite attention au slash final)',
	'ACP_MATOMOANALYTICS_SITE_ID'			=> 'Website ID',
	'ACP_MATOMOANALYTICS_SITE_ID_EXPLAIN'	=> 'L\'identifiant de votre site web fourni par Matomo.',
	'ACP_MATOMOANALYTICS_SITE_ID_INVALID'	=> 'ID doit être un entier positif.',
<<<<<<< HEAD
    'ACP_MATOMOANALYTICS_USER_ID_ENABLED'   => 'Incrlue le pseudonyme de l\'utilisateur dans les statistics. Ne fonctionne que si l\'utilisateur est connecté.',
    'ACP_MATOMOANALYTICS_HEARTBEAT'         => 'Activez un système de surveillance (heartbeat) pour obtenir des durées de visite plus précises. Ce système envoie des requêtes HTTP périodiques tant que le site est ouvert. Configurez l\'intervalle entre les requêtes pour activer cette fonctionnalité (15s est la valeur recommandé par Matomo), ou 0s pour désactiver. Attention: cette opération générera un grand nombre de requêtes HTTP supplémentaires sur votre site.',
=======
	'ACP_MATOMOANALYTICS_USER_ID_ENABLED'	=> 'Incrlue le pseudonyme de l\'utilisateur dans les statistics. Ne fonctionne que si l\'utilisateur est connecté.',
	'ACP_MATOMOANALYTICS_HEARTBEAT'			=> 'Activez un système de surveillance (heartbeat) pour obtenir des durées de visite plus précises. Ce système envoie des requêtes HTTP périodiques tant que le site est ouvert. Configurez l\'intervalle entre les requêtes pour activer cette fonctionnalité (15s est la valeur recommandé par Matomo), ou 0s pour désactiver. Attention: cette opération générera un grand nombre de requêtes HTTP supplémentaires sur votre site.',
>>>>>>> 3d839a3a9cb031905271b80b3c23c49a45106a85
));
