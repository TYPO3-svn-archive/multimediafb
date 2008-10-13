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

/**
 * Child class for the Web > Page module
 *
 * @author	Kasper Skaarhoj <kasperYYYY@typo3.com>
 * @coauthor    Niels Fröhling <niels.froehling@adsignum.com>
 */
class ux_tx_cms_layout extends tx_cms_layout {

	/**
	 * Draws the preview content for a content element
	 *
	 * @param	string		Content element
	 * @param	boolean		Set if the RTE link can be created.
	 * @return	string		HTML
	 */
	function tt_content_drawItem($row, $isRTE=FALSE)	{
		global $TCA;

		/* we're not responsible for other types than these */
		if ($row['CType'] != 'multimediafb')
			return tx_cms_layout::tt_content_drawItem($row, $isRTE);

		$out='';
		$outHeader='';

			// Make header:
		if ($row['header'] && $row['header_layout']!=100)	{
			$infoArr = Array();
			$this->getProcessedValue('tt_content','header_position,header_layout,header_link',$row,$infoArr);

			$outHeader=  ($row['date'] ? htmlspecialchars($this->itemLabels['date'].' '.t3lib_BEfunc::date($row['date'])).'<br />':'').
					$this->infoGif($infoArr).
					'<b>'.$this->linkEditContent($this->renderText($row['header']),$row).'</b><br />';
		}

			// Make content:
		$infoArr=Array();
		switch($row['CType'])	{
			case 'textmmfb':
			case 'multimediafb':
				if ($row['CType']=='textmmfb')	{
					if ($row['bodytext'])	{
						$this->getProcessedValue('tt_content','text_align,text_face,text_size,text_color,text_properties',$row,$infoArr);
						$out.= $this->infoGif($infoArr).
								$this->linkEditContent($this->renderText($row['bodytext']),$row).'<br />';
					}
				}

				if ($row['CType']=='textmmfb' || $row['CType']=='multimediafb')	{
					/* TODO:
					 * - first try to get a preview-thumbnail
					 * - fall back to the image-field after
					 *
					 * QUESTIONS:
					 * - how do I get a cObj-instance to request a preview?
					 */

					if ($row['image_dam']) {
						require_once(PATH_txdam.'lib/class.tx_dam_image.php');
						require_once(PATH_txdam.'lib/class.tx_dam_tcefunc.php');
						require_once(PATH_txdam.'lib/class.tx_dam_guifunc.php');

						$config = $TCA['tt_content']['columns']['image_dam']['config'];
						$filesArray = tx_dam_db::getReferencedFiles('tt_content', $row['uid'], $config['MM_match_fields'], $config['MM'], 'tx_dam.*');
						foreach($filesArray['rows'] as $rowDAM)	{
							$caption = tx_dam_guiFunc::meta_compileInfoData($rowDAM, '_caption:truncate:100', 'value-string');

#							$imgAttributes['title'] = tx_dam_guiFunc::meta_compileHoverText($rowDAM);
#							$thumb = tx_dam_image::previewImgTag($rowDAM, '', $imgAttributes);
							$thumb = tx_dam_guiFunc::thumbnail($rowDAM);
							$thumb = '<div style="float:left;width:56px; overflow:auto; margin: 2px 5px 2px 0; padding: 5px; background-color:#fff; border:solid 1px #ccc;">'.$thumb.'</div>';
							$thumb = '<div>'.$thumb.$caption.'</div><div style="clear:both"></div>';

							$out.= $thumb;
						}
					}
					else if ($row['image']) {
						$infoArr=Array();
						$this->getProcessedValue('tt_content','imageorient,imageheight,image_link',$row,$infoArr);
						$out.=	$this->infoGif($infoArr).
								$this->thumbCode($row,'tt_content','image').'<br />';

						if ($row['imagecaption'])	{
							$infoArr=Array();
							$this->getProcessedValue('tt_content','imagecaption_position',$row,$infoArr);
							$out.=	$this->infoGif($infoArr).
									$this->linkEditContent($this->renderText($row['imagecaption']),$row).'<br />';
						}
					}
				}
			break;
		}

			// Wrap span-tags:
		$out = '
			<span class="exampleContent">'.$out.'</span>';
			// Add header:
		$out = $outHeader.$out.$row['CType'];
			// Add RTE button:
		if ($isRTE) {
			$out.= $this->linkRTEbutton($row);
		}

			// Return values:
		if ($this->isDisabled('tt_content',$row))	{
			return $GLOBALS['TBE_TEMPLATE']->dfw($out);
		} else {
			return $out;
		}
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/multimediafb/class.ux_tx_cms_layout.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/multimediafb/class.ux_tx_cms_layout.php']);
}
?>
