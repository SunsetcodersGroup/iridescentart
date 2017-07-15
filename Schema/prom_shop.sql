/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 100121
Source Host           : localhost:3306
Source Database       : prom_shop

Target Server Type    : MYSQL
Target Server Version : 100121
File Encoding         : 65001

Date: 2017-07-15 14:47:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for prom_shop_category
-- ----------------------------
DROP TABLE IF EXISTS `prom_shop_category`;
CREATE TABLE `prom_shop_category` (
  `cntCategoryID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lngParentCategoryID` int(10) unsigned DEFAULT NULL,
  `txtCategory` varchar(255) NOT NULL,
  `blnActive` bit(1) NOT NULL DEFAULT b'1',
  `lngDisplayOrder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `txtDescription` varchar(512) DEFAULT NULL,
  `binImage` blob,
  `txtImageMIMEType` varchar(255) DEFAULT NULL,
  `lngSize` int(10) unsigned DEFAULT NULL,
  `txtOriginalFilename` varchar(255) DEFAULT NULL,
  `datCreated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `datModified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cntCategoryID`),
  UNIQUE KEY `txtCategory` (`txtCategory`),
  KEY `blnActive` (`blnActive`,`lngDisplayOrder`),
  KEY `lngParentCategoryID` (`lngParentCategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for prom_shop_product
-- ----------------------------
DROP TABLE IF EXISTS `prom_shop_product`;
CREATE TABLE `prom_shop_product` (
  `cntProductID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lngCategoryID` int(10) unsigned NOT NULL,
  `txtProductTitle` varchar(255) NOT NULL,
  `txtProductSynopsis` varchar(255) DEFAULT NULL,
  `blnActive` bit(1) DEFAULT b'1',
  `datAdded` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `datModified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `txtLongDescription` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`cntProductID`),
  KEY `txtProductTitle` (`txtProductTitle`),
  KEY `lngCategoryID` (`lngCategoryID`,`blnActive`),
  CONSTRAINT `prom_shop_product_ibfk_1` FOREIGN KEY (`lngCategoryID`) REFERENCES `prom_shop_category` (`cntCategoryID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for prom_shop_product_image
-- ----------------------------
DROP TABLE IF EXISTS `prom_shop_product_image`;
CREATE TABLE `prom_shop_product_image` (
  `cntProductImageID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lngProductID` int(10) unsigned NOT NULL,
  `lngOrder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `blnActive` bit(1) DEFAULT b'1',
  `datCreated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `datModified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `txtDescription` varchar(255) DEFAULT NULL,
  `binImage` blob NOT NULL,
  `lngSize` int(10) unsigned NOT NULL,
  `txtImageMIMEType` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cntProductImageID`),
  KEY `lngProductID` (`lngProductID`,`lngOrder`,`blnActive`),
  CONSTRAINT `prom_shop_product_image_ibfk_1` FOREIGN KEY (`lngProductID`) REFERENCES `prom_shop_product` (`cntProductID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for prom_shop_product_price
-- ----------------------------
DROP TABLE IF EXISTS `prom_shop_product_price`;
CREATE TABLE `prom_shop_product_price` (
  `cntProductPriceID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lngProductID` int(10) unsigned NOT NULL,
  `decSalePrice` decimal(10,2) unsigned NOT NULL,
  `datEffectiveDate` date NOT NULL,
  `datCreated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `datModified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cntProductPriceID`),
  KEY `lngProductID` (`lngProductID`,`decSalePrice`,`datEffectiveDate`),
  CONSTRAINT `prom_shop_product_price_ibfk_1` FOREIGN KEY (`lngProductID`) REFERENCES `prom_shop_product` (`cntProductID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET FOREIGN_KEY_CHECKS=1;
