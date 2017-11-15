--
-- DB Dump for Maian Survey
--

--
-- Table structure for table `msv_answers`
--

CREATE TABLE `msv_answers` (
  `ans_id` int(10) unsigned NOT NULL auto_increment,
  `ans_sur_id` int(11) NOT NULL default '1',
  `ans_que_id` int(11) NOT NULL default '0',
  `ans_var_id` int(11) NOT NULL default '0',
  `ans_text` longtext default null,
  `ans_session_id` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`ans_id`),
  KEY `ansid` (`ans_sur_id`),
  KEY `ansqid` (`ans_que_id`),
  KEY `ansvid` (`ans_var_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `msv_colorschemes`
--

CREATE TABLE `msv_colorschemes` (
  `csc_id` int(11) NOT NULL auto_increment,
  `csc_title` varchar(255) not null default '',
  `csc_width` int(11) not null default '0',
  `title_background` varchar(255) not null default '',
  `title_color` varchar(255) not null default '',
  `title_font` varchar(255) not null default '',
  `title_size` tinyint(4) not null default '0',
  `question_background` varchar(255) not null default '',
  `question_color` varchar(255) not null default '',
  `question_font` varchar(255) not null default '',
  `question_size` tinyint(4) not null default '0',
  `answer_background` varchar(255) not null default '',
  `answer_color` varchar(255) not null default '',
  `answer_font` varchar(255) not null default '',
  `answer_size` tinyint(4) not null default '0',
  PRIMARY KEY  (`csc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `msv_colorschemes`
--

INSERT INTO `msv_colorschemes` (`csc_id`, `csc_title`, `csc_width`, `title_background`, `title_color`, `title_font`, `title_size`, `question_background`, `question_color`, `question_font`, `question_size`, `answer_background`, `answer_color`, `answer_font`, `answer_size`) VALUES(1, 'Beautiful Days', 875, 'CCD8E0', '5A5A43', 'Verdana', 12, 'ABBECA', '5A5A43', 'Verdana', 12, 'CCD8E0', '5A5A43', 'Verdana', 12);
INSERT INTO `msv_colorschemes` (`csc_id`, `csc_title`, `csc_width`, `title_background`, `title_color`, `title_font`, `title_size`, `question_background`, `question_color`, `question_font`, `question_size`, `answer_background`, `answer_color`, `answer_font`, `answer_size`) VALUES(2, 'Colourimetry', 875, '423f3a', 'ffffff', 'Verdana', 16, 'd4d4d4', '423f3a', 'Verdana', 12, '666159', 'd4d4d4', 'Verdana', 12);
INSERT INTO `msv_colorschemes` (`csc_id`, `csc_title`, `csc_width`, `title_background`, `title_color`, `title_font`, `title_size`, `question_background`, `question_color`, `question_font`, `question_size`, `answer_background`, `answer_color`, `answer_font`, `answer_size`) VALUES(3, 'Techno', 875, '0ac8d8', 'ffffff', 'Arial', 12, 'f9f8fd', '333333', 'Arial', 12, 'f6feff', 'b10961', 'Arial', 12);
INSERT INTO `msv_colorschemes` (`csc_id`, `csc_title`, `csc_width`, `title_background`, `title_color`, `title_font`, `title_size`, `question_background`, `question_color`, `question_font`, `question_size`, `answer_background`, `answer_color`, `answer_font`, `answer_size`) VALUES(4, 'Dirtylicious', 875, '2a323d', 'ffffff', 'Arial', 12, '949490', 'f0f0eb', 'Arial', 12, 'fafafa', '555533', 'Arial', 12);
INSERT INTO `msv_colorschemes` (`csc_id`, `csc_title`, `csc_width`, `title_background`, `title_color`, `title_font`, `title_size`, `question_background`, `question_color`, `question_font`, `question_size`, `answer_background`, `answer_color`, `answer_font`, `answer_size`) VALUES(5, 'Cartier', 875, '000000', '778e5a', 'Verdana', 12, '414141', '8aaf55', 'Verdana', 12, '545454', 'd5d2d6', 'Verdana', 12);
INSERT INTO `msv_colorschemes` (`csc_id`, `csc_title`, `csc_width`, `title_background`, `title_color`, `title_font`, `title_size`, `question_background`, `question_color`, `question_font`, `question_size`, `answer_background`, `answer_color`, `answer_font`, `answer_size`) VALUES(6, 'Magento', 875, '02657a', 'fff3bf', 'Verdana', 12, 'ee5e52', 'ffffff', 'Verdana', 12, 'f2f2f2', '002d53', 'Verdana', 12);
INSERT INTO `msv_colorschemes` (`csc_id`, `csc_title`, `csc_width`, `title_background`, `title_color`, `title_font`, `title_size`, `question_background`, `question_color`, `question_font`, `question_size`, `answer_background`, `answer_color`, `answer_font`, `answer_size`) VALUES(7, 'Voyager', 875, '484677', 'ffffff', 'Arial', 12, '364d5d', 'd5d28f', 'Arial', 12, '547c9d', 'ffffff', 'Arial', 12);

-- --------------------------------------------------------

--
-- Table structure for table `msv_config`
--

CREATE TABLE `msv_config` (
  `cfg_id` tinyint(1) NOT NULL default '1',
  `cfg_login` varchar(64) NOT NULL default '',
  `cfg_password` text default null,
  `cfg_wname` text default null,
  `cfg_wemail` varchar(255) NOT NULL default '',
  `cfg_wurl` text default null,
  `cfg_afflink` text default null,
  `smtp` enum('0','1') NOT NULL default '0',
  `smtp_host` varchar(100) NOT NULL default 'localhost',
  `smtp_user` varchar(100) NOT NULL default '',
  `smtp_pass` varchar(100) NOT NULL default '',
  `smtp_port` varchar(100) NOT NULL default '25',
  PRIMARY KEY  (`cfg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `msv_config`
--

INSERT INTO `msv_config` (`cfg_id`, `cfg_login`, `cfg_password`, `cfg_wname`, `cfg_wemail`, `cfg_wurl`, `cfg_afflink`, `smtp`, `smtp_host`, `smtp_user`, `smtp_pass`, `smtp_port`) VALUES(1, 'admin', '', 'My Survey System', 'you@example.com', '', '', '0', 'localhost', '', '', '25');

-- --------------------------------------------------------

--
-- Table structure for table `msv_keywords`
--

CREATE TABLE `msv_keywords` (
  `key_id` int(10) unsigned NOT NULL auto_increment,
  `key_sur_id` int(11) NOT NULL default '0',
  `key_que_id` int(11) NOT NULL default '0',
  `key_word` varchar(255) NOT NULL default '',
  `key_date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`key_id`),
  KEY `kid` (`key_sur_id`),
  KEY `kqid` (`key_que_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `msv_questions`
--

CREATE TABLE `msv_questions` (
  `que_id` int(11) NOT NULL auto_increment,
  `que_sur_id` int(11) NOT NULL default '0',
  `que_text` text default null,
  `que_help_text` mediumtext default null,
  `que_answer_type` tinyint(4) not null default '0',
  `que_required` tinyint(1) not null default '0',
  `orderBy` int(6) NOT NULL default '0',
  PRIMARY KEY  (`que_id`),
  KEY `qid` (`que_sur_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `msv_surveys`
--

CREATE TABLE `msv_surveys` (
  `sur_id` int(11) NOT NULL auto_increment,
  `sur_title` varchar(255) not null default '',
  `sur_display_type` enum('0','1') NOT NULL default '0',
  `sur_title_should_display` tinyint(1) not null default '1',
  `sur_captcha` enum('0','1') NOT NULL default '0',
  `sur_submit_text` varchar(50) not null default '',
  `sur_email_request` tinyint(1) not null default '0',
  `sur_email_request_message` text default null,
  `sur_view_summary` tinyint(1) not null default '1',
  `sur_date_expire` date NOT NULL default '0000-00-00',
  `sur_complete_goto_url` tinyint(4) NOT NULL default '0',
  `sur_complete_url` varchar(255) not null default '',
  `sur_complete_message` text default null,
  `sur_allow_multiple_votes` tinyint(1) not null default '0',
  `sur_notification_email` varchar(255) not null default '',
  `sur_status` tinyint(4) not null default '0',
  `sur_dare_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `sur_color_scheme` tinyint(4) not null default '0',
  `uniCode` char(7) NOT NULL default '',
  `en_keys` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`sur_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `msv_users`
--

CREATE TABLE `msv_users` (
  `usr_id` int(11) NOT NULL auto_increment,
  `usr_sur_id` int(11) NOT NULL default '0',
  `usr_email` varchar(255) NOT NULL default '',
  `usr_name` varchar(255) NOT NULL default '',
  `usr_date` date NOT NULL default '0000-00-00',
  `usr_IP` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`usr_id`),
  KEY `uid` (`usr_sur_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `msv_variants`
--

CREATE TABLE `msv_variants` (
  `var_id` int(11) NOT NULL auto_increment,
  `var_opt_id` int(11) NOT NULL default '0',
  `var_que_id` int(11) NOT NULL default '0',
  `var_text` varchar(255) not null default '',
  PRIMARY KEY  (`var_id`),
  KEY `void` (`var_opt_id`),
  KEY `vqid` (`var_que_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
