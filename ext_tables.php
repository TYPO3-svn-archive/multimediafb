<?php
if (!defined ("TYPO3_MODE")) 	die ("Access denied.");

/* ---------------------------------------------------------------------------------------------- */
$tempColumns = Array (
	"tx_multimediafb_tag" => Array (
		"exclude" => 0,
		"label" => "LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_tag",
		"config" => Array (
			"type" => "select",
			"items" => Array (
				Array("LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_tag.I.0", "0"),
				Array("LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_tag.I.1", "1"),
				Array("LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_tag.I.2", "2"),
				Array("LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_tag.I.3", "3"),
			),
			"default" => "0",
		)
	),
	"tx_multimediafb_controls" => Array (
		"exclude" => 0,
		"label" => "LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_controls",
		"config" => Array (
			"type" => "radio",
			"items" => Array (
				Array("LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_controls.I.0", "0"),
				Array("LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_controls.I.1", "1"),
				Array("LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_controls.I.2", "2"),
			),
			"default" => "0",
		)
	),
	"tx_multimediafb_autoplay" => Array (
		"exclude" => 0,
		"label" => "LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_autoplay",
		"config" => Array (
			"type" => "check",
			"default" => "1",
		)
	),
	"tx_multimediafb_autoloop" => Array (
		"exclude" => 0,
		"label" => "LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_autoloop",
		"config" => Array (
			"type" => "check",
			"default" => "1",
		)
	),
	"tx_multimediafb_playlist" => Array (
		"exclude" => 0,
		"label" => "LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_playlist",
		"config" => Array (
			"type" => "check",
			"default" => "0",
		)
	),
	"tx_multimediafb_failure" => Array (
		"exclude" => 0,
		"label" => "LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_failure",
		"config" => Array (
			"type" => "select",
			"items" => Array (
				Array("LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_failure.I.0", "0"),	// alt plugin-note plugin (autodetect, inline javascript)
				Array("LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_failure.I.1", "1"),	// alt plugin-note other browser (autodetect, inline javascript)
				Array("LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_failure.I.2", "2"),	// alt image
				Array("LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_failure.I.3", "3"),	// alt text
			),
			"default" => "0",
		)
	),
////	"tx_multimediafb_filename" => Array (
//	"multimedia" => Array (
//		"exclude" => 0,
//		"label" => "LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_filename",
//		"config" => Array (
//			"type" => "group",
//			"internal_type" => "file",
//			"allowed" => "svg",
//			"max_size" => '1000',
//			"uploadfolder" => "uploads/tx_multimediafb",
//			"eval" => "required",
//			"show_thumbs" => '0',
//			"size" => 1,
//			"minitems" => 0,
//			"maxitems" => 1,
//		)
//	),
////	"tx_multimediafb_alternative_filename" => Array (
//	"image" => Array (
//		"exclude" => 0,
//		"label" => "LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_alternative_filename",
//		"config" => Array (
//			"type" => "group",
//			"internal_type" => "file",
//			"allowed" => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
//			"max_size" => '1000',
//			"uploadfolder" => "uploads/tx_multimediafb",
//			"show_thumbs" => '1',
//			"size" => 1,
//			"minitems" => 0,
//			"maxitems" => 1,
//		)
//	),
////	'tx_multimediafb_alternative_body' => Array (
//	'bodytext' => Array (
//		'exclude' => 1,
//		"label" => "LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_caption_alternative_body",
//		'config' => Array (
//			'type' => 'text',
//			'cols' => '30',
//			'rows' => '3'
//		)
//	),
////	"tx_multimediafb_width" => Array (
//	"imagewidth" => Array (
//		"exclude" => 0,
//		"label" => "LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_width",
//		"config" => Array (
//			"type" => "input",
//			"size" => "4",
//			"max" => "4",
//			"eval" => "int",		// we read the data out of the file ,required",
//			"checkbox" => "0",
//			"range" => Array (
//				"upper" => "1000",
//				"lower" => "10"
//			),
//			"default" => 0
//		)
//	),
////	"tx_multimediafb_height" => Array (
//	"imageheight" => Array (
//		"exclude" => 0,
//		"label" => "LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_height",
//		"config" => Array (
//			"type" => "input",
//			"size" => "4",
//			"max" => "4",
//			"eval" => "int",		// we read the data out of the file ,required",
//			"checkbox" => "0",
//			"range" => Array (
//				"upper" => "1000",
//				"lower" => "10"
//			),
//			"default" => 0
//		)
//	),
////	'tx_multimediafb_orient' => Array (
//	"imageorient" => Array (
//		"label" => "LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_orient",
//		'config' => Array (
//			'type' => 'select',
//			'items' => Array (
//				Array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.0', 0, 'selicons/above_center.gif'),
//				Array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.1', 1, 'selicons/above_right.gif'),
//				Array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.2', 2, 'selicons/above_left.gif'),
//				Array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.3', 8, 'selicons/below_center.gif'),
//				Array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.4', 9, 'selicons/below_right.gif'),
//				Array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.5', 10, 'selicons/below_left.gif'),
//				Array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.6', 17, 'selicons/intext_right.gif'),
//				Array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.7', 18, 'selicons/intext_left.gif'),
//				Array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.8', '--div--'),
//				Array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.9', 25, 'selicons/intext_right_nowrap.gif'),
//				Array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.10', 26, 'selicons/intext_left_nowrap.gif')
//			),
//			'selicon_cols' => 6,
//			'default' => '8',
//			'iconsInOptionTags' => 1,
//		)
//	),
////	'tx_multimediafb_link' => Array (
//	"image_link" => Array (
//		'exclude' => 1,
//		"label" => "LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_link",
//		'config' => Array (
//			'type' => 'input',
//			'size' => '15',
//			'max' => '256',
//			'checkbox' => '',
//			'eval' => 'trim',
//			'wizards' => Array(
//				'_PADDING' => 2,
//				'link' => Array(
//					'type' => 'popup',
//					'title' => 'Link',
//					'icon' => 'link_popup.gif',
//					'script' => 'browse_links.php?mode=wizard',
//					'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
//				)
//			),
//			'softref' => 'typolink[linkList]'
//		)
//	),
////	'tx_multimediafb_caption' => Array (
//	"imagecaption" => Array (
//		"label" => "LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_caption",
//		'config' => Array (
//			'type' => 'text',
//			'cols' => '30',
//			'rows' => '3',
//			'softref' => 'typolink_tag,images,email[subst],url'
//		)
//	),
////	'tx_multimediafb_caption_position' => Array (
//	"imagecaption_position" => Array (
//		'exclude' => 1,
//		"label" => "LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_caption_position",
//		'config' => Array (
//			'type' => 'select',
//			'items' => Array (
//				Array('', ''),
//				Array('LLL:EXT:cms/locallang_ttc.php:imagecaption_position.I.1', 'center'),
//				Array('LLL:EXT:cms/locallang_ttc.php:imagecaption_position.I.2', 'right'),
//				Array('LLL:EXT:cms/locallang_ttc.php:imagecaption_position.I.3', 'left')
//			),
//			'default' => ''
//		)
//	),
////	'tx_multimediafb_altText' => Array (
//	"altText" => Array (
//		'exclude' => 1,
//		"label" => "LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_altText",
//		'config' => Array (
//			'type' => 'text',
//			'cols' => '30',
//			'rows' => '3'
//		)
//	),
////	'tx_multimediafb_titleText' => Array (
//	"titleText" => Array (
//		'exclude' => 1,
//		"label" => "LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_titleText",
//		'config' => Array (
//			'type' => 'text',
//			'cols' => '30',
//			'rows' => '3'
//		)
//	),
////	'tx_multimediafb_longdescURL' => Array (
//	"longdescURL" => Array (
//		'exclude' => 1,
//		"label" => "LLL:EXT:multimediafb/locallang_db.php:tt_content.tx_multimediafb_longdescURL",
//		'config' => Array (
//			'type' => 'text',
//			'cols' => '30',
//			'rows' => '3'
//		)
//	),
);

/* ---------------------------------------------------------------------------------------------- */
$vector = "svg,pdf";
$threed = "x3d,x3dv,wrl,vrml";
$video  = "avi,mng,m1v,m2v,m4v,mp1,mp2,mp4,mpg,mpeg,mov,qt,rm,wmv";

$suffix = "";
if (t3lib_extMgm::isLoaded('dam') /* && $GLOBALS['T3_VAR']['ext'][$_EXTKEY]['setup']['ctype_multimedia_add_ref'] */) {
	$suffix = "_dam";

	/* -------------------------------------------------------------------------------------- */
	$tempColumns["multimedia" . $suffix] = txdam_getMediaTCA('media_field', "multimedia" . $suffix);

	/* limit to SVG in the moment */
//	$tempColumns["multimedia" . $suffix]["config"]['allowed'] = $vector . ',' . $threed . ',' . $video;
	$tempColumns["multimedia" . $suffix]["config"]['allowed_types'] = $vector . ',' . $threed . ',' . $video;
	$tempColumns["multimedia" . $suffix]["config"]['disallowed'] = "";
	$tempColumns["multimedia" . $suffix]["config"]['disallowed_types'] = "";
	$tempColumns["multimedia" . $suffix]["config"]['size'] = 1;
	$tempColumns["multimedia" . $suffix]["config"]['minitems'] = 0;
	$tempColumns["multimedia" . $suffix]["config"]['maxitems'] = 1;

	/* -------------------------------------------------------------------------------------- */
	$tempColumns["image"      . $suffix] = txdam_getMediaTCA('image_field', "image"      . $suffix);

	/* limit to SVG in the moment */
//	$tempColumns["image"      . $suffix]["config"]['disallowed'] = $vector . ',' . $threed . ',' . $video;
	$tempColumns["image"      . $suffix]["config"]['disallowed_types'] = $vector . ',' . $threed . ',' . $video;
	$tempColumns["image"      . $suffix]["config"]['size'] = 1;
	$tempColumns["image"      . $suffix]["config"]['minitems'] = 0;
	$tempColumns["image"      . $suffix]["config"]['maxitems'] = 1;
}

/* ---------------------------------------------------------------------------------------------- */
t3lib_div::loadTCA("tt_content");
t3lib_extMgm::addTCAcolumns("tt_content", $tempColumns, 1);

/* ---------------------------------------------------------------------------------------------- */
t3lib_div::loadTCA("tt_content");

$wi = array();
reset($TCA['tt_content']['columns']['CType']['config']['items']);
foreach ($TCA['tt_content']['columns']['CType']['config']['items'] as $array) {
	$wi[] = $array;

	if ($array[1] == 'textpic')
		$wi[] = array('LLL:EXT:multimediafb/locallang_db.php:tt_content.textmmfb', 'textmmfb', 'i/tt_content_textmmfb.gif');
	if ($array[1] == 'image')
		$wi[] = array('LLL:EXT:multimediafb/locallang_db.php:tt_content.multimediafb', 'multimediafb', 'i/tt_content_mmfb.gif');
}

$TCA['tt_content']['columns']['CType']['config']['items'] = $wi;
$TCA['tt_content']['ctrl']['typeicons']['multimediafb'] = 'tt_content_mmfb.gif';
$TCA['tt_content']['ctrl']['typeicons']['textmmfb'] = 'tt_content_textmmfb.gif';

$TCA['tt_content']['types']['multimediafb']['showitem'] =
	"CType;;4;button,hidden,1-1-1, header;;3;;2-2-2, linkToTop;;;;3-3-3," .
	"--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.media, " .
	"tx_multimediafb_tag, " .
	"--palette--;LLL:EXT:multimediafb/locallang_db.php:dividers2tabs.multimedia;16, " .
	"tx_multimediafb_failure, " .
/*	"tx_multimediafb_filename, "			*/	"multimedia" .  $suffix . ";;;;4-4-4, " .
/*	"tx_multimediafb_alternative_filename, " .	*/	"image"      .  $suffix . ";;;;4-4-4, " .
/*	"tx_multimediafb_alternative_body, " .		*/
/*	"tx_multimediafb_width, " .			*///	"imagewidth, " .
/*	"tx_multimediafb_height, " .                   *///	"imageheight, " .
/*	"tx_multimediafb_orient, " .                   */	"imageorient, " .
/*	"tx_multimediafb_link, " .                     */	"image_link, " .
/*	"tx_multimediafb_caption, " .                  */	"imagecaption"          . ";;5, " .
/*	"tx_multimediafb_caption_position, " .         *///	"imagecaption_position" .
/*	"tx_multimediafb_altText, " .                  */	"altText"               . ";;;;6-6-6, " .
/*	"tx_multimediafb_titleText, " .                */	"titleText, " .
/*	"tx_multimediafb_longdescURL" .                */	"longdescURL, " .
	"--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access,starttime, endtime" .
	"";
$TCA['tt_content']['types']['textmmfb']['showitem'] =
	"CType;;4;button,hidden,1-1-1, header;;3;;2-2-2, linkToTop;;;;3-3-3," .
	"--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.text, " .
	"bodytext;;9;richtext:rte_transform[flag=rte_enabled|mode=ts_css];3-3-3, " .
	"rte_enabled, " .
	"text_properties, " .
	"--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.media, " .
	"tx_multimediafb_tag, " .
	"--palette--;LLL:EXT:multimediafb/locallang_db.php:dividers2tabs.multimedia;16, " .
	"tx_multimediafb_failure, " .
/*	"tx_multimediafb_filename, "			*/	"multimedia" .  $suffix . ";;;;4-4-4, " .
/*	"tx_multimediafb_alternative_filename, " .	*/	"image"      .  $suffix . ";;;;4-4-4, " .
/*	"tx_multimediafb_alternative_body, " .		*/
/*	"tx_multimediafb_width, " .			*///	"imagewidth, " .
/*	"tx_multimediafb_height, " .                   *///	"imageheight, " .
/*	"tx_multimediafb_orient, " .                   */	"imageorient, " .
/*	"tx_multimediafb_link, " .                     */	"image_link, " .
/*	"tx_multimediafb_caption, " .                  */	"imagecaption"          . ";;5, " .
/*	"tx_multimediafb_caption_position, " .         *///	"imagecaption_position" .
/*	"tx_multimediafb_altText, " .                  */	"altText"               . ";;;;6-6-6, " .
/*	"tx_multimediafb_titleText, " .                */	"titleText, " .
/*	"tx_multimediafb_longdescURL" .                */	"longdescURL, " .
	"--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access,starttime, endtime" .
	"";
$TCA['tt_content']['palettes']['16'] = Array('showitem' => "" .
	"tx_multimediafb_controls, " .
	"tx_multimediafb_autoplay, " .
	"tx_multimediafb_autoloop, " .
	"tx_multimediafb_playlist, " .
/*	"tx_multimediafb_filename, "			*///	"multimedia" .  $suffix . ", " .
/*	"tx_multimediafb_alternative_filename, " .	*///	"image"      .  $suffix . ";;;;4-4-4, " .
/*	"tx_multimediafb_alternative_body, " .		*///	"bodytext"              . ";;;;3-3-3" .
/*	"tx_multimediafb_width, " .			*/	"imagewidth, " .
/*	"tx_multimediafb_height, " .                   */	"imageheight" .
	"");

/* ---------------------------------------------------------------------------------------------- */
t3lib_extMgm::addPlugin(Array("LLL:EXT:multimediafb/locallang_db.php:tt_content.multimediafb", "multimediafb"), "CType");
t3lib_extMgm::addPlugin(Array("LLL:EXT:multimediafb/locallang_db.php:tt_content.textmmfb", "textmmfb"), "CType");
t3lib_extMgm::addStaticFile($_EXTKEY, 'static/', 'CSS Styled Content (Multimedia w/fallback)');

/* ---------------------------------------------------------------------------------------------- */
if (TYPO3_MODE == "BE")	{
	// Setting the relative path to the extension in temp. variable:
	$extRelPath = t3lib_extMgm::extRelPath($_EXTKEY);
	$extPath    = t3lib_extMgm::extPath($_EXTKEY);

	// Alternative icons
	$TBE_STYLES['skinImgAutoCfg'] = array(
		'absDir' => $extPath . 'icons/',
		'relDir' => $extRelPath . 'icons/',
	);

	// Manual settings
	$TBE_STYLES['skinImg'] = array_merge($presetSkinImgs, array (
		'gfx/i/tt_content_mmfb.gif'   		=> array($extRelPath . 'icons/gfx/i/tt_content_mmfb.gif', 'width="18" height="16"'),
		'gfx/i/tt_content_mmfb__h.gif'   	=> array($extRelPath . 'icons/gfx/i/tt_content_mmfb__h.gif', 'width="18" height="16"'),
		'gfx/i/tt_content_mmfb__hu.gif'   	=> array($extRelPath . 'icons/gfx/i/tt_content_mmfb__hu.gif', 'width="18" height="16"'),
		'gfx/i/tt_content_mmfb__u.gif'   	=> array($extRelPath . 'icons/gfx/i/tt_content_mmfb__u.gif', 'width="18" height="16"'),
		'gfx/i/tt_content_mmfb__x.gif'   	=> array($extRelPath . 'icons/gfx/i/tt_content_mmfb__x.gif', 'width="18" height="16"'),
		'gfx/i/tt_content_textmmfb.gif'		=> array($extRelPath . 'icons/gfx/i/tt_content_textmmfb.gif', 'width="18" height="16"'),
		'gfx/i/tt_content_textmmfb__h.gif'	=> array($extRelPath . 'icons/gfx/i/tt_content_textmmfb__h.gif', 'width="18" height="16"'),
		'gfx/i/tt_content_textmmfb__hu.gif'	=> array($extRelPath . 'icons/gfx/i/tt_content_textmmfb__hu.gif', 'width="18" height="16"'),
		'gfx/i/tt_content_textmmfb__u.gif'	=> array($extRelPath . 'icons/gfx/i/tt_content_textmmfb__u.gif', 'width="18" height="16"'),
		'gfx/i/tt_content_textmmfb__x.gif'	=> array($extRelPath . 'icons/gfx/i/tt_content_textmmfb__x.gif', 'width="18" height="16"'),

		'gfx/c_wiz/text_mmfb_below.gif'		=> array($extRelPath . 'gfx/c_wiz/text_mmfb_below.gif', 'width="22" height="23"'),
		'gfx/c_wiz/text_mmfb_right.gif'		=> array($extRelPath . 'gfx/c_wiz/text_mmfb_right.gif', 'width="22" height="23"'),
		'gfx/c_wiz/multimediafb_only.gif'	=> array($extRelPath . 'gfx/c_wiz/multimediafb_only.gif', 'width="22" height="23"')
	));

	/* Wizard-icons */
	if (is_array($TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']))
		$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_multimediafb_pi1_wizicon'] = t3lib_extMgm::extPath('multimediafb') . 'pi1/class.tx_multimediafb_pi1_wizicon.php';
}
?>