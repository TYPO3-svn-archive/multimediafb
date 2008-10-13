<?php
/***************************************************************
*  Copyright notice
*
*  (c) 1999-2005 Kasper Skaarhoj (kasperYYYY@typo3.com)
*  (c) 2008      Niels Fröhling (niels.froehling@adsignum.com)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once(t3lib_extMgm::extPath('cms') . 'tslib/' . "class.tslib_content.php");
require_once(t3lib_extMgm::extPath('multimediafb') . "class.ux_tslib_content.php");

/**
 * Child class for the Web > Page module
 *
 * @author	Kasper Skaarhoj <kasperYYYY@typo3.com>
 * @coauthor    Niels Fröhling <niels.froehling@adsignum.com>
 */
class tx_tv_rendering {

	/**
	 * Draws the preview content for a content element
	 *
	 * @param	string		Content element
	 * @param	boolean		Set if the RTE link can be created.
	 * @return	string		HTML
	 */
	function renderPreviewContent_preProcess ($row, $table, &$alreadyRendered, $tv) {
		global $TCA, $LANG;

		/* we're not responsible for other types than these */
		if (($row['CType'] != 'textmmfb') &&
		    ($row['CType'] != 'multimediafb'))
			return;

		$output = '';

		if (!$alreadyRendered) {
				// Preview content for non-flexible content elements:
			switch($row['CType'])	{
				case 'textmmfb':	//	Text w/multimedia w/fallback
					$text = '<strong>'.
							$LANG->sL(t3lib_BEfunc::getItemLabel('tt_content', 'bodytext'), 1).
						'</strong> '.
						htmlspecialchars(
							t3lib_div::fixed_lgd_cs(
								trim(strip_tags($row['bodytext'])),
								2000
							)
						);
				case 'multimediafb':	//	Multimedia w/fallback
					if (t3lib_extMgm::isLoaded('dam') /* && $GLOBALS['T3_VAR']['ext'][$_EXTKEY]['setup']['ctype_multimedia_add_ref'] */) {
						$files = tx_dam_db::getReferencedFiles('tt_content', $row['uid'], 'multimedia_dam');
						$files = $files['files'];
						$picts = tx_dam_db::getReferencedFiles('tt_content', $row['uid'], 'image_dam');
						$picts = $picts['files'];
					}
					else {
						$files = $row['multimedia'];
						$picts = $row['image'];
					}

					$mmfb = '<strong>'.
							$LANG->sL(t3lib_BEfunc::getItemLabel('tt_content', 'multimedia'), 1).
						'</strong>' .
						'<br /> ';

					/* - first try to get a preview-thumbnail
					 * - fall back to the image-field after
					 */
					$movieCreator = t3lib_div::makeInstance('ux_tslib_stdGraphic');
					$movieCreator->init();
					$movieCreator->filenamePrefix = 'tmb_';
					$movieCreator->absPrefix = PATH_site;

					$files = array_values($files);
					$picts = array_values($picts);

					for ($f = 0; $f < count($files); $f++) {
						$info = $movieCreator->exoticConvert(
							PATH_site . $files[$f],
							'png'
						);

						if ($info) {
							$info = $movieCreator->imageMagickConvert(
								$info[3],
								'png',
								'',
								'',
								'',
								'',
								array('maxW' => 56, 'maxH' => 56)
							);
						}
						else if (!$info && $picts[$f]) {
							$info = $movieCreator->imageMagickConvert(
								PATH_site . $picts[$f],
								'gif',
								'',
								'',
								'',
								'',
								array('maxW' => 56, 'maxH' => 56)
							);
						}

						if (!$info)
							$mmfb .= $files[$f] . ', ';
						else
							$mmfb .= '<img hspace="2" border="0" src="' . str_replace(PATH_site, '/', $info[3]) . '" alt="" title="../' . $files[$f] . '" /> ';
					}

					if ($text && $mmfb)
						$output =
							'<table><tr><td valign="top">'.
								$tv->link_edit($text, 'tt_content', $row['uid']) .
							'</td><td valign="top">'.
								$mmfb.
							'</td></tr></table>'.
							'<br />';
					else if ($mmfb)
						$output =
							$tv->link_edit($mmfb, 'tt_content', $row['uid']) .
							'<br />';
					else if ($text)
						$output =
							$tv->link_edit($text, 'tt_content', $row['uid']) .
							'<br />';
					break;
			}

			$alreadyRendered = true;
		}

		return $output;
	}

}
?>
