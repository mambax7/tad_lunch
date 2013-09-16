CREATE TABLE `tad_lunch_config` (
  `id` tinyint(4) NOT NULL default '0',
  `title` varchar(255) default NULL,
  `master` varchar(60) default NULL,
  `master_j` enum('0','1','2','3') NOT NULL default '1',
  `secretary` varchar(60) default NULL,
  `secretary_j` enum('0','1','2','3') NOT NULL default '1',
  `date_b` date default NULL,
  `date_e` date default NULL,
  `checker_j` enum('0','1','2','3') NOT NULL default '1',
  `design_j` enum('0','1','2','3') NOT NULL default '1',
  `number_0` smallint(6) default NULL,
  `number_1` smallint(6) default NULL,
  `number_2` smallint(6) default NULL,
  `number_3` smallint(6) default NULL,
  `number_4` smallint(6) default NULL,
  `number_5` smallint(6) default NULL,
  `number_6` smallint(6) default NULL,
  PRIMARY KEY  (`id`)
)ENGINE=MyISAM;



CREATE TABLE `tad_lunch_main` (
  `id` int(10) unsigned zerofill NOT NULL auto_increment,
  `weeks` tinyint(4) default NULL,
  `staple_sn` smallint(4) default NULL,
  `staple` varchar(31) default NULL,
  `dish1_sn` smallint(4) default NULL,
  `dish1` varchar(31) default NULL,
  `dish2_sn` smallint(4) default NULL,
  `dish2` varchar(31) default NULL,
  `dish3_sn` smallint(4) default NULL,
  `dish3` varchar(31) default NULL,
  `dish4_sn` smallint(4) default NULL,
  `dish4` varchar(31) default NULL,
  `dish5_sn` smallint(4) default NULL,
  `dish5` varchar(31) default NULL,
  `soup_sn` smallint(4) default NULL,
  `soup` varchar(31) default NULL,
  `fruit_sn` smallint(4) default NULL,
  `fruit` varchar(31) default NULL,
  `rem_sn` smallint(4) default NULL,
  `rem` varchar(255) default NULL,
  `master` varchar(31) default NULL,
  `secretary` varchar(31) default NULL,
  `checker` varchar(31) default NULL,
  `design` varchar(31) default NULL,
  `dates` date NOT NULL default '0000-00-00',
  `week` enum('0','1','2','3','4','5','6') NOT NULL default '0',
  `numbers` smallint(5) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `dates` (`dates`)
)ENGINE=MyISAM;


CREATE TABLE `tad_lunch_dish` (
  `id` int(4) unsigned zerofill NOT NULL auto_increment,
  `kind` tinyint(2) NOT NULL default '50',
  `dish` varchar(31) NOT NULL default '',
  `item_name_1` varchar(31) default NULL,
  `item_number_1` float default NULL,
  `item_unit_1` varchar(15) default NULL,
  `item_name_2` varchar(31) default NULL,
  `item_number_2` float default NULL,
  `item_unit_2` varchar(15) default NULL,
  `item_name_3` varchar(31) default NULL,
  `item_number_3` float default NULL,
  `item_unit_3` varchar(15) default NULL,
  `item_name_4` varchar(31) default NULL,
  `item_number_4` float default NULL,
  `item_unit_4` varchar(15) default NULL,
  `item_name_5` varchar(31) default NULL,
  `item_number_5` float default NULL,
  `item_unit_5` varchar(15) default NULL,
  `item_name_6` varchar(31) default NULL,
  `item_number_6` float default NULL,
  `item_unit_6` varchar(15) default NULL,
  `item_name_7` varchar(31) default NULL,
  `item_number_7` float default NULL,
  `item_unit_7` varchar(15) default NULL,
  `item_name_8` varchar(31) default NULL,
  `item_number_8` float default NULL,
  `item_unit_8` varchar(15) default NULL,
  `item_name_9` varchar(31) default NULL,
  `item_number_9` float default NULL,
  `item_unit_9` varchar(15) default NULL,
  `item_name_10` varchar(31) default NULL,
  `item_number_10` float default NULL,
  `item_unit_10` varchar(15) default NULL,
  `change_date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`)
)ENGINE=MyISAM;


CREATE TABLE `tad_lunch_kind` (
  `id` tinyint(3) unsigned zerofill NOT NULL auto_increment,
  `sn` tinyint(3) unsigned zerofill NOT NULL default '000',
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `sn` (`sn`)
)ENGINE=MyISAM;


INSERT INTO `tad_lunch_kind` VALUES (001, 010, '主食');
INSERT INTO `tad_lunch_kind` VALUES (002, 020, '菜色');
INSERT INTO `tad_lunch_kind` VALUES (003, 021, '豬肉類');
INSERT INTO `tad_lunch_kind` VALUES (004, 022, '雞肉');
INSERT INTO `tad_lunch_kind` VALUES (005, 023, '魚類');
INSERT INTO `tad_lunch_kind` VALUES (006, 024, '蛋類');
INSERT INTO `tad_lunch_kind` VALUES (007, 025, '時令菜');
INSERT INTO `tad_lunch_kind` VALUES (008, 030, '湯');
INSERT INTO `tad_lunch_kind` VALUES (009, 040, '水果');
INSERT INTO `tad_lunch_kind` VALUES (010, 050, '備註');


INSERT INTO `tad_lunch_config` ( `id` , `title` , `master` , `master_j` , `secretary` , `secretary_j` , `date_b` , `date_e` , `checker_j` , `design_j` , `number_0` )
VALUES (
'0', '台南市**國民小學', '吳大偉', '1', '王小明', '1', '2005-09-01', '2006-01-30', '1', '1', '300'
);
