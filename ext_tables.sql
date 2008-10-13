#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
	tx_multimediafb_tag tinyint(4) unsigned DEFAULT '0' NOT NULL,
	tx_multimediafb_failure tinyint(4) unsigned DEFAULT '0' NOT NULL,
	tx_multimediafb_controls tinyint(4) unsigned DEFAULT '0' NOT NULL,
	tx_multimediafb_autoplay tinyint(3) unsigned DEFAULT '1' NOT NULL,
	tx_multimediafb_autoloop tinyint(3) unsigned DEFAULT '1' NOT NULL,
	tx_multimediafb_playlist tinyint(3) unsigned DEFAULT '0' NOT NULL,
#	tx_multimediafb_filename blob NOT NULL,				# multimedia
#	tx_multimediafb_alternative_filename blob NOT NULL,			# image
	multimedia_dam int(11) unsigned DEFAULT '0' NOT NULL,
	image_dam int(11) unsigned DEFAULT '0' NOT NULL
#	tx_multimediafb_alternative_body blob NOT NULL,			# bodytext
#	tx_multimediafb_width mediumint(8) unsigned DEFAULT '0' NOT NULL,	# imagewidth
#	tx_multimediafb_height mediumint(8) unsigned DEFAULT '0' NOT NULL,	# imageheight
#	tx_multimediafb_orient tinyint(4) unsigned DEFAULT '0' NOT NULL,  	# imageorient
#	tx_multimediafb_link tinytext NOT NULL,				# image_link
#	tx_multimediafb_caption text NOT NULL,					# imagecaption
#	tx_multimediafb_caption_position varchar(6) DEFAULT '' NOT NULL,	# imagecaption_position
#	tx_multimediafb_altText text NOT NULL,					# altText
#	tx_multimediafb_titleText text NOT NULL,				# titleText
#	tx_multimediafb_longdescURL text NOT NULL				# longdescURL
);
