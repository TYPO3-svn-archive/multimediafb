<?php

########################################################################
# Extension Manager/Repository config file for ext: "multimediafb"
#
# Auto generated 21-05-2008 22:32
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Multimedia w/Fallback',
	'description' => 'Treats multimedia-files like normal images, with fallback option. [Supports TemplaVoila & DAM]',
	'category' => 'plugin',
	'shy' => 0,
	'dependencies' => 'cms',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => 'dam,templavoila,multimediafb,oxylab_stdwrap',
	'module' => '',
	'state' => 'alpha',
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => 'tt_content',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'author' => 'Niels Fröhling',
	'author_email' => 'niels@frohling.biz',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'version' => '0.3.0',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.0.0-0.0.0',
			'php' => '4.0.0-0.0.0',
			'cms' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:53:{s:9:"TMP1E.tmp";s:4:"d41d";s:25:"class.tx_tv_rendering.php";s:4:"372f";s:26:"class.ux_tslib_content.php";s:4:"da9a";s:26:"class.ux_tx_cms_layout.php";s:4:"2f5a";s:7:"ext.prj";s:4:"7d29";s:12:"ext_icon.gif";s:4:"738b";s:17:"ext_localconf.php";s:4:"aeb5";s:14:"ext_tables.php";s:4:"3cda";s:14:"ext_tables.sql";s:4:"a5cf";s:28:"ext_typoscript_editorcfg.txt";s:4:"a9b7";s:13:"locallang.php";s:4:"7347";s:13:"locallang.xml";s:4:"ef3b";s:16:"locallang_db.php";s:4:"2b08";s:16:"locallang_db.xml";s:4:"e66a";s:26:"gfx/c_wiz/multimediafb.gif";s:4:"faf0";s:31:"gfx/c_wiz/multimediafb_only.gif";s:4:"02b4";s:29:"gfx/c_wiz/text_mmfb_below.gif";s:4:"4f14";s:29:"gfx/c_wiz/text_mmfb_right.gif";s:4:"8369";s:25:"gfx/i/tt_content_mmfb.gif";s:4:"c1cf";s:28:"gfx/i/tt_content_mmfb__f.gif";s:4:"481f";s:28:"gfx/i/tt_content_mmfb__h.gif";s:4:"fff9";s:29:"gfx/i/tt_content_mmfb__ht.gif";s:4:"70a7";s:29:"gfx/i/tt_content_mmfb__hu.gif";s:4:"0e18";s:28:"gfx/i/tt_content_mmfb__t.gif";s:4:"11fd";s:28:"gfx/i/tt_content_mmfb__u.gif";s:4:"1d1b";s:28:"gfx/i/tt_content_mmfb__x.gif";s:4:"f00d";s:29:"gfx/i/tt_content_textmmfb.gif";s:4:"2204";s:32:"gfx/i/tt_content_textmmfb__f.gif";s:4:"5b26";s:32:"gfx/i/tt_content_textmmfb__h.gif";s:4:"b0f3";s:33:"gfx/i/tt_content_textmmfb__ht.gif";s:4:"3f32";s:33:"gfx/i/tt_content_textmmfb__hu.gif";s:4:"f684";s:32:"gfx/i/tt_content_textmmfb__t.gif";s:4:"06b0";s:32:"gfx/i/tt_content_textmmfb__u.gif";s:4:"b15a";s:32:"gfx/i/tt_content_textmmfb__x.gif";s:4:"6838";s:20:"res/auxil/plugin.png";s:4:"cf5c";s:18:"res/auxil/save.png";s:4:"4d5e";s:18:"res/player/end.png";s:4:"783a";s:18:"res/player/fwd.png";s:4:"17ab";s:19:"res/player/mute.png";s:4:"de69";s:20:"res/player/pause.png";s:4:"8177";s:19:"res/player/play.png";s:4:"38b9";s:18:"res/player/rew.png";s:4:"97cb";s:20:"res/player/start.png";s:4:"9dda";s:19:"res/player/stop.png";s:4:"248c";s:33:"pi1/class.tx_multimediafb_pi1.php";s:4:"818e";s:41:"pi1/class.tx_multimediafb_pi1_wizicon.php";s:4:"d85f";s:13:"pi1/clear.gif";s:4:"cc11";s:17:"pi1/locallang.php";s:4:"7b46";s:17:"pi1/locallang.xml";s:4:"2e95";s:20:"static/constants.txt";s:4:"1af6";s:16:"static/setup.txt";s:4:"0001";s:19:"doc/wizard_form.dat";s:4:"fcc5";s:20:"doc/wizard_form.html";s:4:"8581";}',
	'suggests' => array(
	),
);

?>