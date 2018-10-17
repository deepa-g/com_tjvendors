<?php
/**
 * @version    SVN:<SVN_ID>
 * @package    TJ-vendors
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (c) 2009-2017 TechJoomla. All rights reserved
 * @license    GNU General Public License version 2, or later
 */

// No direct access
defined('_JEXEC') or die('Restricted access');
JLoader::import('components.com_tjvendors.helpers.mails', JPATH_SITE);

/**
 * TJ-vendors triggers class for vendors.
 *
 * @since  2.1
 */
class TjvendorsTriggerVendor
{
	/**
	 * Method acts as a consturctor
	 *
	 * @since   1.0.0
	 */
	public function __construct()
	{
		$app = JFactory::getApplication();
		$this->user = JFactory::getUser();
		$this->tjvendorsMailsHelper = new TjvendorsMailsHelper;
	}

	/**
	 * Trigger for vendor after save
	 *
	 * @param   int      $vendorDetails  Vendor Details
	 * @param   boolean  $isNew          isNew = true / !isNew = false
	 *
	 * @return  void
	 */
	public function onAfterVendorSave($vendorDetails, $isNew)
	{
		switch ($isNew)
		{
			/* New Vendor is created */
			case true:
					/* Send mail on Vendor create */
					$this->tjvendorsMailsHelper->onAfterVendorCreate((object) $vendorDetails);
				break;

			/* Vendor is editted */
			case false:
					/* Send mail on Vendor edit */
					$this->tjvendorsMailsHelper->onAfterVendorEdit((object) $vendorDetails);
				break;
		}
		
		$dispatcher = JDispatcher::getInstance();
		JPluginHelper::importPlugin('tjvendors');
		$dispatcher->trigger('tjVendorsOnAfterVendorSave', array($vendorDetails, $isNew));

		return;
	}
}
