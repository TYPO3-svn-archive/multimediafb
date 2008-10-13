<?php
if (!defined("TYPO3_MODE")) 	die ("Access denied.");

/* ---------------------------------------------------------------------------------------------- */
if (!isset($GLOBALS['TYPO3_CONF_VARS']['GFX']['video_processing'])) {
	$GLOBALS['TYPO3_CONF_VARS']['GFX']['video_processing'] = 1;
	$GLOBALS['TYPO3_CONF_VARS']['GFX']['ffmpeg'] = 1;
	$GLOBALS['TYPO3_CONF_VARS']['GFX']['videofile_ext'] = 'avi,mng,m1v,m2v,m4v,mp1,mp2,mp4,mpg,mpeg,mov,qt,rm,wmv';
	$GLOBALS['TYPO3_CONF_VARS']['GFX']['ffmpeg_path'] = '';
}

if (!isset($GLOBALS['TYPO3_CONF_VARS']['GFX']['document_processing'])) {
	$GLOBALS['TYPO3_CONF_VARS']['GFX']['document_processing'] = 1;
	$GLOBALS['TYPO3_CONF_VARS']['GFX']['svg'] = 1;
	$GLOBALS['TYPO3_CONF_VARS']['GFX']['gs'] = 1;
	$GLOBALS['TYPO3_CONF_VARS']['GFX']['documentfile_ext'] = 'pdf,ps,svg';
	$GLOBALS['TYPO3_CONF_VARS']['GFX']['svg_path'] = '';
	$GLOBALS['TYPO3_CONF_VARS']['GFX']['gs_path'] = '';
}

/* ---------------------------------------------------------------------------------------------- */
$GLOBALS['T3_VAR']['ext'][$_EXTKEY]['setup'] = unserialize($_EXTCONF);

/* remap to dam-fields if available */
if (t3lib_extMgm::isLoaded('dam') /* && $GLOBALS['T3_VAR']['ext'][$_EXTKEY]['setup']['ctype_multimedia_add_ref'] */) {
	/* -------------------------------------------------------------------------------------- */
	t3lib_extMgm::addTypoScript($_EXTKEY,'setup','
		includeLibs.tx_damttcontent = EXT:dam/lib/class.tx_dam_tsfe.php

		temp.tx_dam.fileList < tt_content.multimediafb.20.fileList

		tt_content.multimediafb.20.fileList >
		tt_content.multimediafb.20.fileList.cObject = USER
		tt_content.multimediafb.20.fileList.cObject {
			userFunc = tx_dam_tsfe->fetchFileList

			refField = multimedia_dam
			refTable = tt_content

			additional.fileList < temp.tx_dam.fileList
			additional.filePath < tt_content.multimediafb.20.filePath' .
		/*	($GLOBALS['T3_VAR']['ext'][$_EXTKEY]['setup']['ctype_multimedia_add_orig_field']?'':'additional >') . */ '
		}
		tt_content.multimediafb.20.filePath >
		tt_content.multimediafb.20.filePath =

	',43);

	/* -------------------------------------------------------------------------------------- */
	t3lib_extMgm::addTypoScript($_EXTKEY,'setup','
		includeLibs.tx_damttcontent = EXT:dam/lib/class.tx_dam_tsfe.php

		temp.tx_dam.imgList < tt_content.multimediafb.20.imgList

		tt_content.multimediafb.20.imgList >
		tt_content.multimediafb.20.imgList.cObject = USER
		tt_content.multimediafb.20.imgList.cObject {
			userFunc = tx_dam_tsfe->fetchFileList

			refField = image_dam
			refTable = tt_content

			additional.imgList < temp.tx_dam.imgList
			additional.imgPath < tt_content.multimediafb.20.imgPath' .
		/*	($GLOBALS['T3_VAR']['ext'][$_EXTKEY]['setup']['ctype_image_add_orig_field']?'':'additional >') . */ '
		}
		tt_content.multimediafb.20.imgPath >
		tt_content.multimediafb.20.imgPath =

	',43);

	/* -------------------------------------------------------------------------------------- */
	t3lib_extMgm::addTypoScript($_EXTKEY,'setup','
		tt_content.multimediafb.20 {
			1 {

				// TODO
				longdescURL < .altText
				longdescURL.field = longdescURL

				altText >
				altText = TEXT
				altText.data = field : txdam_alt_text // field : altText
		#		altText.data = field : altText // field : txdam_alt_text

				titleText >
				titleText = TEXT
				titleText.data = field : txdam_title // field : titleText
		#		titleText.data = field : titleText // field : txdam_title
			}

			captionEach = {$styles.content.imgtext.captionEach}
			caption {
				1 = TEXT
				1 {
					field >
					data = field : txdam_caption // field : txdam_description // field : imagecaption
		#			data = field : imagecaption // field : txdam_caption // field : txdam_description
					required = 1
					parseFunc =< lib.parseFunc
					br = 1
					fontTag = <p class="csc-caption">|</p>
					wrapAlign.field = imagecaption_position
					split >
				}
			}

	',43);
}

//if ($_EXTCONF['removePositionTypes'] || !$_EXTCONF) {
	t3lib_extMgm::addPageTSConfig('
		TCEFORM.tt_content.imageorient.types.multimediafb.removeItems = 8,9,10,17,18,25,26
	');
//}

/* ---------------------------------------------------------------------------------------------- */
//if ($GLOBALS['T3_VAR']['ext'][$_EXTKEY]['setup']['add_css_styled_hook'])
//	$TYPO3_CONF_VARS['EXTCONF']['css_styled_content']['pi1_hooks']['render_multimediafb'] = 'EXT:dam_ttcontent/pi_cssstyledcontent/class.tx_damttcontent_pi1.php:&tx_damttcontent_pi1';

//if ($GLOBALS['T3_VAR']['ext'][$_EXTKEY]['setup']['add_page_mod_xclass'])
	$TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/cms/layout/class.tx_cms_layout.php'] = t3lib_extMgm::extPath('multimediafb') . 'class.ux_tx_cms_layout.php';

//require_once(t3lib_extMgm::extPath($_EXTKEY) . 'class.ux_tslib_content.php');
	$TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['tslib/class.tslib_content.php'] = t3lib_extMgm::extPath('multimediafb') . 'class.ux_tslib_content.php';

require_once(t3lib_extMgm::extPath($_EXTKEY) . 'class.tx_tv_rendering.php');
	$TYPO3_CONF_VARS['EXTCONF']['templavoila']['mod1']['renderPreviewContentClass'][] = 'tx_tv_rendering';

/* ---------------------------------------------------------------------------------------------- */
  ## Extending TypoScript from static template uid=43 to set up userdefined tag:
t3lib_extMgm::addTypoScript($_EXTKEY, "editorcfg","
	tt_content.CSS_editor.ch.tx_multimediafb_pi1 = < plugin.tx_multimediafb_pi1.CSS_editor
",43);

t3lib_extMgm::addPItoST43($_EXTKEY, "pi1/class.tx_multimediafb_pi1.php", "_pi1", "list_type", 1);
?>