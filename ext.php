<?php
/**
 *
 * Matomo Analytics extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2021 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace cube\matomoanalytics;

use phpbb\extension\base;

class ext extends base
{
	/**
	 * {@inheritDoc}
	 */
	public function is_enableable()
	{
		return phpbb_version_compare(PHPBB_VERSION, '3.2.0', '>=');
	}
}
