CREATE DATABASE IF NOT EXISTS `bookshop` CHARACTER SET utf8;

USE bookshop;

CREATE TABLE IF NOT EXISTS `advertisementinfo` (
  `AdId` int(11) NOT NULL AUTO_INCREMENT COMMENT '广告ID',
  `AdBusiness` varchar(100) NOT NULL COMMENT '广告赞助商',
  `AdImage` varchar(100) NOT NULL COMMENT '广告图片',
  `AdUrl` varchar(100) NOT NULL COMMENT '广告Url链接',
  `AdPower` int(11) NOT NULL DEFAULT '0' COMMENT '广告权值',
  `AdDescription` varchar(100) NOT NULL COMMENT '广告说明',
  `AddPerson` int(11) NOT NULL COMMENT '添加人ID',
  PRIMARY KEY (`AdId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='广告信息表';


CREATE TABLE IF NOT EXISTS `bookchildclass` (
  `BCClassId` int(11) NOT NULL AUTO_INCREMENT COMMENT '二级分类ID',
  `BCClassName` varchar(50) NOT NULL COMMENT '二级分类名',
  `BCClassLabel` int(11) NOT NULL DEFAULT '0' COMMENT '常用标识位',
  `BCClassViewCount` int(11) NOT NULL DEFAULT '0' COMMENT '访问量',
  `BMClassId` int(11) NOT NULL COMMENT '所属一级分类ID',
  PRIMARY KEY (`BCClassId`),
  KEY `BMClassId` (`BMClassId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图书二级分类信息表';


CREATE TABLE IF NOT EXISTS `bookcomment` (
  `CommentId` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `BookId` int(11) NOT NULL COMMENT '图书ID',
  `MbId` int(11) NOT NULL COMMENT '评论人',
  `CommentTitle` varchar(50) DEFAULT NULL COMMENT '评论标题',
  `CommentContent` text NOT NULL COMMENT '评论内容',
  `CommentDate` datetime NOT NULL COMMENT '评论时间',
  `CommentValue` int(11) DEFAULT '0' COMMENT '评论有效值',
  PRIMARY KEY (`CommentId`),
  KEY `BookId` (`BookId`),
  KEY `MbId` (`MbId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图书评论信息表';


CREATE TABLE IF NOT EXISTS `bookinfo` (
  `BookId` int(11) NOT NULL AUTO_INCREMENT COMMENT '图书ID',
  `BMClassId` int(11) NOT NULL COMMENT '一级分类ID',
  `BCClassId` int(11) NOT NULL COMMENT '二级分类ID',
  `BookName` varchar(50) NOT NULL COMMENT '书名',
  `BookImage` varchar(100) NOT NULL DEFAULT 'image/BookImage/no.gif' COMMENT '图书封面图',
  `BookAuthor` varchar(50) NOT NULL COMMENT '作者/编著',
  `BookPress` varchar(100) NOT NULL COMMENT '出版社',
  `BookPublishDate` date NOT NULL COMMENT '出版日期',
  `BookPublishTimes` int(11) DEFAULT NULL COMMENT '出版次数',
  `BookISBN` varchar(50) DEFAULT NULL COMMENT 'ISBN',
  `BookPageCount` int(11) DEFAULT NULL COMMENT '页数',
  `BookPageSize` int(11) DEFAULT NULL COMMENT '开本',
  `BookPrice` int(11) DEFAULT '0' COMMENT '定价',
  `BookCatalog` text COMMENT '图书目录',
  `BookIntroduction` text COMMENT '图书简介',
  `BookGrade` int(11) DEFAULT '4' COMMENT '星级',
  `BookStorage` int(11) NOT NULL DEFAULT '0' COMMENT '库存量',
  `BookViewCount` int(11) NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `BookPayCount` int(11) NOT NULL DEFAULT '0' COMMENT '交易次数',
  `BookComment` int(11) NOT NULL DEFAULT '0' COMMENT '图书评论次数',
  `BookAddDate` date NOT NULL COMMENT '添加日期',
  `BookFlag` int(11) DEFAULT NULL COMMENT '新旧值',
  `BookRecommended` int(11) DEFAULT NULL COMMENT '书友推荐值',
  `BookDeleted` int(11) DEFAULT NULL COMMENT '删除标识位',
  PRIMARY KEY (`BookId`),
  KEY `BMClassId` (`BMClassId`),
  KEY `BCClassId` (`BCClassId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图书详细信息';


CREATE TABLE IF NOT EXISTS `bookmainclass` (
  `BMClassId` int(11) NOT NULL AUTO_INCREMENT COMMENT '一级分类ID',
  `BMClassName` varchar(50) NOT NULL COMMENT '一级分类名',
  `BMClassLabel` int(11) NOT NULL COMMENT '常用标识位',
  `BMClassViewCount` int(11) NOT NULL DEFAULT '0' COMMENT '访问量',
  PRIMARY KEY (`BMClassId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图书顶级分类信息表';


CREATE TABLE IF NOT EXISTS `favorites` (
  `FavoriteId` int(11) NOT NULL AUTO_INCREMENT COMMENT '收藏架ID',
  `MbId` int(11) NOT NULL COMMENT '收藏人ID',
  `BookId` int(11) NOT NULL COMMENT '图书ID',
  `FavoriteDate` date NOT NULL COMMENT '收藏日期',
  PRIMARY KEY (`FavoriteId`),
  KEY `MbId` (`MbId`),
  KEY `BookId` (`BookId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收藏架信息表';


CREATE TABLE IF NOT EXISTS `memberinfo` (
  `MbId` int(11) NOT NULL AUTO_INCREMENT COMMENT '会员ID',
  `MbName` varchar(50) NOT NULL COMMENT '会员昵称',
  `MbPassword` varchar(50) NOT NULL COMMENT '会员密码',
  `MbBirthday` date DEFAULT NULL COMMENT '会员出生年月',
  `MbGender` varchar(50) DEFAULT NULL COMMENT '会员性别',
  `MbEmail` varchar(100) DEFAULT NULL COMMENT '会员Email',
  `MbQuestion` varchar(100) DEFAULT NULL COMMENT '会员验证问题',
  `MbAnswer` varchar(100) DEFAULT NULL COMMENT '会员验证答案',
  `MbLevel` int(11) NOT NULL DEFAULT '0' COMMENT '会员等级',
  `MbImage` varchar(100) NOT NULL DEFAULT 'image/User/star_level1.gif' COMMENT '会员头衔标签',
  `MbPoints` int(11) DEFAULT '0' COMMENT '会员消费积分',
  `MbTrueName` varchar(50) DEFAULT NULL COMMENT '会员真实姓名',
  `MbCountry` varchar(50) DEFAULT NULL COMMENT '会员所在国家',
  `MbProvince` varchar(50) DEFAULT NULL COMMENT '会员所在省份',
  `MbCity` varchar(50) DEFAULT NULL COMMENT '会员所在城市',
  `MbPhone` varchar(50) DEFAULT NULL COMMENT '会员联系电话',
  `MbMobile` varchar(50) DEFAULT NULL COMMENT '会员手机号码',
  `MbPostalCode` varchar(50) DEFAULT NULL COMMENT '会员邮政编码',
  `MbAddress` varchar(100) DEFAULT NULL COMMENT '会员详细地址',
  `MbDate` date NOT NULL COMMENT '会员注册日期',
  `MbTime` int(11) DEFAULT '0' COMMENT '会员在线时间',
  `MbLastLogin` datetime DEFAULT '2012-01-01 00:00:00' COMMENT '会员最近登录时间',
  `MbDeleted` int(11) NOT NULL DEFAULT '0' COMMENT '会员删除标识位',
  PRIMARY KEY (`MbId`),
  UNIQUE KEY `MbName` (`MbName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员信息表';


CREATE TABLE IF NOT EXISTS `newsinfo` (
  `NewsID` int(11) NOT NULL AUTO_INCREMENT COMMENT '信息ID',
  `NewsTitle` varchar(100) NOT NULL COMMENT '新闻标题',
  `NewsDetails` varchar(100) NOT NULL COMMENT '新闻详细信息',
  `NewsAddDate` date NOT NULL COMMENT '新闻添加日期',
  `NewsAddPerson` int(11) NOT NULL COMMENT '新闻添加人',
  `NewsViewCount` int(11) NOT NULL DEFAULT '0' COMMENT '新闻访问量',
  `NewsDeleted` int(11) DEFAULT NULL COMMENT '删除标志位',
  PRIMARY KEY (`NewsID`),
  KEY `NewsAddPerson` (`NewsAddPerson`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='新闻信息表';


CREATE TABLE IF NOT EXISTS `orderinfo` (
  `OrderId` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `MbId` int(11) NOT NULL COMMENT '会员ID',
  `BookId` int(11) NOT NULL COMMENT '图书ID',
  `OrderCount` int(11) NOT NULL COMMENT '订购数量',
  `OrderAmount` int(11) NOT NULL COMMENT '订单总额',
  `OrderPayment` varchar(50) NOT NULL COMMENT '订单支付方式',
  `OrderDelivery` varchar(50) NOT NULL COMMENT '订单送货方式',
  `OrderDate` date NOT NULL COMMENT '订单订购时间',
  `OrderArrival` date DEFAULT NULL COMMENT '订单处理时间',
  `UserId` int(11) DEFAULT NULL COMMENT '发货人ID',
  `OrderStatus` int(11) DEFAULT '0' COMMENT '订单状态',
  PRIMARY KEY (`OrderId`),
  KEY `MbId` (`MbId`),
  KEY `BookId` (`BookId`),
  KEY `UserId` (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单信息表';


CREATE TABLE IF NOT EXISTS `userinfo` (
  `UserId` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `UserName` varchar(50) NOT NULL COMMENT '用户名',
  `UserPassword` varchar(50) NOT NULL COMMENT '用户密码',
  `UserRole` int(11) NOT NULL DEFAULT '0' COMMENT '用户角色',
  `UserDeleted` int(11) NOT NULL DEFAULT '0' COMMENT '删除标志位',
  PRIMARY KEY (`UserId`),
  UNIQUE KEY `UserName` (`UserName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员信息表';


CREATE TABLE IF NOT EXISTS `weblink` (
  `LinkId` int(11) NOT NULL AUTO_INCREMENT COMMENT '链接ID',
  `LinkName` varchar(100) NOT NULL COMMENT '链接名',
  `LinkUrl` varchar(100) NOT NULL COMMENT '连接URL',
  `LinkImage` varchar(100) DEFAULT NULL COMMENT '链接图片',
  `LinkLabel` int(11) NOT NULL DEFAULT '0' COMMENT '站内/站外标识',
  `AddPerson` int(11) NOT NULL COMMENT '添加人',
  PRIMARY KEY (`LinkId`),
  UNIQUE KEY `LinkName` (`LinkName`),
  KEY `AddPerson` (`AddPerson`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='友情链接信息表';