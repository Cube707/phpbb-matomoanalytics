<?php
/**
 *
 * Matomo Analytics extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace cube\matomoanalytics\tests\functional;

/**
 * @group functional
 */
class matomo_analytics_test extends \phpbb_functional_test_case
{
	/** @var string */
	protected $sample_matomo_url = 'https://example.com/';

	/**
	 * Define the extensions to be tested
	 *
	 * @return array vendor/name of extension(s) to test
	 */
	protected static function setup_extensions()
	{
		return ['cube/matomoanalytics'];
	}

	/**
	 * Test Matomo Analytics ACP page and save settings
	 */
	public function test_set_acp_settings()
	{
		$this->login();
		$this->admin_login();

		// Add language files
		$this->add_lang('acp/board');
		$this->add_lang_ext('cube/matomoanalytics', 'matomoanalytics_acp');

		$found = false;

		// Load ACP board settings page
		$crawler = self::request('GET', 'adm/index.php?i=acp_board&mode=settings&sid=' . $this->sid);

		// Test that Matomo settings field is found in the correct position (after WARNINGS_EXPIRE)
		$nodes = $crawler->filter('#acp_board > fieldset > dl > dt > label')->extract(['_text']);
		foreach ($nodes as $key => $config_name)
		{
			if (strpos($config_name, $this->lang('WARNINGS_EXPIRE')) !== 0)
			{
				continue;
			}

			$found = true;

			$this->assertContainsLang('ACP_MATOMOANALYTICS_ENABLE', $nodes[$key + 1]);
		}

		// If MATOMO settings not found where expected, test if they exist on page at all
		if (!$found)
		{
			$this->assertContainsLang('ACP_MATOMOANALYTICS_ENABLE', $crawler->text());
		}

		// Set MATOMO form values
		$form = $crawler->selectButton($this->lang('SUBMIT'))->form();
		$values = $form->getValues();
		$values['config[matomoanalytics_url]'] = $this->sample_matomo_url;
		$form->setValues($values);

		// Submit form and test success
		$crawler = self::submit($form);
		$this->assertContainsLang('CONFIG_UPDATED', $crawler->filter('.successbox')->text());
	}

	/**
	 * Test Matomo Analytics code appears as expected
	 */
	public function test_matomoanalytics_code()
	{
		// check if the code aprears in the pages head:
		$crawler = self::request('GET', 'index.php');
		self::assertStringContainsString("<!-- Matomo -->", $crawler->filter('head')->html());
	}
}
