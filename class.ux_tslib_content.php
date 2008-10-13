<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2006 Heiner Lamprecht (typo3@heiner-lamprecht.net)
*  (c) 2008 Niels Fröhling (niels.froehling@adsignum.com)
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
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once(PATH_t3lib."class.t3lib_stdgraphic.php");

/**
 * Child class for the graphics processing
 *
 * @author	Heiner Lamprecht <typo3@heiner-lamprecht.net>
 * @coauthor    Niels Fröhling <niels.froehling@adsignum.com>
 */
class ux_tslib_stdGraphic extends t3lib_stdGraphic {

	var $mmFileExt = "pdf,svg,x3d,x3dv,wrl,vrml,avi,mng,m1v,m2v,m4v,mp1,mp2,mp4,mpg,mpeg,mov,qt,rm,wmv";

	/**
	 * Gets the multimedia file dimensions.
	 *
	 * @param	string		The file filepath
	 * @return	array		Returns an array where [0]/[1] is w/h, [2] is extension and [3] is the filename.
	 */
	function getMultimediaDimensions($mmFile) {
		ereg('([^\.]*)$', $mmFile, $reg);
		if (@file_exists($mmFile) && t3lib_div::inList($this->mmFileExt,strtolower($reg[0]))) {
		//	if ($returnArr = $this->getCachedImageDimensions($mmFile))
		//		return $returnArr;

			switch (strtolower($reg[0])) {
				/* 2D-Vector ---------------------------------------------------- */
				case "pdf":
					/* size is not really important in pixels, we fetch
					 * paper-size here to provide an aspect-ratio correct
					 * dimension
					 */
					// TODO
					break;
				case "svg":
					/* size is not really important in pixels, we fetch
					 * viewport-size here to provide an aspect-ratio correct
					 * dimension
					 */
					$svg = file_get_contents($mmFile);

					preg_match('/<svg(.*?)>/', str_replace(Array("\n", "\r", "\t", "[", "]"), " ", $svg), $matches);

					preg_match('/width="(.*?)"/', $matches[1], $width);
					preg_match('/height="(.*?)"/', $matches[1], $height);
					preg_match('/viewBox="(.*?)"/', $matches[1], $viewBox);

					/* the width/height may contain percentages, so we prefer
					 * the viewBox if available, because it defines the coordinate-
					 * system, which is a more accurate measure
					 *
					 * NOTE: possibly it is indeed desirable to create a copy of the
					 * svg, and set width/height to 100%, the problem is still that
					 * we would need to take care of external-resource xlinks, which I
					 * like to prevent to treat for now
					 */
					if ($viewBox[1]) {
						preg_match('/^([0-9.]+?) +?([0-9.]+?) +?([0-9.]+?) +?([0-9.]+?)$/', $viewBox[1], $coords);

						$temp[0] = ceil($coords[3]);
						$temp[1] = ceil($coords[4]);
					}
					else {
						$temp[0] = ceil($width[1]);
						$temp[1] = ceil($height[1]);
					}

					$returnArr = Array($temp[0], $temp[1], strtolower($reg[0]), $mmFile);
					break;
				/* 3D ----------------------------------------------------------- */
				case "x3d":
					break;
				case "x3dv":
					break;
				case "wrl":
				case "vrml":
					break;
				/* 2D-Video ----------------------------------------------------- */
				case "mng":
					$returnArr = t3lib_stdGraphic::imageMagickIdentify($mmFile);
					break;
				case "avi":
				case "m1v":
				case "m2v":
				case "m4v":
				case "mp1":
				case "mp2":
				case "mp4":
				case "mpg":
				case "mpeg":
				case "mov":
				case "qt":
				case "rm":
				case "wmv":
					if (!extension_loaded("ffmpeg") ||
					    !($movie = new ffmpeg_movie($mmFile, false)))
						return false;

					$returnArr = Array($movie->getFrameWidth(), $movie->getFrameHeight(), strtolower($reg[0]), $mmFile);
					break;
			}

			if ($returnArr) {
				$this->cacheImageDimensions($returnArr);
				return $returnArr;
			}
		}

		return false;
	}

	/**
	 * Executes a varying "snapshot" on two filenames, $input and $output using $params before them.
	 *
	 * @param	string		The relative (to PATH_site) multimedia filepath, input file (read from)
	 * @param	string		The relative (to PATH_site) multimedia filepath, output filename (written to)
	 * @param	string		RSVG parameters
	 * @return	string		The result of a call to PHP function "exec()"
	 */
	function exoticExec($input,$output,$params)	{
		// rsvg for svg->png
		// ffmpeg-php/gd2 for movie->png
		ereg('([^\.]*)$', $input, $reg);
		if (@file_exists($input) && t3lib_div::inList($this->mmFileExt,strtolower($reg[0]))) {
			switch (strtolower($reg[0])) {
				/* 2D-Vector ---------------------------------------------------- */
				case "pdf":
					/* I suppose there is no difference in calling imageMagick
					 * with pdf-support or ghostscript directly, except that imageMagick
					 * wraps around the very same command-line tool supporting more
					 * output-formats
					 */
					$ret = exec(
						"gs" .
						" -dFirstPage=" . $params['frame'] .
						" -dLastPage=" . $params['frame'] .
						" -sDEVICE=png" .
						" -sOutputFile=" . $this->wrapFileName($output) .
						" " . $this->wrapFileName($input)
					);
					break;
				case "svg":
					/* I suppose there is no difference in calling imageMagick
					 * with rsvg-support or rsvg directly, except that imageMagick
					 * wraps around the very same command-line tool supporting more
					 * output-formats
					 */
					$ret = exec(
						"cd" .
						" " . $this->wrapFileName(dirname($input) . "/") . " && " .
						"rsvg" .
						" " . $this->wrapFileName(basename($input)) .
						" " . $this->wrapFileName(basename($output))
					);
					       exec(
						"mv -f " .
						" " . $this->wrapFileName(dirname($input) . "/" . basename($output)) .
						" " . $this->wrapFileName($output)
					);
					break;
				/* 3D ----------------------------------------------------------- */
				case "x3d":
					break;
				case "x3dv":
					break;
				case "wrl":
				case "vrml":
					break;
				/* 2D-Video ----------------------------------------------------- */
				case "mng":
					/* we have build-in support here, no external tool available */
					$ret = t3lib_stdGraphic::imageMagickExec($input . '[' . $params['frame'] . ']', $output, '');
					break;
				case "avi":
				case "m1v":
				case "m2v":
				case "m4v":
				case "mp1":
				case "mp2":
				case "mp4":
				case "mpg":
				case "mpeg":
				case "mov":
				case "qt":
				case "rm":
				case "wmv":
					/* we have plug-in support here */
					// TODO: fallback to ffmpegExec()
					$ret = -1;
					if (!extension_loaded("ffmpeg") ||
					    !($movie = new ffmpeg_movie($input, false)) ||
					    !($frame = $movie->getFrame($params['frame'])) ||
					    !($frame = $frame->toGDImage()))
						break;

					if (function_exists('imagepng'))
						$ret = imagepng($frame, $output);
					break;
				default:
					$ret = -1;
			}
		}

		t3lib_div::fixPermissions($this->wrapFileName($output));	// Change the permissions of the file
	}

	/**
	 * Converts $mmfile to another file in temp-dir of type $newExt (extension).
	 *
	 * @param	string		The multimedia filepath
	 * @param	string		New extension, eg. "gif", "png", "jpg", "tif". If $newExt is NOT set, the new mmfile will be of the 'png' format.
	 * @param	string		Width. $w / $h is optional. If only one is given the image is scaled proportionally. If an 'm' exists in the $w or $h and if both are present the $w and $h is regarded as the Maximum w/h and the proportions will be kept
	 * @param	string		Height. See $w
	 * @param	string		Additional exotic parameters.
	 * @param	string		Refers to which frame-number to select in the image. '' or 0 will select the first frame, 1 will select the next and so on...
	 * @param	array		An array with options passed to getImageScale (see this function).
	 * @param	boolean		If set, then another image than the input mmfile MUST be returned. Otherwise you can risk that the input image is good enough regarding messures etc and is of course not rendered to a new, temporary file in typo3temp/. But this option will force it to.
	 * @return	array		[0]/[1] is w/h, [2] is file extension and [3] is the filename.
	 * @see getImageScale(), typo3/show_item.php, fileList_ext::renderImage(), tslib_cObj::getImgResource(), SC_tslib_showpic::show(), maskImageOntoImage(), copyImageOntoImage(), scale()
	 */
	function exoticConvert($mmFile,$newExt='png',$w='',$h='',$params='',$frame='',$options='',$mustCreate=0) {
		if (0 /*!extension_loaded("ffmpeg")*/)	{
				// Returning file info right away
			return $this->getMultimediaDimensions($mmFile);
		}

		if (($info = $this->getMultimediaDimensions($mmFile))) {
			$newExt=strtolower(trim($newExt));
			if (!$newExt)	// If no extension is given 'png' is used
				$newExt = 'png';
			if ($newExt == 'web')	{
				if (t3lib_div::inList($this->webImageExt,'png'))
					$newExt = 'png';
				else
					$newExt = $this->gif_or_jpg('png',$info[0],$info[1]);
			}

			$frame = $this->noFramePrepended ? '' : '['.intval($frame).']';
			$command = $info[0].'x'.$info[1].'!';

			if ($this->alternativeOutputKey)
				$theOutputName = t3lib_div::shortMD5($command.basename($mmFile).$this->alternativeOutputKey.$frame);
			else
				$theOutputName = t3lib_div::shortMD5($command.$mmFile.filemtime($mmFile).$frame);

				// Making the temporary filename:
			$this->createTempSubDir('pics/');
			$output = $this->absPrefix.$this->tempPath.'pics/'.$this->filenamePrefix.$theOutputName.'.'.$newExt;

				// Register temporary filename:
			$GLOBALS['TEMP_IMAGES_ON_PAGE'][] = $output;

                	if ($this->dontCheckForExistingTempFile || !$this->file_exists_typo3temp_file($output,$mmFile)) {
                        	$options['frame'] = intval($frame) + 1;
				$this->exoticExec($mmFile, $output, $options);
			}

			if (@file_exists($output))	{
				$info[3] = $output;
				$info[2] = $newExt;

				return $info;
			}
		}
	}
}

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
class ux_tslib_cObj extends tslib_cObj {

	function getMMPreviewResource($file, $fileArray) {
		if (is_array($fileArray)) {
			switch($file) {
				default:
					if ($fileArray['import.']) {
						$ifile = $this->stdWrap('',$fileArray['import.']);
						if ($ifile) {$file = $fileArray['import'].$ifile;}
					}
				break;
			}
		}

		$theFile = $GLOBALS['TSFE']->tmpl->getFileName($file);
		if ($theFile) {
			/* we do a full-resolution conversion here, no real hash nessessary */
			$hash = t3lib_div::shortMD5($theFile /*.serialize($fileArray)*/);

			if (!isset($GLOBALS['TSFE']->tmpl->fileCache[$hash])) {
				$movieCreator = t3lib_div::makeInstance('ux_tslib_stdGraphic');
				$movieCreator->init();

				if ($GLOBALS['TSFE']->config['config']['meaningfulTempFilePrefix'])
					$movieCreator->filenamePrefix = $GLOBALS['TSFE']->fileNameASCIIPrefix(ereg_replace('\.[[:alnum:]]+$','',basename($theFile)),intval($GLOBALS['TSFE']->config['config']['meaningfulTempFilePrefix']),'_');

				if ($fileArray['alternativeTempPath'] && t3lib_div::inList($GLOBALS['TYPO3_CONF_VARS']['FE']['allowedTempPaths'],$fileArray['alternativeTempPath'])) {
					$movieCreator->tempPath = $fileArray['alternativeTempPath'];
					$GLOBALS['TT']->setTSlogMessage('Set alternativeTempPath: '.$fileArray['alternativeTempPath']);
				}

				$GLOBALS['TSFE']->tmpl->fileCache[$hash] = $movieCreator->exoticConvert(
					$theFile,
					$fileArray['ext'],
					$fileArray['width'],
					$fileArray['height'],
					$fileArray['params'],
					$fileArray['frame'],
					$options
				);

				$GLOBALS['TSFE']->tmpl->fileCache[$hash]['origFile'] = $theFile;
				$GLOBALS['TSFE']->tmpl->fileCache[$hash]['origFile_mtime'] = @filemtime($theFile);	// This is needed by tslib_gifbuilder, ln 100ff in order for the setup-array to create a unique filename hash.
			}

			return $this->getImgResource($GLOBALS['TSFE']->tmpl->fileCache[$hash][3], $fileArray);
		}
	}

	/**
	 * Creates and returns a TypoScript "multimediaResource".
	 * The value ($file) can only be a file reference (TypoScript resource).
	 * In the function MULTIMEDIA_RESOURCE() this function is called like $this->getMultimediaResource($conf['file'],$conf['file.']);
	 *
	 * @param	string		A "multimediaResource" TypoScript data type. Only a TypoScript file resource. See description above.
	 * @param	array		TypoScript properties for the multimediaResource type
	 * @return	array		Returns info-array. info[origFile] = original file.
	 * @see MULTIMEDIA_RESOURCE(), cMultimedia()
	 */
	function getMultimediaResource($file, $fileArray) {
		if (is_array($fileArray)) {
			switch($file) {
				default:
					if ($fileArray['import.']) {
						$ifile = $this->stdWrap('',$fileArray['import.']);
						if ($ifile) {$file = $fileArray['import'].$ifile;}
					}
				break;
			}
		}

		$theFile = $GLOBALS['TSFE']->tmpl->getFileName($file);
		if ($theFile) {
			$movieCreator = t3lib_div::makeInstance('ux_tslib_stdGraphic');
			$movieCreator->init();

			$info = $movieCreator->getMultimediaDimensions($theFile);

			/* apply min/max data-adjustments, the file itself is not changed, but
			 * rather fetched unmodified and rescaled inplace by the browser!
			 */
			if (is_array($fileArray)) {
				$fileArray['width' ] = $this->stdWrap($fileArray['width' ], $fileArray['width.' ]);
				$fileArray['height'] = $this->stdWrap($fileArray['height'], $fileArray['height.']);
				$fileArray['ext'   ] = $this->stdWrap($fileArray['ext'   ], $fileArray['ext.'   ]);
				$fileArray['maxW'  ] = intval($this->stdWrap($fileArray['maxW'], $fileArray['maxW.']));
				$fileArray['maxH'  ] = intval($this->stdWrap($fileArray['maxH'], $fileArray['maxH.']));
				$fileArray['minW'  ] = intval($fileArray['minW']);
				$fileArray['minH'  ] = intval($fileArray['minH']);

				if ($fileArray['maxW']) { $options['maxW'] = $fileArray['maxW']; }
				if ($fileArray['maxH']) { $options['maxH'] = $fileArray['maxH']; }
				if ($fileArray['minW']) { $options['minW'] = $fileArray['minW']; }
				if ($fileArray['minH']) { $options['minH'] = $fileArray['minH']; }

				$data = $movieCreator->getImageScale($info, $fileArray['width'], $fileArray['height'], $options);

				$info[0] = $data[0];
				$info[1] = $data[1];
			}

			if (!$info[3])
				$info[3] = $theFile;

			$info['origFile'] = $theFile;
			$info['origFile_mtime'] = @filemtime($theFile);

			return $info;
		}
	}

	/**
	 * Returns a <embed/object/svg/x3d/...> tag with the multimedia file defined by $file and processed according to the properties in the TypoScript array.
	 * Mostly this function is a sub-function to the MULTIMEDIA function which renders the MULTIMEDIA cObject in TypoScript. This function is called by "$this->cMultimedia($conf['file'],$conf);" from MULTIMEDIA().
	 *
	 * @param	string		File TypoScript resource
	 * @param	array		TypoScript configuration properties
	 * @return	string		<embed/object/svg/x3d/...> tag, (possibly wrapped in links and other HTML) if any multimedia found.
	 * @access private
	 * @see MULTIMEDIA()
	 */
	function cMultimediaFallback($file, $conf) {
		$info = $this->getMultimediaResource($file, $conf['file.']);
		$GLOBALS['TSFE']->lastMultimediaInfo = $info;

		if (is_array($info)) {
			// This array is used to collect the file-refs on the page...
			$GLOBALS['TSFE']->filesOnPage[] = $info[3];

			if (!strlen($conf['altText']) && !is_array($conf['altText.'])) {	// Backwards compatible:
				$conf['altText'] = $conf['alttext'];
				$conf['altText.'] = $conf['alttext.'];
			}

			$altParam = $this->getAltParam($conf);

			ereg('([^\.]*)$', $info[3], $reg); $reg = strtolower($reg[0]);
			$bed  = $conf['beds.' ][$reg];
			$hint = $conf['hints.'][$reg];

			$bed = str_replace("###CONTROLS###", $conf['controll.']['params.'][$reg], $bed);
			$bed = str_replace("###AUTOLOOP###", $conf['autoloop.']['params.'][$reg], $bed);
			$bed = str_replace("###AUTOPLAY###", $conf['autoplay.']['params.'][$reg], $bed);
			$bed = str_replace("###LOCATION###", htmlspecialchars($GLOBALS['TSFE']->absRefPrefix.t3lib_div::rawUrlEncodeFP($info[3])), $bed);

		//	$theValue =
		//		'<object ' .
		//			'src="' . htmlspecialchars($GLOBALS['TSFE']->absRefPrefix.t3lib_div::rawUrlEncodeFP($info[3])) . '" ' .
		//			'width="' . $info[0] . '" ' .
		//			'height="' . $info[1] . '"' .
		//			$this->getBorderAttr(' border="' . intval($conf['border']) . '"') .
		//			($conf['params'] ? ' ' . $conf['params'] : '') . ($altParam) .
		//		' />';
			$theValue = str_replace("###PARAMS###", $altParam, $bed);

			if ($conf['linkWrap'])
				$theValue = $this->linkWrap($theValue, $conf['linkWrap']);
			elseif ($conf['fileLinkWrap'])
			//	$theValue = $this->imageLinkWrap($theValue,$info['origFile'], $conf['fileLinkWrap.']);
				$theValue = $this->typolink($theValue, $conf['fileLinkWrap.']['typolink.']);

			return $this->wrap($theValue, $conf['wrap']);
		}
	}

	/**
	 * Rendering the cObject, MULTIMEDIAFALLBACK
	 *
	 * @param	array		Array of TypoScript properties
	 * @return	string		Output
	 */
	function MULTIMEDIAFALLBACK($conf) {
		$content='';
		if ($this->checkIf($conf['if.'])) {
			$theValue = $this->cMultimediaFallback($conf['file'],$conf);
			if ($conf['stdWrap.']) {
				$theValue = $this->stdWrap($theValue,$conf['stdWrap.']);
			}
			return $theValue;
		}
	}

	/**
	 * Rendering the cObject, MULTIMEDIAFALLBACK_RESOURCE
	 *
	 * @param	array		Array of TypoScript properties
	 * @return	string		Output
	 * @see getMultimediaResource()
	 */
	function MULTIMEDIAFALLBACK_RESOURCE($conf) {
		$fileArray = $this->getMultimediaResource($conf['file'],$conf['file.']);
		return $this->stdWrap($fileArray[3],$conf['stdWrap.']);
	}

	/**
	 * Returns a <img> tag with the multimedia file defined by $file and processed according to the properties in the TypoScript array.
	 * Mostly this function is a sub-function to the MULTIMEDIA function which renders the MULTIMEDIA cObject in TypoScript. This function is called by "$this->cMultimedia($conf['file'],$conf);" from MULTIMEDIA().
	 *
	 * @param	string		File TypoScript resource
	 * @param	array		TypoScript configuration properties
	 * @return	string		<img> tag, (possibly wrapped in links and other HTML) if any multimedia found.
	 * @access private
	 * @see MULTIMEDIA()
	 */
	function cMultimediaPreview($file, $conf) {
		$info = $this->getMMPreviewResource($file, $conf['file.']);
		$GLOBALS['TSFE']->lastImageInfo = $info;

		if (is_array($info)) {
			// This array is used to collect the file-refs on the page...
			$GLOBALS['TSFE']->filesOnPage[] = $info[3];

			if (!strlen($conf['altText']) && !is_array($conf['altText.'])) {	// Backwards compatible:
				$conf['altText'] = $conf['alttext'];
				$conf['altText.'] = $conf['alttext.'];
			}

			$altParam = $this->getAltParam($conf);

			$theValue =
				'<img ' .
					'src="' . htmlspecialchars($GLOBALS['TSFE']->absRefPrefix.t3lib_div::rawUrlEncodeFP($info[3])) . '" ' .
					'width="' . $info[0] . '" ' .
					'height="' . $info[1] . '"' .
					$this->getBorderAttr(' border="' . intval($conf['border']) . '"') .
					($conf['params'] ? ' ' . $conf['params'] : '') . ($altParam) .
				' />';

			if ($conf['linkWrap'])
				$theValue = $this->linkWrap($theValue, $conf['linkWrap']);
			elseif ($conf['fileLinkWrap'])
			//	$theValue = $this->imageLinkWrap($theValue,$info['origFile'], $conf['fileLinkWrap.']);
				$theValue = $this->typolink($theValue, $conf['fileLinkWrap.']['typolink.']);

			return $this->wrap($theValue, $conf['wrap']);
		}
	}

	/**
	 * Rendering the cObject, MULTIMEDIAPREVIEW
	 *
	 * @param	array		Array of TypoScript properties
	 * @return	string		Output
	 */
	function MULTIMEDIAPREVIEW($conf) {
		$content = '';
		if ($this->checkIf($conf['if.'])) {
			$theValue = $this->cMultimediaPreview($conf['file'], $conf);
			if ($conf['stdWrap.']) {
				$theValue = $this->stdWrap($theValue, $conf['stdWrap.']);
			}
			return $theValue;
		}
	}

	/**
	 * Rendering the cObject, MULTIMEDIAPREVIEW_RESOURCE
	 *
	 * @param	array		Array of TypoScript properties
	 * @return	string		Output
	 * @see getMultimediaResource()
	 */
	function MULTIMEDIAPREVIEW_RESOURCE($conf) {
		$fileArray = $this->getMMPreviewResource($conf['file'], $conf['file.']);
		return $this->stdWrap($fileArray[3], $conf['stdWrap.']);
	}
}

?>