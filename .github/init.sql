CREATE TABLE `task` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `user_id` bigint unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
    `sort` int unsigned NOT NULL DEFAULT '0' COMMENT '排序值',
    `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '任务标题',
    `summary` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
    `is_deleted` tinyint NOT NULL DEFAULT '0' COMMENT '0未删除 1已删除',
    `created_at` datetime NOT NULL DEFAULT '2023-01-01 00:00:00',
    `updated_at` datetime NOT NULL DEFAULT '2023-01-01 00:00:00',
    PRIMARY KEY (`id`),
    KEY `INDEX_USER_ID` (`user_id`,`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `task` (`id`, `user_id`, `name`, `summary`, `is_deleted`, `created_at`, `updated_at`)
VALUES
	(1,1,'单测','专门用于单元测试',0,'2023-06-25 13:24:16','2023-06-25 13:24:48');

CREATE TABLE `task_item` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL DEFAULT '0' COMMENT '用户ID',
  `task_id` bigint NOT NULL DEFAULT '0' COMMENT '任务ID',
  `date` date NOT NULL COMMENT '日期',
  `value` decimal(20,4) NOT NULL DEFAULT '0.0000' COMMENT '数值',
  `comment` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `created_at` datetime NOT NULL DEFAULT '2023-01-01 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '2023-01-01 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_VALUE` (`task_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'OpenID',
  `created_at` datetime NOT NULL DEFAULT '2023-01-01 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '2023-01-01 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_OPENID` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user` (`id`, `openid`, `created_at`, `updated_at`)
VALUES
	(1,'ohjUY0TB_onjcaH2ia06HgGOC4CY','2023-06-25 12:37:08','2023-06-25 12:37:08');

CREATE TABLE `ys_player` (
 `id` bigint unsigned NOT NULL AUTO_INCREMENT,
 `user_id` bigint unsigned NOT NULL DEFAULT '0' COMMENT '用户 ID',
 `uid` bigint unsigned NOT NULL DEFAULT '0' COMMENT '原神 UID',
 `comment` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
 `is_deleted` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
 `created_at` datetime NOT NULL DEFAULT '2023-01-01 00:00:00',
 `updated_at` datetime NOT NULL DEFAULT '2023-01-01 00:00:00',
 PRIMARY KEY (`id`),
 UNIQUE KEY `UNIQUE_UID` (`user_id`,`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `ys_roler` (
`id` bigint unsigned NOT NULL AUTO_INCREMENT,
`user_id` bigint NOT NULL DEFAULT '0' COMMENT '用户 ID',
`uid` bigint NOT NULL DEFAULT '0' COMMENT '原神 UID',
`role` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '角色名',
`role_img` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '角色头像',
`level` int unsigned NOT NULL DEFAULT '0' COMMENT '角色等级',
`role_data` json DEFAULT NULL COMMENT '原始数据',
`created_at` datetime NOT NULL DEFAULT '2023-01-01 00:00:00',
`updated_at` datetime NOT NULL DEFAULT '2023-01-01 00:00:00',
PRIMARY KEY (`id`),
UNIQUE KEY `UNIQUE_UID` (`user_id`,`uid`,`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
