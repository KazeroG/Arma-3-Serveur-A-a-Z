-- ALWP installation script
-- dev by Kirk for Altisfrance
-- http://altisfrance.fr

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
`id` int(11) NOT NULL,
  `login` varchar(100) CHARACTER SET latin1 NOT NULL,
  `playerid` varchar(17) NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `status` tinyint(4) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `inscription` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `login`, `playerid`, `email`, `password`, `status`, `active`, `inscription`) VALUES
(1, 'admin', '76561198010235705', 'contact@altisfrance.fr', '21232f297a57a5a743894a0e4a801fc3', 2, 1, '2016-02-24 23:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `dc_donations`
--

CREATE TABLE IF NOT EXISTS `dc_donations` (
  `txn_id` varchar(64) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `payer_email` varchar(255) NOT NULL,
  `mc_gross` double NOT NULL,
  `mc_currency` varchar(10) NOT NULL,
  `dt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `impots`
--

CREATE TABLE IF NOT EXISTS `impots` (
`id` int(11) NOT NULL,
  `date` date NOT NULL,
  `income` int(255) NOT NULL,
  `total` int(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
`id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `picto` varchar(45) NOT NULL,
  `text` text NOT NULL,
  `datetime` datetime NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notification_by_admin`
--

CREATE TABLE IF NOT EXISTS `notification_by_admin` (
  `notification_id` int(45) NOT NULL,
  `admin_id` int(45) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table alter for table `players`
--

ALTER TABLE `players`
  ADD (`credit` int(3) NOT NULL DEFAULT '0',
       `sponsor` varchar(17) DEFAULT NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sanctions`
--

CREATE TABLE IF NOT EXISTS `sanctions` (
`id` int(11) NOT NULL,
  `playerid` varchar(17) NOT NULL,
  `author` varchar(17) NOT NULL,
  `date` datetime NOT NULL,
  `type` enum('0','1','2') NOT NULL,
  `sanction` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `ticket` int(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
`id` int(11) NOT NULL,
  `playerid` varchar(17) NOT NULL,
  `date` datetime NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `target` varchar(255) DEFAULT NULL,
  `witness` varchar(255) DEFAULT NULL,
  `files` text,
  `answer` text,
  `staff_id` int(45) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dc_donations`
--
ALTER TABLE `dc_donations`
 ADD PRIMARY KEY (`txn_id`);

--
-- Indexes for table `impots`
--
ALTER TABLE `impots`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_by_admin`
--
ALTER TABLE `notification_by_admin`
 ADD PRIMARY KEY (`notification_id`,`admin_id`);

--
-- Indexes for table `sanctions`
--
ALTER TABLE `sanctions`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
 ADD PRIMARY KEY (`id`);


--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `impots`
--
ALTER TABLE `impots`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `notification`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `sanctions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `vehicles`
--
