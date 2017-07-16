/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 100121
Source Host           : localhost:3306
Source Database       : prom_shop

Target Server Type    : MYSQL
Target Server Version : 100121
File Encoding         : 65001

Date: 2017-07-15 20:00:17
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
  KEY `lngParentCategoryID` (`lngParentCategoryID`),
  CONSTRAINT `prom_shop_category_ibfk_1` FOREIGN KEY (`cntCategoryID`) REFERENCES `prom_shop_product` (`lngCategoryID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for prom_shop_customer
-- ----------------------------
DROP TABLE IF EXISTS `prom_shop_customer`;
CREATE TABLE `prom_shop_customer` (
  `cntCustomerID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `enuTitle` enum('Mr','Mrs','Miss','Ms','Dr') DEFAULT NULL,
  `txtFirstname` varchar(255) NOT NULL,
  `txtLastname` varchar(255) NOT NULL,
  `datCreated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `datModified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `txtNotes` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`cntCustomerID`),
  CONSTRAINT `prom_shop_customer_ibfk_1` FOREIGN KEY (`cntCustomerID`) REFERENCES `prom_shop_customer_address` (`lngCustomerID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `prom_shop_customer_ibfk_2` FOREIGN KEY (`cntCustomerID`) REFERENCES `prom_shop_customer_phone` (`lngCustomerID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `prom_shop_customer_ibfk_3` FOREIGN KEY (`cntCustomerID`) REFERENCES `prom_shop_invoice` (`lngCustomerID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for prom_shop_customer_address
-- ----------------------------
DROP TABLE IF EXISTS `prom_shop_customer_address`;
CREATE TABLE `prom_shop_customer_address` (
  `cntCustomerAddressID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lngCustomerID` int(10) unsigned NOT NULL,
  `enuAddressType` enum('Home','Work','Billable') DEFAULT 'Home',
  `txtAddressLine1` varchar(255) DEFAULT NULL,
  `txtAddressLine2` varchar(255) DEFAULT NULL,
  `txtSuburb` varchar(255) DEFAULT NULL,
  `txtState` varchar(30) DEFAULT NULL,
  `txtPostcode` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`cntCustomerAddressID`),
  KEY `lngCustomerID` (`lngCustomerID`),
  CONSTRAINT `prom_shop_customer_address_ibfk_1` FOREIGN KEY (`lngCustomerID`) REFERENCES `prom_shop_customer` (`cntCustomerID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for prom_shop_customer_phone
-- ----------------------------
DROP TABLE IF EXISTS `prom_shop_customer_phone`;
CREATE TABLE `prom_shop_customer_phone` (
  `cntCustomerPhoneID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lngCustomerID` int(10) unsigned NOT NULL,
  `enuPhoneType` enum('Work','Home','Fax','Mobile') DEFAULT 'Home',
  `txtPhone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`cntCustomerPhoneID`),
  KEY `lngCustomerID` (`lngCustomerID`),
  CONSTRAINT `prom_shop_customer_phone_ibfk_1` FOREIGN KEY (`lngCustomerID`) REFERENCES `prom_shop_customer` (`cntCustomerID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for prom_shop_invoice
-- ----------------------------
DROP TABLE IF EXISTS `prom_shop_invoice`;
CREATE TABLE `prom_shop_invoice` (
  `cntInvoiceID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lngCustomerID` int(255) unsigned NOT NULL,
  `enuInvoiceStatus` enum('New','Processing','Cancelled','Shipped','Refunded') NOT NULL DEFAULT 'New',
  `txtAddress` varchar(255) DEFAULT NULL,
  `enuAddressType` enum('Home','Work','Billable') DEFAULT 'Home',
  `txtAddressLine1` varchar(255) DEFAULT NULL,
  `txtAddressLine2` varchar(255) DEFAULT NULL,
  `txtSuburb` varchar(255) DEFAULT NULL,
  `txtState` varchar(30) DEFAULT NULL,
  `txtPostcode` varchar(10) DEFAULT NULL,
  `datInvoice` date DEFAULT NULL,
  `datCreated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `datModified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `datShipped` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `txtTrackingID` varchar(255) DEFAULT NULL,
  `txtDeliveryInstructions` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`cntInvoiceID`),
  KEY `lngCustomerID` (`lngCustomerID`),
  KEY `enuInvoiceStatus` (`enuInvoiceStatus`),
  KEY `txtTrackingID` (`txtTrackingID`),
  CONSTRAINT `prom_shop_invoice_ibfk_1` FOREIGN KEY (`lngCustomerID`) REFERENCES `prom_shop_customer` (`cntCustomerID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for prom_shop_invoice_item
-- ----------------------------
DROP TABLE IF EXISTS `prom_shop_invoice_item`;
CREATE TABLE `prom_shop_invoice_item` (
  `cntInvoiceItemID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lngInvoiceID` int(10) unsigned NOT NULL,
  `lngProductID` int(10) unsigned NOT NULL,
  `decQuantity` decimal(10,2) NOT NULL,
  `decPrice` decimal(10,2) NOT NULL,
  `datCreated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `datModified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cntInvoiceItemID`),
  KEY `lngInvoiceID` (`lngInvoiceID`),
  KEY `lngProductID` (`lngProductID`),
  CONSTRAINT `prom_shop_invoice_item_ibfk_1` FOREIGN KEY (`lngInvoiceID`) REFERENCES `prom_shop_invoice` (`cntInvoiceID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `prom_shop_invoice_item_ibfk_2` FOREIGN KEY (`lngProductID`) REFERENCES `prom_shop_product` (`cntProductID`) ON DELETE NO ACTION ON UPDATE NO ACTION
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
  KEY `lngCategoryID_2` (`lngCategoryID`),
  CONSTRAINT `prom_shop_product_ibfk_1` FOREIGN KEY (`lngCategoryID`) REFERENCES `prom_shop_category` (`cntCategoryID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `prom_shop_product_ibfk_2` FOREIGN KEY (`cntProductID`) REFERENCES `prom_shop_invoice_item` (`lngProductID`) ON DELETE NO ACTION ON UPDATE NO ACTION
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
