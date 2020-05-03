# Host: localhost  (Version 5.5.5-10.1.37-MariaDB)
# Date: 2020-05-03 09:52:56
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# Structure for table "courses"
#

DROP TABLE IF EXISTS `courses`;
CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(100) NOT NULL,
  `course_img` varchar(100) DEFAULT NULL,
  `course_duration` decimal(3,1) NOT NULL,
  `course_description` text,
  PRIMARY KEY (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

#
# Data for table "courses"
#

INSERT INTO `courses` VALUES (2,'Curso de Npm','/public/images/courses/npm.jpg',22.5,'Este curso é uma introdução ao JavaScript, onde aprenderemos conceitos básicos e as principais funções dessa linguagem. Para isso usaremos um formulário de pedidos para uma pizzaria, no qual será possível adicionar os sabores de pizza que desejamos comprar. Para isso teremos dois botões, um para adicionar e outro para remover as quantidades no pedido. Outra funcionalidade que veremos é o envio do formulário, pois este pedido precisa ser encaminhado para o servidor. Criaremos essa aplicação'),(8,'Curso Desenvolvido em PHP','/public/images/courses/maxresdefault.jpg',22.5,'Note that if you are using multiple plug-ins, it is beneficial in terms of performance to combine the plug-ins into a single file and host it on your own server, rather than making multiple requests to the DataTables CDN');

#
# Structure for table "team"
#

DROP TABLE IF EXISTS `team`;
CREATE TABLE `team` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_name` varchar(100) NOT NULL,
  `member_photo` varchar(100) DEFAULT NULL,
  `member_description` text,
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

#
# Data for table "team"
#

INSERT INTO `team` VALUES (1,'Caio','/public/images/team/407913_264557603597325_1398091007_n.jpg','Professor');

#
# Structure for table "users"
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_login` varchar(30) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `user_full_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

#
# Data for table "users"
#

INSERT INTO `users` VALUES (2,'admin','$2y$10$eMVsMeQgMSLxIdJ8BINiQ.A2H6yOrFTRI9Zoz7WW1NskOzc9.1JAK','admin','admin@admin.com.br'),(3,'diego','$2y$10$Rx84LhiwIOhiwMJneW4Hb.kI2pIeqKvED3ohIEttD2xvAGlmSPA9q','Diego Mariano','diego@uol.com.br');
