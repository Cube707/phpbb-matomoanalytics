<?php
/**
 *
 * Matomo Analytics extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace cube\matomoanalytics\event;

use phpbb\config\config;
use phpbb\language\language;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	/** @var config */
	protected $config;

	/** @var language */
	protected $language;

	/** @var template */
	protected $template;

	/** @var user */
	protected $user;

	/**
	 * Constructor
	 *
	 * @param config   $config   Config object
	 * @param language $language Language object
	 * @param template $template Template object
	 * @param user     $user     User object
	 * @access public
	 */
	public function __construct(config $config, language $language, template $template, user $user)
	{
		$this->config = $config;
		$this->language = $language;
		$this->template = $template;
		$this->user = $user;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 * @static
	 * @access public
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.acp_board_config_edit_add'	=> 'add_matomoanalytics_configs',
			'core.page_header'					=> 'load_matomoanalytics',
			'core.validate_config_variable'		=> 'validate_matomoanalytics_url',
		];
	}

	/**
	 * Load Matomo Analytics js code
	 *
	 * @return void
	 * @access public
	 */
	public function load_matomoanalytics()
	{
		$this->template->assign_vars([
			'MATOMOANALYTICS_ENABLED'			=> $this->config['matomoanalytics_enabled'],
			'MATOMOANALYTICS_URL'				=> $this->config['matomoanalytics_url'],
			'MATOMOANALYTICS_SITE_ID'			=> $this->config['matomoanalytics_site_id'],
			'MATOMOANALYTICS_USER_ID_ENABLED'	=> $this->config['matomoanalytics_user_id_enabled'],
			'MATOMOANALYTICS_USER_ID'			=> $this->user->data['username'],
			'MATOMOANALYTICS_HEARTBEAT'			=> $this->config['matomoanalytics_heartbeat'],
		]);
	}

	/**
	 * Add config vars to ACP Board Settings
	 *
	 * @param \phpbb\event\data $event The event object
	 * @return void
	 * @access public
	 */
	public function add_matomoanalytics_configs($event)
	{
		// Add a config to the settings mode, after warnings_expire_days
		if ($event['mode'] === 'settings' && isset($event['display_vars']['vars']['warnings_expire_days']))
		{
			// Load language file
			$this->language->add_lang('matomoanalytics_acp', 'cube/matomoanalytics');

			// Store display_vars event in a local variable
			$display_vars = $event['display_vars'];

			// Define the new config vars
			$matomo_config_vars = [
				'legend_matomoanalytics' => 'ACP_MATOMOANALYTICS',
				'matomoanalytics_enabled' => [
					'lang'		=> 'ACP_MATOMOANALYTICS_ENABLE',
					'validate'	=> 'bool',
					'type'		=> 'radio:yes_no',
					'explain'	=> true,
				],
				'matomoanalytics_url' => [
					'lang'		=> 'ACP_MATOMOANALYTICS_URL',
					'validate'	=> 'matomoanalytics_url',
					'type'		=> 'text:40:255',
					'explain'	=> true,
				],
				'matomoanalytics_site_id' => [
					'lang'		=> 'ACP_MATOMOANALYTICS_SITE_ID',
					'validate'	=> 'int:0',
					'type'		=> 'number:1',
					'explain'	=> true,
				],
				'matomoanalytics_user_id_enabled' => [
					'lang'		=> 'ACP_MATOMOANALYTICS_USER_ID_ENABLED',
					'validate'	=> 'bool',
					'type'		=> 'radio:yes_no',
					'explain'	=> true,
				],
				'matomoanalytics_heartbeat' => [
					'lang'		=> 'ACP_MATOMOANALYTICS_HEARTBEAT',
					'validate'	=> 'int:0',
					'type'		=> 'number:0',
					'explain'	=> true,
				],
			];

			// Add the new config vars after warnings_expire_days in the display_vars config array
			$insert_after = ['after' => 'warnings_expire_days'];
			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $matomo_config_vars, $insert_after);

			// Update the display_vars event with the new array
			$event['display_vars'] = $display_vars;
		}
	}

	/**
	 * Validate the Matomo Analytics ID
	 *
	 * @param \phpbb\event\data $event The event object
	 * @return void
	 * @access public
	 */
	public function validate_matomoanalytics_url($event)
	{
		// Check if the validate test is for matomo_analytics and matomo is enabled
		if ($event['config_definition']['validate'] !== 'matomoanalytics_url'|| !$event['cfg_array']['matomoanalytics_enabled'])
		{
			return;
		}

		// Store the input and error event data
		$input = $event['cfg_array']['matomoanalytics_url'];
		$error = $event['error'];

		// Add error message if the input is not a valid URL
		if (!preg_match('/^https?:\/\/.*\/$/', $input))
		{
			$error[] = $this->language->lang('ACP_MATOMOANALYTICS_URL_INVALID', $input);
		}

		// Update error event data
		$event['error'] = $error;
	}
}
