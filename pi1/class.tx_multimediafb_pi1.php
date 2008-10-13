<?php
/***************************************************************
*  Copyright notice
*
*  (c) 1999-2005 Kasper Skaarhoj (kasperYYYY@typo3.com)
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

require_once(PATH_tslib."class.tslib_pibase.php");
require_once(t3lib_extMgm::extPath('css_styled_content').'pi1/class.tx_cssstyledcontent_pi1.php');

/**
 * Plugin 'Multimedia w/Fallback' for the 'multimediafb' extension.
 *
 * @author	Kasper Skaarhoj <kasperYYYY@typo3.com>
 * @coauthor	Niels Fröhling <niels.froehling@adsignum.com>
 */
class tx_multimediafb_pi1 extends tslib_pibase {
	var $prefixId = "tx_multimediafb_pi1";		// Same as class name
	var $scriptRelPath = "pi1/class.tx_multimediafb_pi1.php";	// Path to this script relative to the extension dir.
	var $extKey = "multimediafb";	// The extension key.
	var $conf = array();

	function addMetaToData ($meta) {
		foreach ($meta as $key => $value) {
			$this->cObj->data['txdam_'.$key] = $value;
		}
	}

	function removeMetaFromData () {
		foreach ($this->cObj->data as $key => $value) {
			if (substr($key, 0, 6)=='txdam_') {
				unset($this->cObj->data[$key]);
			}
		}
	}

	/**
	 * [Put your description here]
	 */
	function render_multimediafb($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();

	ob_start ();

//echo '<h1>Conf-Array</h1><pre>';
//print_r($conf); echo '</pre>';
//echo '<h1>cObj-Data-Array</h1><pre>';
//print_r($this->cObj->data); echo '</pre>';

			// Look for hook before running default code for function
//		if (method_exists($this, 'hookRequest') && $hookObj = &$this->hookRequest('render_multimediafb'))
//			return $hookObj->render_multimediafb($content,$conf);

		/* ------------------------------------------------------------------------------ */
		$embedTypes = array('object', 'embed', 'script', 'native');
		$controlTypes = array('none', 'native', 'custom');
		$autoplayTypes = array('off', 'on', 'script');
		$autoloopTypes = array('off', 'on', 'script');
		$failTypes = array('plugin', 'browser', 'script');

//		$this->cObj->data['tx_multimediafb_tag']
//		$this->cObj->data['tx_multimediafb_controls']
//		$this->cObj->data['tx_multimediafb_autoplay']
//		$this->cObj->data['tx_multimediafb_autoloop']
//		$this->cObj->data['tx_multimediafb_playlist']
//		$this->cObj->data['tx_multimediafb_failure']

		$embedMethod = $this->cObj->stdWrap($conf['embedMethod'], $conf['embedMethod.']);
		if (isset($this->cObj->data['tx_multimediafb_tag']))
			$embedMethod = $embedTypes[$this->cObj->data['tx_multimediafb_tag']];

			// Specific configuration for the chosen embedding method
		if (is_array($conf['embedding.'][$embedMethod . '.']))
			$conf = $this->cObj->joinTSarrays($conf, $conf['embedding.'][$embedMethod . '.']);

		/* ------------------------------------------------------------------------------ */
		$controlDisplay = $this->cObj->stdWrap($conf['controlDisplay'], $conf['controlDisplay.']);
		if (isset($this->cObj->data['tx_multimediafb_controls']))
			$controlDisplay = $controlTypes[$this->cObj->data['tx_multimediafb_controls']];

			// Specific configuration for the chosen controlding method
		if (is_array($conf['controlling.'][$embedMethod . '.'][$controlDisplay . '.']))
			$conf['controll.'] = /*$this->cObj->joinTSarrays($conf,*/ $conf['controlling.'][$embedMethod . '.'][$controlDisplay . '.']/*)*/;

		/* ------------------------------------------------------------------------------ */
		$autoplayAction = $this->cObj->stdWrap($conf['autoplayAction'], $conf['autoplayAction.']);
		if (isset($this->cObj->data['tx_multimediafb_autoplay']))
			$autoplayAction = $autoplayTypes[$this->cObj->data['tx_multimediafb_autoplay']];

			// Specific configuration for the chosen autoplayding method
		if (is_array($conf['autoplaying.'][$embedMethod . '.'][$autoplayAction . '.']))
			$conf['autoplay.'] = /*$this->cObj->joinTSarrays($conf,*/ $conf['autoplaying.'][$embedMethod . '.'][$autoplayAction . '.']/*)*/;

		/* ------------------------------------------------------------------------------ */
		$autoloopAction = $this->cObj->stdWrap($conf['autoloopAction'], $conf['autoloopAction.']);
		if (isset($this->cObj->data['tx_multimediafb_autoloop']))
			$autoloopAction = $autoloopTypes[$this->cObj->data['tx_multimediafb_autoloop']];

			// Specific configuration for the chosen autolooping method
		if (is_array($conf['autolooping.'][$embedMethod . '.'][$autoloopAction . '.']))
			$conf['autoloop.'] = /*$this->cObj->joinTSarrays($conf,*/ $conf['autolooping.'][$embedMethod . '.'][$autoloopAction . '.']/*)*/;

		/* ------------------------------------------------------------------------------ */
		$failMethod = $this->cObj->stdWrap($conf['failMethod'], $conf['failMethod.']);
	//	if (isset($this->cObj->data['tx_multimediafb_failure']))
	//		$autoloopAction = $failTypes[$this->cObj->data['tx_multimediafb_failure']];

			// Specific configuration for the chosen failing method
		if (is_array($conf['failing.'][$failMethod . '.']))
			$conf = $this->cObj->joinTSarrays($conf, $conf['failing.'][$failMethod . '.']);

		/* ------------------------------------------------------------------------------ */
		$renderMethod = $this->cObj->stdWrap($conf['renderMethod'], $conf['renderMethod.']);

			// Specific configuration for the chosen rendering method
		if (is_array($conf['rendering.'][$renderMethod . '.']))
			$conf = $this->cObj->joinTSarrays($conf, $conf['rendering.'][$renderMethod . '.']);

		/* ------------------------------------------------------------------------------ */
			// Image or Text with Image?
		if (is_array($conf['text.']))
			$content = $this->cObj->stdWrap($this->cObj->cObjGet($conf['text.'], 'text.'), $conf['text.']);

		$fileList = trim($this->cObj->stdWrap($conf['fileList'], $conf['fileList.']));
		$imgList  = trim($this->cObj->stdWrap($conf['imgList' ], $conf['imgList.' ]));

echo '<h2>FileList</h2><pre>';
print_r($fileList); echo '</pre>';
echo '<h2>ImageList</h2><pre>';
print_r($imgList); echo '</pre>';

			// No multimedia, that's easy
		if (!$fileList)	{
			if (is_array($conf['stdWrap.']))
				return $this->cObj->stdWrap($content, $conf['stdWrap.']);
			return $content;
		}

		/* ------------------------------------------------------------------------------ */
		$files     = t3lib_div::trimExplode(',', $fileList);
		$fileStart = intval($this->cObj->stdWrap($conf['fileStart'], $conf['fileStart.']));
		$fileMax   = intval($this->cObj->stdWrap($conf['fileMax'  ], $conf['fileMax.'  ]));
		$fileCount = count($files) - $fileStart; if ($fileMax)
		$fileCount = t3lib_div::intInRange($fileCount, 0, $conf['fileMax']);	// reduce the number of images.
		$filePath  = $this->cObj->stdWrap($conf['filePath'], $conf['filePath.']);

		$imgs      = t3lib_div::trimExplode(',', $imgList);
		$imgPath   = $this->cObj->stdWrap($conf['imgPath'], $conf['imgPath.']);

			// Global caption ----------------------------------------------------------
		$caption = '';
		if ($this->cObj->data['imagecaption_position'] == 'hidden')
			$hideCaption = true;
		if (!$hideCaption && !$conf['captionEach'] && !$conf['captionSplit'] && !$conf['imageTextSplit'] && is_array($conf['caption.']))
			$caption = $this->cObj->stdWrap($this->cObj->cObjGet($conf['caption.'], 'caption.'), $conf['caption.']);

			// Positioning -------------------------------------------------------------
		$position = $this->cObj->stdWrap($conf['textPos'], $conf['textPos.']);

		$imagePosition   = $position & 7;	// 0,1,2     (center,right,left)
		$contentPosition = $position & 24;	// 0,8,16,24 (above,below,intext,intext-wrap)
		$align = $this->cObj->align[$imagePosition];
		$textMargin = intval($this->cObj->stdWrap($conf['textMargin'],$conf['textMargin.']));
		if (!$conf['textMargin_outOfText'] && $contentPosition < 16)
			$textMargin = 0;

			// Max Width ---------------------------------------------------------------
		$maxW = intval($this->cObj->stdWrap($conf['maxW'], $conf['maxW.']));

		if ($contentPosition >= 16) {	// in Text
			$maxWInText = intval($this->cObj->stdWrap($conf['maxWInText'],$conf['maxWInText.']));
				// If maxWInText is not set, it's calculated to the 50% of the max
			if (!$maxWInText)
				$maxW = round($maxW / 100 * 50);
			else
				$maxW = $maxWInText;
		}

			// Fetches files
		$splitArr = array();
		$splitArr['fileObjNum'] = $conf['fileObjNum'];
		$splitArr = $GLOBALS['TSFE']->tmpl->splitConfArray($splitArr, $fileCount);

		$filesTag = array();
		$filesExtraData = array();
		$origFiles = array();

		$imgsTag = array();
		$imgsExtraData = array();
		$origImages = array();

		$fileBlockWidth = 0;

		for ($a = 0; $a < $fileCount; $a++) {
			$key = $a + $fileStart;
			$totalFilePath  = /* $filePath . */$files[$key];
			$totalImagePath = /* $imgPath  . */$imgs[$key];

			$GLOBALS['TSFE']->register['FILE_NUM'] = $a;
			$GLOBALS['TSFE']->register['FILE_NUM_CURRENT'] = $a;
			$GLOBALS['TSFE']->register['ORIG_FILENAME'] = $totalFilePath;

			$this->cObj->data[$this->cObj->currentValKey] = $totalFilePath;

			/* ---------------------------------------------------------------------- */
			if (t3lib_extMgm::isLoaded('dam') /* && $GLOBALS['T3_VAR']['ext'][$_EXTKEY]['setup']['ctype_multimedia_add_ref'] */) {
				// fetch DAM data and provide it as field data prefixed with txdam_
				$media = tx_dam::media_getForFile($totalFilePath, '*');
				if ($media->isAvailable) {
					$this->addMetaToData($media->getMetaArray());
					$filesExtraData[$key] = $media->getMetaArray();
				} else {
					$this->removeMetaFromData ();
					$filesExtraData[$key] = array();
				}
				unset($media);

				$media = tx_dam::media_getForFile($totalImagePath, '*');
				if ($media->isAvailable) {
					$imgsExtraData[$key] = $media->getMetaArray();
				} else {
					$imgsExtraData[$key] = array();
				}
				unset($media);
			}

			/* ---------------------------------------------------------------------- */
			$fileObjNum = intval($splitArr[$a]['fileObjNum']);
			$fileConf = $conf[$fileObjNum.'.'];

			$titleInLink = $this->cObj->stdWrap($fileConf['titleInLink'], $fileConf['titleInLink.']);
			$titleInLinkAndImg = $this->cObj->stdWrap($fileConf['titleInLinkAndImg'], $fileConf['titleInLinkAndImg.']);
			$oldATagParms = $GLOBALS['TSFE']->ATagParams;
			if ($titleInLink)	{
					// Title in A-tag instead of BED-tag
				$titleText = trim($this->cObj->stdWrap($fileConf['titleText'], $fileConf['titleText.']));
				if ($titleText)
						// This will be used by the MULTIMEDIA call later:
					$GLOBALS['TSFE']->ATagParams .= ' title="'. $titleText .'"';
			}

				// pass the beds to the generator
			$fileConf['beds.'] = $conf['beds.'];
				// pass the hints to the generator
			$fileConf['hints.'] = $conf['hints.'];
				// pass the controls to the generator
			$fileConf['controll.'] = $conf['controll.'];
				// pass the autoloops to the generator
			$fileConf['autoloop.'] = $conf['autoloop.'];
				// pass the autoplays to the generator
			$fileConf['autoplay.'] = $conf['autoplay.'];

//echo '<h2>File ' . $key . '</h2><pre>';
//print_r($fileConf); echo '</pre>';
//echo '<h2>Image ' . $key . '</h2><pre>';
//print_r($imgConf); echo '</pre>';

			if ($fileConf || $fileConf['file'])	{
				if ($titleInLink && ! $titleInLinkAndImg) {
						// Check if the file will be linked
//					$link = $this->cObj->imageLinkWrap('', $totalFilePath, $fileConf['imageLinkWrap.']);
					$link = $this->cObj->typolink('', $fileConf['fileLinkWrap.']['typolink.']);
					if ($link) {
							// Title in A-tag only (set above: ATagParams), not in MULTIMEDIA-tag
						unset($fileConf['titleText']);
						unset($fileConf['titleText.']);

						$fileConf['emptyTitleHandling'] = 'removeAttr';
					}
				}
			}
			else {
				$fileConf = array(
//					'altText' => $conf['altText'],
//					'titleText' => $conf['titleText'],
//					'longdescURL' => $conf['longdescURL'],
					'file' => $totalFilePath
				);
			}

			/* ---------------------------------------------------------------------- */
			$filesTag[$key] = $this->cObj->MULTIMEDIAFALLBACK(
				$fileConf
			);

				// image-fallback active
			if (1)
					// placeholder for auto-preview calculation active
				if (!$totalImagePath || preg_match('/---autopreview---/', $totalImagePath))
						// the preview just fits the file
					$imgsTag[$key]  = $this->cObj->MULTIMEDIAPREVIEW(Array(
						'file'  => $totalFilePath,
						'file.' => Array(
							'width'  => $GLOBALS['TSFE']->lastMultimediaInfo[0],
							'height' => $GLOBALS['TSFE']->lastMultimediaInfo[1]
						)
					));
				else
						// the picture just fits the file
					$imgsTag[$key]  = $this->cObj->IMAGE(Array(
						'file'  => $totalImagePath,
						'file.' => Array(
							'width'  => $GLOBALS['TSFE']->lastMultimediaInfo[0],
							'height' => $GLOBALS['TSFE']->lastMultimediaInfo[1]
						)
					));

echo '<h2>File ' . $key . '</h2><pre>';
print_r($filesTag[$key]); echo $totalFilePath . '</pre>';
echo '<h2>Image ' . $key . '</h2><pre>';
print_r($imgsTag[$key]); echo $totalImagePath . '</pre>';

				// Restore our ATagParams
			$GLOBALS['TSFE']->ATagParams = $oldATagParms;

				// Store the original filepath
			$origFiles[$key]  = $GLOBALS['TSFE']->lastMultimediaInfo;
			$origImages[$key] = $GLOBALS['TSFE']->lastImageInfo;

			$fileBlockWidth = max($fileBlockWidth, $GLOBALS['TSFE']->lastMultimediaInfo[0]);
		}

			// How much space will the file-block occupy?
		$GLOBALS['TSFE']->register['rowwidth'] = $fileBlockWidth;
		$GLOBALS['TSFE']->register['rowWidthPlusTextMargin'] = $fileBlockWidth + $textMargin;

			// Edit icons:
		$editIconsHTML = $conf['editIcons']&&$GLOBALS['TSFE']->beUserLogin ? $this->cObj->editIcons('',$conf['editIcons'],$conf['editIcons.']) : '';

			// If noRows, we need multiple imagecolumn wraps
		$fileWrapCols = 1;
		$rowCount = 1;
		$colCount = 1;

			// Apply optionSplit to the list of classes that we want to add to each image
		$addClassesFile = $conf['addClassesFile'];
		if ($conf['addClassesFile.'])
			$addClassesFile = $this->cObj->stdWrap($conf['addClassesFile'], $conf['addClassesFile.']);
		$addClassesFileConf = $GLOBALS['TSFE']->tmpl->splitConfArray(array('addClassesFile' => $addClassesFile), $colCount);

		$addClassesImage = $conf['addClassesImage'];
		if ($conf['addClassesImage.'])
			$addClassesImage = $this->cObj->stdWrap($conf['addClassesImage'], $conf['addClassesImage.']);
		$addClassesImageConf = $GLOBALS['TSFE']->tmpl->splitConfArray(array('addClassesImage' => $addClassesImage), $colCount);

			// Render the files
		$files = '';
		for ($c = 0; $c < $fileWrapCols; $c++)	{
			for ($i = $c; $i < count($filesTag); $i = $i + $fileWrapCols) {
				ereg('([^\.]*)$', $origFiles[$i][3], $reg); $reg = strtolower($reg[0]);

				$this->addMetaToData($filesExtraData[$i]);

					// Render one file
				$GLOBALS['TSFE']->register['FILE_NUM'        ] = $i;
				$GLOBALS['TSFE']->register['FILE_NUM_CURRENT'] = $i;
				$GLOBALS['TSFE']->register['ORIG_FILENAME'] = $origFiles[$i]['origFile'];
				$GLOBALS['TSFE']->register['filewidth'    ] = $origFiles[$i][0];
				$GLOBALS['TSFE']->register['fileheight'   ] = $origFiles[$i][1];
				$GLOBALS['TSFE']->register['filespace'    ] = $origFiles[$i][0];
				$GLOBALS['TSFE']->register['fileext'      ] = $reg;

				$thisFile = $filesTag[$i];
				$thisAltr = $imgsTag[$i];

					// generate the fall-back action
				if ($conf['hints.'][$reg] && $conf['hints.']['wrap']) {
					$hasControls = true;

					$thisWrap = $conf['hints.']['wrap'];
					$thisWrap = str_replace('###HINT###', $conf['hints.'][$reg], $thisWrap);

					$thisAltr =  $this->cObj->stdWrap($thisAltr, array('dataWrap' => $thisWrap));
				}
				else if (/*$conf['hints.'][$reg] &&*/ $conf['hints.']['wrapalways']) {
					$hasControls = true;

					$thisWrap = $conf['hints.']['wrapalways'];

					$thisAltr =  $this->cObj->stdWrap($thisAltr, array('dataWrap' => $thisWrap));
				}

					// generate the additional controls
				if ($conf['controll.']['params.'][$reg] && $conf['controll.']['params.']['wrap']) {
					$hasControls = true;

					$thisWrap = $conf['controll.']['params.']['wrap'];

					$thisFile =  $this->cObj->stdWrap($thisFile, array('dataWrap' => $thisWrap));
				}
				else if (/*$conf['controll.']['params.'][$reg] &&*/ $conf['controll.']['params.']['wrapalways']) {
					$hasControls = true;

					$thisWrap = $conf['controll.']['params.']['wrapalways'];

					$thisFile =  $this->cObj->stdWrap($thisFile, array('dataWrap' => $thisWrap));
				}

					// substitute configured alternative-content
				$thisFile = str_replace('###ALTERNATIVE###', $thisAltr, $thisFile);
				$thisFile = str_replace('###SRC###', $origFiles[$i][3], $thisFile);

					// substitute registers
				$thisFile = $this->cObj->stdWrap('', array('dataWrap' => $thisFile));
				$thisFile = $this->cObj->stdWrap($thisFile, $conf['fileTagStdWrap.']);
				if (!$hideCaption && ($conf['captionEach'] || $conf['captionSplit'] || $conf['imageTextSplit'])) {
					$thisCaption = $this->cObj->stdWrap($this->cObj->cObjGet($conf['caption.'], 'caption.'), $conf['caption.']);
					$thisFile .= $thisCaption;
				}

				if ($editIconsHTML)
					$thisFile .= $this->cObj->stdWrap($editIconsHTML, $conf['editIconsStdWrap.']);
				if ($conf['netprintApplicationLink'])
					$thisFile .= $this->cObj->netprintApplication_offsiteLinkWrap($thisFile, $origImages[$i], $conf['netprintApplicationLink.']);

				$thisFile = $this->cObj->stdWrap($thisFile, $conf['oneFileStdWrap.']);

				$classes = '';
				if ($addClassesFileConf[$colPos]['addClassesFile'])
					$classes = ' ' . $addClassesFileConf[$colPos]['addClassesFile'];

				$thisFile = str_replace('###CLASSES###', $classes, $thisFile);

				$files .= $thisFile;
			}
		}

			// Add the global caption, if not split
		if ($caption)
			$files .= $caption;

			// CSS-classes
		$captionClass = '';
		$classCaptionAlign = array(
			'center' => 'csc-mmfb-caption-c',
			'right' => 'csc-mmfb-caption-r',
			'left' => 'csc-mmfb-caption-l', );
		$captionAlign = $this->cObj->stdWrap($conf['captionAlign'], $conf['captionAlign.']);
		if ($captionAlign)
			$captionClass = $classCaptionAlign[$captionAlign];

			// CSS-classes
		$controlClass = '';
		if ($hasControls)
			$controlClass = 'csc-mmfb-controls';

			// Multiple classes with all properties, to be styled in CSS
		$class = '';
		$class .= ($captionClass? ' '.$captionClass:'');
		$addClasses = $this->cObj->stdWrap($conf['addClasses'], $conf['addClasses.']);
		$class .= ($addClasses ? ' '.$addClasses:'');

			// Multiple classes with all properties, to be styled in CSS
		$subclass = '';
		$subclass .= ($controlClass? ' '.$controlClass:'');

			// Do we need a width in our wrap around files?
		$fileWrapWidth = '';
		if ($position == 0 || $position == 8)
				// For 'center' we always need a width: without one, the margin:auto trick won't work
			$fileWrapWidth = $fileBlockWidth;
		if ($rowCount > 1)
				// For multiple rows we also need a width, so that the files will wrap
			$fileWrapWidth = $fileBlockWidth;
		if ($caption)
				// If we have a global caption, we need the width so that the caption will wrap
			$fileWrapWidth = $fileBlockWidth;

			// Wrap around the whole file block
		if (($GLOBALS['TSFE']->register['totalwidth'] = $fileWrapWidth))
			$files = $this->cObj->stdWrap($files, $conf['fileStdWrap.']);
		else
			$files = $this->cObj->stdWrap($files, $conf['fileStdWrapNoWidth.']);

		$output = $this->cObj->cObjGetSingle($conf['layout'], $conf['layout.']);
		$output = str_replace('###TEXT###', $content, $output);
		$output = str_replace('###FILES###', $files, $output);
		$output = str_replace('###CLASSES###', $class, $output);
		$output = str_replace('###SUBCLASS###', $subclass, $output);

		if ($conf['stdWrap.'])
			$output = $this->cObj->stdWrap($output, $conf['stdWrap.']);

		$this->removeMetaFromData();

//echo '<h1>Conf-Array (after)</h1><pre>';
//print_r($conf); echo '</pre>';
//echo '<h1>cObj-Data-Array (after)</h1><pre>';
//print_r($this->cObj->data); echo '</pre>';
echo '<h1>Result</h1><pre>';
print_r($output); echo '</pre>';

	$content =
		str_replace("&lt;h1&gt;", "<h1>",
		str_replace("&lt;/h1&gt;", "</h1>",
		str_replace("&lt;pre&gt;", "<pre>",
		str_replace("&lt;/pre&gt;", "</pre>",
		htmlspecialchars(ob_get_contents()))))) . '<hr />' . $content;
	ob_end_clean ();

		return $output;

		/* ------------------------------------------------------------------------------ */
		if (0) switch ($this->cObj->data["tx_multimediafb_tag"]) {
			case 0:
				$tag = "<embed src=\"uploads/tx_multimediafb/" .
					$this->cObj->data["multimedia"] .
					"\" width=\"" .
					$this->cObj->data["imagewidth"] .
					"\" height=\"" .
					$this->cObj->data["imageheight"] .
					"\" type=\"image/svg+xml\" name=\"emap\">";
				break;
			case 1:
				$tag = "<object data=\"uploads/tx_multimediafb/" .
					$this->cObj->data["multimedia"] .
					"\" width=\"" .
					$this->cObj->data["imagewidth"] .
					"\" height=\"" .
					$this->cObj->data["imageheight"] .
					"\" type=\"image/svg+xml\" name=\"emap\"></object>";
				break;
			case 2:
				$tag = "<iframe src=\"uploads/tx_multimediafb/" .
					$this->cObj->data["multimedia"] .
					"\" width=\"" .
					$this->cObj->data["imagewidth"] .
					"\" height=\"" .
					$this->cObj->data["imageheight"] .
					"\" name=\"emap\"></iframe>";
				break;
			case 3:
				$tag = "<script src=\"uploads/tx_multimediafb/" .
					$this->cObj->data["multimedia"] .
					"\" width=\"" .
					$this->cObj->data["imagewidth"] .
					"\" height=\"" .
					$this->cObj->data["imageheight"] .
					"\" name=\"emap\"></script>";
				break;
		}

		$content .= $tag;

		return /*$this->pi_wrapInBaseClass(*/ $content . $imgsTag[0] /*)*/;
	}

	/**
	 * Returns an object reference to the hook object if any
	 *
	 * @param	string		Name of the function you want to call / hook key
	 * @return	object		Hook object, if any. Otherwise null.
	 */
	function &hookRequest($functionName)	{
		global $TYPO3_CONF_VARS;

			// Hook: menuConfig_preProcessModMenu
		if ($TYPO3_CONF_VARS['EXTCONF']['tx_multimediafb']['pi1_hooks'][$functionName]) {
			$hookObj = &t3lib_div::getUserObj($TYPO3_CONF_VARS['EXTCONF']['tx_multimediafb']['pi1_hooks'][$functionName]);
			if (method_exists ($hookObj, $functionName)) {
				$hookObj->pObj = &$this;
				return $hookObj;
			}
		}
	}
}

if (defined("TYPO3_MODE") && $TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/multimediafb/pi1/class.tx_multimediafb_pi1.php"])
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/multimediafb/pi1/class.tx_multimediafb_pi1.php"]);

?>
