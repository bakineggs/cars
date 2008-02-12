-- phpMyAdmin SQL Dump
-- version 2.11.1-rc1
-- http://www.phpmyadmin.net
--
-- Host: db.example.com
-- Generation Time: Feb 12, 2008 at 05:25 AM
-- Server version: 5.1.11
-- PHP Version: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `cars`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE IF NOT EXISTS `cars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` int(6) NOT NULL,
  `make` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `year` int(4) NOT NULL,
  `mileage` int(6) NOT NULL,
  `vin` varchar(17) NOT NULL,
  `uri` varchar(1024) NOT NULL,
  `dealer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
