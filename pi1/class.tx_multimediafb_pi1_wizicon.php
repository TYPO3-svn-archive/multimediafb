<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2008 Niels Fröhling (niels.froehling@adsignum.com)
*  All rights reserved
*
*  This script is part of the Typo3 project. The Typo3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Class that adds the wizard icon.
 *
 * @author	Niels Fröhling <niels.froehling@adsignum.com>
 */
class tx_multimediafb_pi1_wizicon {

	/**
	 * Adds the multimediafb wizard icon
	 *
	 * @param	array		Input array with wizard items for plugins.
	 * @return	array		Modified input array, having the item for multimediafb added.
	 */
	function proc($wizardItems) {
		global $LANG;

		$LL = $this->includeLocalLang();

		$wi = array();
		reset($wizardItems);
		foreach ($wizardItems as $key => $value) {
			$wi[$key] = $value;

			if (($key == 'common_textImage') ||
			    ($key == 'common_3')) {
				$wi['common_textMultimediafb'] = array(
					'icon' => 'gfx/c_wiz/text_mmfb_right.gif',
					'title' => $LANG->getLLL('common_textMultimediafb_title', $LL),
					'description' => $LANG->getLLL('common_textMultimediafb_description', $LL),
					'tt_content_defValues' => array(
						'CType' => 'textmmfb',
						'imageorient' => 17
					)
				);
			}

			if (($key == 'common_imagesOnly') ||
			    ($key == 'common_4')) {
				$wi['common_multimediafbOnly'] = array(
					'icon' => 'gfx/c_wiz/multimediafb_only.gif',
					'title' => $LANG->getLLL('common_multimediafbOnly_title', $LL),
					'description' => $LANG->getLLL('common_multimediafbOnly_description', $LL),
					'tt_content_defValues' => array(
						'CType' => 'multimediafb',
						'imagecols' => 2
					)
				);
			}
		}

		return $wi;
	}

	/**
	 * Includes the locallang file for the 'multimediafb' extension
	 *
	 * @return	array		The LOCAL_LANG array
	 */
	function includeLocalLang() {
		$llFile = t3lib_extMgm::extPath('multimediafb') . 'locallang.xml';
		$LOCAL_LANG = t3lib_div::readLLXMLfile($llFile, $GLOBALS['LANG']->lang);

		return $LOCAL_LANG;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/multimediafb/pi1/class.tx_multimediafb_pi1_wizicon.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/multimediafb/pi1/class.tx_multimediafb_pi1_wizicon.php']);
}
?>