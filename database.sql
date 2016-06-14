CREATE DATABASE IF NOT EXISTS `bookshop` CHARACTER SET utf8;

USE bookshop;

CREATE TABLE IF NOT EXISTS `advertisementinfo` (
  `adid` int(11) NOT NULL AUTO_INCREMENT COMMENT '广告ID',
  `adbusiness` varchar(100) NOT NULL COMMENT '广告赞助商',
  `adimage` varchar(100) NOT NULL COMMENT '广告图片',
  `adurl` varchar(100) NOT NULL COMMENT '广告Url链接',
  `adpower` int(11) NOT NULL DEFAULT '0' COMMENT '广告权值',
  `addescription` varchar(100) NOT NULL COMMENT '广告说明',
  `addperson` int(11) NOT NULL COMMENT '添加人ID',
  PRIMARY KEY (`adid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='广告信息表';


CREATE TABLE IF NOT EXISTS `bookchildclass` (
  `bcclassid` int(11) NOT NULL AUTO_INCREMENT COMMENT '二级分类ID',
  `bcclassname` varchar(50) NOT NULL COMMENT '二级分类名',
  `bcclasslabel` int(11) NOT NULL DEFAULT '0' COMMENT '常用标识位',
  `bcclassviewcount` int(11) NOT NULL DEFAULT '0' COMMENT '访问量',
  `bmclassid` int(11) NOT NULL COMMENT '所属一级分类ID',
  PRIMARY KEY (`bcclassid`),
  KEY `bmclassid` (`bmclassid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图书二级分类信息表';


CREATE TABLE IF NOT EXISTS `bookcomment` (
  `commentid` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `bookid` int(11) NOT NULL COMMENT '图书ID',
  `mbid` int(11) NOT NULL COMMENT '评论人',
  `commenttitle` varchar(50) DEFAULT NULL COMMENT '评论标题',
  `commentcontent` text NOT NULL COMMENT '评论内容',
  `commentdate` datetime NOT NULL COMMENT '评论时间',
  `commentvalue` int(11) DEFAULT '0' COMMENT '评论有效值',
  PRIMARY KEY (`commentid`),
  KEY `bookid` (`bookid`),
  KEY `mbid` (`mbid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图书评论信息表';


CREATE TABLE IF NOT EXISTS `bookinfo` (
  `bookid` int(11) NOT NULL AUTO_INCREMENT COMMENT '图书ID',
  `bmclassid` int(11) NOT NULL COMMENT '一级分类ID',
  `bcclassid` int(11) NOT NULL COMMENT '二级分类ID',
  `bookname` varchar(50) NOT NULL COMMENT '书名',
  `bookimage` varchar(100) NOT NULL DEFAULT 'image/bookimage/no.gif' COMMENT '图书封面图',
  `bookauthor` varchar(50) NOT NULL COMMENT '作者/编著',
  `bookpress` varchar(100) NOT NULL COMMENT '出版社',
  `bookpublishdate` date NOT NULL COMMENT '出版日期',
  `bookpublishtimes` int(11) DEFAULT NULL COMMENT '出版次数',
  `bookisbn` varchar(50) DEFAULT NULL COMMENT 'ISBN',
  `bookpagecount` int(11) DEFAULT NULL COMMENT '页数',
  `bookpagesize` int(11) DEFAULT NULL COMMENT '开本',
  `bookprice` int(11) DEFAULT '0' COMMENT '定价',
  `bookcatalog` text COMMENT '图书目录',
  `bookintroduction` text COMMENT '图书简介',
  `bookgrade` int(11) DEFAULT '4' COMMENT '星级',
  `bookstorage` int(11) NOT NULL DEFAULT '0' COMMENT '库存量',
  `bookviewcount` int(11) NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `bookpaycount` int(11) NOT NULL DEFAULT '0' COMMENT '交易次数',
  `bookcomment` int(11) NOT NULL DEFAULT '0' COMMENT '图书评论次数',
  `bookadddate` date NOT NULL COMMENT '添加日期',
  `bookflag` int(11) DEFAULT NULL COMMENT '新旧值',
  `bookrecommended` int(11) DEFAULT NULL COMMENT '书友推荐值',
  `bookdeleted` int(11) DEFAULT NULL COMMENT '删除标识位',
  PRIMARY KEY (`bookid`),
  KEY `bmclassid` (`bmclassid`),
  KEY `bcclassid` (`bcclassid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图书详细信息';


CREATE TABLE IF NOT EXISTS `bookmainclass` (
  `bmclassid` int(11) NOT NULL AUTO_INCREMENT COMMENT '一级分类ID',
  `bmclassname` varchar(50) NOT NULL COMMENT '一级分类名',
  `bmclasslabel` int(11) NOT NULL COMMENT '常用标识位',
  `bmclassviewcount` int(11) NOT NULL DEFAULT '0' COMMENT '访问量',
  PRIMARY KEY (`bmclassid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图书顶级分类信息表';


CREATE TABLE IF NOT EXISTS `favorites` (
  `favoriteid` int(11) NOT NULL AUTO_INCREMENT COMMENT '收藏架ID',
  `mbid` int(11) NOT NULL COMMENT '收藏人ID',
  `bookid` int(11) NOT NULL COMMENT '图书ID',
  `favoritedate` date NOT NULL COMMENT '收藏日期',
  PRIMARY KEY (`favoriteid`),
  KEY `mbid` (`mbid`),
  KEY `bookid` (`bookid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收藏架信息表';


CREATE TABLE IF NOT EXISTS `memberinfo` (
  `mbid` int(11) NOT NULL AUTO_INCREMENT COMMENT '会员ID',
  `mbname` varchar(50) NOT NULL COMMENT '会员昵称',
  `mbpassword` varchar(50) NOT NULL COMMENT '会员密码',
  `mbbirthday` date DEFAULT NULL COMMENT '会员出生年月',
  `mbgender` varchar(50) DEFAULT NULL COMMENT '会员性别',
  `mbemail` varchar(100) DEFAULT NULL COMMENT '会员Email',
  `mbquestion` varchar(100) DEFAULT NULL COMMENT '会员验证问题',
  `mbanswer` varchar(100) DEFAULT NULL COMMENT '会员验证答案',
  `mblevel` int(11) NOT NULL DEFAULT '0' COMMENT '会员等级',
  `mbimage` varchar(100) NOT NULL DEFAULT 'image/user/star_level1.gif' COMMENT '会员头衔标签',
  `mbpoints` int(11) DEFAULT '0' COMMENT '会员消费积分',
  `mbtruename` varchar(50) DEFAULT NULL COMMENT '会员真实姓名',
  `mbcountry` varchar(50) DEFAULT NULL COMMENT '会员所在国家',
  `mbprovince` varchar(50) DEFAULT NULL COMMENT '会员所在省份',
  `mbcity` varchar(50) DEFAULT NULL COMMENT '会员所在城市',
  `mbphone` varchar(50) DEFAULT NULL COMMENT '会员联系电话',
  `mbmobile` varchar(50) DEFAULT NULL COMMENT '会员手机号码',
  `mbpostalcode` varchar(50) DEFAULT NULL COMMENT '会员邮政编码',
  `mbaddress` varchar(100) DEFAULT NULL COMMENT '会员详细地址',
  `mbdate` date NOT NULL COMMENT '会员注册日期',
  `mbtime` int(11) DEFAULT '0' COMMENT '会员在线时间',
  `mblastlogin` datetime DEFAULT '2012-01-01 00:00:00' COMMENT '会员最近登录时间',
  `mbdeleted` int(11) NOT NULL DEFAULT '0' COMMENT '会员删除标识位',
  PRIMARY KEY (`mbid`),
  UNIQUE KEY `mbname` (`mbname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员信息表';


CREATE TABLE IF NOT EXISTS `newsinfo` (
  `newsid` int(11) NOT NULL AUTO_INCREMENT COMMENT '信息ID',
  `newstitle` varchar(100) NOT NULL COMMENT '新闻标题',
  `newsdetails` varchar(100) NOT NULL COMMENT '新闻详细信息',
  `newsadddate` date NOT NULL COMMENT '新闻添加日期',
  `Newsaddperson` int(11) NOT NULL COMMENT '新闻添加人',
  `newsviewcount` int(11) NOT NULL DEFAULT '0' COMMENT '新闻访问量',
  `newsdeleted` int(11) DEFAULT NULL COMMENT '删除标志位',
  PRIMARY KEY (`newsid`),
  KEY `Newsaddperson` (`Newsaddperson`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='新闻信息表';


CREATE TABLE IF NOT EXISTS `orderinfo` (
  `orderid` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `mbid` int(11) NOT NULL COMMENT '会员ID',
  `bookid` int(11) NOT NULL COMMENT '图书ID',
  `ordercount` int(11) NOT NULL COMMENT '订购数量',
  `orderamount` int(11) NOT NULL COMMENT '订单总额',
  `orderpayment` varchar(50) NOT NULL COMMENT '订单支付方式',
  `orderdelivery` varchar(50) NOT NULL COMMENT '订单送货方式',
  `orderdate` date NOT NULL COMMENT '订单订购时间',
  `orderarrival` date DEFAULT NULL COMMENT '订单处理时间',
  `userid` int(11) DEFAULT NULL COMMENT '发货人ID',
  `orderstatus` int(11) DEFAULT '0' COMMENT '订单状态',
  PRIMARY KEY (`orderid`),
  KEY `mbid` (`mbid`),
  KEY `bookid` (`bookid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单信息表';


CREATE TABLE IF NOT EXISTS `userinfo` (
  `userid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `userpassword` varchar(50) NOT NULL COMMENT '用户密码',
  `userrole` int(11) NOT NULL DEFAULT '0' COMMENT '用户角色',
  `userdeleted` int(11) NOT NULL DEFAULT '0' COMMENT '删除标志位',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员信息表';


CREATE TABLE IF NOT EXISTS `weblink` (
  `linkid` int(11) NOT NULL AUTO_INCREMENT COMMENT '链接ID',
  `linkname` varchar(100) NOT NULL COMMENT '链接名',
  `linkurl` varchar(100) NOT NULL COMMENT '连接URL',
  `linkimage` varchar(100) DEFAULT NULL COMMENT '链接图片',
  `linklabel` int(11) NOT NULL DEFAULT '0' COMMENT '站内/站外标识',
  `addperson` int(11) NOT NULL COMMENT '添加人',
  PRIMARY KEY (`linkid`),
  UNIQUE KEY `linkname` (`linkname`),
  KEY `addperson` (`addperson`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='友情链接信息表';