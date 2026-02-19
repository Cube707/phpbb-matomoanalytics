<?php
/**
 *
 * Matomo Analytics extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace cube\matomoanalytics\tests\event;

require_once __DIR__ . '/../../../../../includes/functions_acp.php';

class listener_test extends \phpbb_test_case
{
	/** @var \cube\matomoanalytics\event\listener */
	protected $listener;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\language\language */
	protected $lang;

	/** @var \PHPUnit\Framework\MockObject\MockObject|\phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/**
	 * Setup test environment
	 */
	protected function setUp(): void
	{
		parent::setUp();

		global $phpbb_root_path, $phpEx;

		// Load/Mock classes required by the event listener class
		$this->config = new \phpbb\config\config([
			'matomoanalytics_enabled' => true,
			'matomoanalytics_url' => 'https://example.com/',
			'matomoanalytics_site_id' => 1,
			'matomoanalytics_user_id_enabled' => true,
			'matomoanalytics_heartbeat' => 15,
		]);
		$this->template = $this->getMockBuilder('\phpbb\template\template')
			->getMock();
		$lang_loader = new \phpbb\language\language_file_loader($phpbb_root_path, $phpEx);
		$this->lang = new \phpbb\language\language($lang_loader);
		$this->user = new \phpbb\user($this->lang, '\phpbb\datetime');
		$this->user->data['user_id'] = 2;
		$this->user->data['is_registered'] = true;
		$this->user->data['username'] = "usertest";
	}

	/**
	 * Create our event listener
	 */
	protected function set_listener()
	{
		$this->listener = new \cube\matomoanalytics\event\listener(
			$this->config,
			$this->lang,
			$this->template,
			$this->user
		);
	}

	/**
	 * Test the event listener is constructed correctly
	 */
	public function test_construct()
	{
		$this->set_listener();
		self::assertInstanceOf('\Symfony\Component\EventDispatcher\EventSubscriberInterface', $this->listener);
	}

	/**
	 * Test the event listener is subscribing events
	 */
	public function test_getSubscribedEvents()
	{
		self::assertEquals([
			'core.acp_board_config_edit_add',
			'core.page_header',
			'core.validate_config_variable',
		], array_keys(\cube\matomoanalytics\event\listener::getSubscribedEvents()));
	}

	/**
	 * Test the load_matomoanalytics event
	 */
	public function test_load_matomoanalytics()
	{
		$this->set_listener();

		$this->template->expects(self::once())
			->method('assign_vars')
			->with([
				'MATOMOANALYTICS_ENABLED'			=> $this->config['matomoanalytics_enabled'],
				'MATOMOANALYTICS_URL'				=> $this->config['matomoanalytics_url'],
				'MATOMOANALYTICS_SITE_ID'			=> $this->config['matomoanalytics_site_id'],
				'MATOMOANALYTICS_USER_ID_ENABLED'	=> $this->config['matomoanalytics_user_id_enabled'],
				'MATOMOANALYTICS_USER_ID'			=> $this->user->data['username'],
				'MATOMOANALYTICS_HEARTBEAT'			=> $this->config['matomoanalytics_heartbeat'],
			]);

		$dispatcher = new \phpbb\event\dispatcher();
		$dispatcher->addListener('core.page_header', [$this->listener, 'load_matomoanalytics']);
		$dispatcher->trigger_event('core.page_header');
	}

	/**
	 * Data set for test_add_matomoanalytics_configs
	 *
	 * @return array Array of test data
	 */
	public function add_matomoanalytics_configs_data()
	{
		return [
			[ // expected config and mode
			  'settings',
			  ['vars' => ['warnings_expire_days' => []]],
			  ['warnings_expire_days', 'legend_matomoanalytics', 'matomoanalytics_enabled', 'matomoanalytics_url', 'matomoanalytics_site_id', 'matomoanalytics_user_id_enabled', 'matomoanalytics_heartbeat'],
			],
			[ // unexpected mode
			  'foobar',
			  ['vars' => ['warnings_expire_days' => []]],
			  ['warnings_expire_days'],
			],
			[ // unexpected config
			  'settings',
			  ['vars' => ['foobar' => []]],
			  ['foobar'],
			],
			[ // unexpected config and mode
			  'foobar',
			  ['vars' => ['foobar' => []]],
			  ['foobar'],
			],
		];
	}

	/**
	 * Test the add_matomoanalytics_configs event
	 *
	 * @dataProvider add_matomoanalytics_configs_data
	 */
	public function test_add_matomoanalytics_configs($mode, $display_vars, $expected_keys)
	{
		$this->set_listener();

		$dispatcher = new \phpbb\event\dispatcher();
		$dispatcher->addListener('core.acp_board_config_edit_add', [$this->listener, 'add_matomoanalytics_configs']);

		$event_data = ['display_vars', 'mode'];
		$event_data_after = $dispatcher->trigger_event('core.acp_board_config_edit_add', compact($event_data));
		extract($event_data_after, EXTR_OVERWRITE);

		$keys = array_keys($display_vars['vars']);

		self::assertEquals($expected_keys, $keys);
	}

	/**
	 * Data set for test_validate_matomoanalytics_url
	 *
	 * @return array Array of test data
	 */
	public function validate_matomoanalytics_url_data()
	{
		return [
			[
				// valid url, no error
				['matomoanalytics_url' => 'https://example.com/', 'matomoanalytics_enabled' => true],
				[],
			],
			[
				// valid url, no error
				['matomoanalytics_url' =>'https://sub.example.com/', 'matomoanalytics_enabled' => true],
				[],
			],
			[
				// valid url, no error
				['matomoanalytics_url' =>'https://example.com/path/', 'matomoanalytics_enabled' => true],
				[],
			],
			[
				// valid url, no error
				['matomoanalytics_url' => 'http://example.com/', 'matomoanalytics_enabled' => true],
				[],
			],
			[
				// missing trainling slash, error
				['matomoanalytics_url' => 'http://example.com', 'matomoanalytics_enabled' => true],
				['ACP_MATOMOANALYTICS_URL_INVALID'],
			],
			[
				// empty url + enabled, error
				['matomoanalytics_url' => '', 'matomoanalytics_enabled' => true],
				['ACP_MATOMOANALYTICS_URL_INVALID'],
			],
			[
				// invalid url + enabled, error
				['matomoanalytics_url' => 'httsp://examplecom', 'matomoanalytics_enabled' => true],
				['ACP_MATOMOANALYTICS_URL_INVALID'],
			],
			[
				// empty url + disabled, no error
				['matomoanalytics_url' => '', 'matomoanalytics_enabled' => false],
				[],
			],
		];
	}

	/**
	 * Test the validate_matomoanalytics_url event
	 *
	 * @dataProvider validate_matomoanalytics_url_data
	 */
	public function test_validate_matomoanalytics_url($cfg_array, $expected_error)
	{
		$this->set_listener();

		$config_name = key($cfg_array);
		$config_definition = ['validate' => 'matomoanalytics_url'];
		$error = [];

		$dispatcher = new \phpbb\event\dispatcher();
		$dispatcher->addListener('core.validate_config_variable', [$this->listener, 'validate_matomoanalytics_url']);

		$event_data = ['cfg_array', 'config_name', 'config_definition', 'error'];
		$event_data_after = $dispatcher->trigger_event('core.validate_config_variable', compact($event_data));

		foreach ($event_data as $expected)
		{
			self::assertArrayHasKey($expected, $event_data_after);
		}
		extract($event_data_after, EXTR_OVERWRITE);

		self::assertEquals($expected_error, $error);
	}
}
