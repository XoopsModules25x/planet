## phpMyAdmin SQL Dump
## version 2.6.3-pl1
## http://www.phpmyadmin.net
## 
## Host: localhost
## Generation Time: Nov 13, 2005 at 08:24 PM
## Server version: 4.1.13
## PHP Version: 5.1.0RC1
## 
## Database: `forge`
## 

## --------------------------------------------------------

## 
## Table structure for table `planet_article`
## 

CREATE TABLE `planet_article` (
  `art_id` 			int(10) 		unsigned NOT NULL auto_increment,
  `blog_id` 		mediumint(8) 	unsigned NOT NULL default '0',
  `art_author` 		varchar(255) 	NOT NULL default '',
  `art_title` 		varchar(255) 	NOT NULL default '',
  `art_link` 		varchar(255) 	NOT NULL default '',
  `art_content` 	text,
  `art_time` 		int(10) 		unsigned NOT NULL default '0',
  `art_views` 		int(10) 		unsigned NOT NULL default '0',
  `art_rating` 		int(10) 		unsigned NOT NULL default '0',
  `art_rates` 		int(10) 		unsigned NOT NULL default '0',
  `art_comments` 	int(10) 		unsigned NOT NULL default '0',
  PRIMARY KEY  		(`art_id`),
  KEY `blog_id` 	(`blog_id`),
  KEY `art_title` 	(`art_title`)
) ENGINE=MyISAM;

## --------------------------------------------------------

## 
## Table structure for table `planet_blog`
## 

CREATE TABLE `planet_blog` (
  `blog_id` 		mediumint(8) 	unsigned NOT NULL auto_increment,
  `blog_title` 		varchar(255) 	NOT NULL default '',
  `blog_desc` 		varchar(255) 	NOT NULL default '',
  `blog_feed` 		varchar(255) 	NOT NULL default '',
  `blog_language` 	varchar(32) 	NOT NULL default '',
  `blog_charset` 	varchar(32) 	NOT NULL default '',
  `blog_link` 		varchar(255) 	NOT NULL default '',
  `blog_image` 		varchar(255) 	NOT NULL default '',
  `blog_trackback` 	varchar(255) 	NOT NULL default '',
  `blog_submitter` 	varchar(255) 	NOT NULL default '',
  `blog_status` 	tinyint(1) 		unsigned NOT NULL default '1',
  `blog_key` 		varchar(32) 	NOT NULL default '',
  `blog_time` 		int(10) 		unsigned NOT NULL default '0',
  `blog_rating` 	int(10) 		unsigned NOT NULL default '0',
  `blog_rates` 		int(10) 		unsigned NOT NULL default '0',
  `blog_marks` 		int(10) 		unsigned NOT NULL default '0',
  PRIMARY KEY  		(`blog_id`),
  KEY `blog_title` 	(`blog_title`),
  KEY `blog_feed` 	(`blog_feed`)
) ENGINE=MyISAM;

## --------------------------------------------------------

## 
## Table structure for table `planet_blogcat`
## 

CREATE TABLE `planet_blogcat` (
  `bc_id` 			int(11) 		unsigned NOT NULL auto_increment,
  `blog_id` 		int(11) 		unsigned NOT NULL default '0',
  `cat_id` 			int(11) 		unsigned NOT NULL default '0',
  PRIMARY KEY  		(`bc_id`),
  KEY `art_id` 		(`blog_id`,`cat_id`)
) ENGINE=MyISAM;

## --------------------------------------------------------

## 
## Table structure for table `planet_bookmark`
## 

CREATE TABLE `planet_bookmark` (
  `bm_id` 			int(11) 		unsigned NOT NULL auto_increment,
  `blog_id` 		int(11) 		unsigned NOT NULL default '0',
  `bm_uid` 			int(11) 		unsigned NOT NULL default '0',
  PRIMARY KEY  		(`bm_id`),
  KEY `blog_id` 	(`blog_id`),
  KEY `bm_uid` 		(`bm_uid`)
) ENGINE=MyISAM;

## --------------------------------------------------------

## 
## Table structure for table `planet_category`
## 

CREATE TABLE `planet_category` (
  `cat_id` 			mediumint(4) 	unsigned NOT NULL auto_increment,
  `cat_title` 		varchar(255) 	NOT NULL default '',
  `cat_order` 		mediumint(4) 	unsigned NOT NULL default '1',
  PRIMARY KEY  		(`cat_id`),
  KEY `cat_title` 	(`cat_title`)
) ENGINE=MyISAM;

## --------------------------------------------------------

## 
## Table structure for table `planet_rate`
## 

CREATE TABLE `planet_rate` (
  `rate_id` 		int(11) 		unsigned NOT NULL auto_increment,
  `art_id` 			int(11) 		unsigned NOT NULL default '0',
  `blog_id` 		int(11) 		unsigned NOT NULL default '0',
  `rate_uid` 		int(11) 		unsigned NOT NULL default '0',
  `rate_ip` 		int(11) 		unsigned NOT NULL default '0',
  `rate_rating` 	tinyint(3) 		unsigned NOT NULL default '0',
  `rate_time` 		int(10) 		unsigned NOT NULL default '0',
  PRIMARY KEY  		(`rate_id`),
  KEY `art_id` 		(`art_id`),
  KEY `blog_id` 	(`blog_id`)
) ENGINE=MyISAM;