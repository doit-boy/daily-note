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
 `listen_time` int unsigned NOT NULL DEFAULT '0' COMMENT '上次监听时间',
 `created_at` datetime NOT NULL DEFAULT '2023-01-01 00:00:00',
 `updated_at` datetime NOT NULL DEFAULT '2023-01-01 00:00:00',
 PRIMARY KEY (`id`),
 UNIQUE KEY `UNIQUE_UID` (`user_id`,`uid`),
 KEY `INDEX_LISTEN_TIME` (`listen_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='原神账号';

CREATE TABLE `ys_roler` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `user_id` bigint NOT NULL DEFAULT '0' COMMENT '用户 ID',
    `uid` bigint NOT NULL DEFAULT '0' COMMENT '原神 UID',
    `role` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '角色名',
    `role_img` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '角色头像',
    `level` int unsigned NOT NULL DEFAULT '0' COMMENT '角色等级',
    `role_data` json DEFAULT NULL COMMENT '原始数据',
    `artifacts_sum_point` int unsigned NOT NULL DEFAULT '0' COMMENT '圣遗物分值',
    `hp` int unsigned NOT NULL DEFAULT '0' COMMENT '生命值',
    `attack` int unsigned NOT NULL DEFAULT '0' COMMENT '攻击力',
    `defend` int unsigned NOT NULL DEFAULT '0' COMMENT '防御力',
    `element` int unsigned NOT NULL DEFAULT '0' COMMENT '元素精通',
    `crit` decimal(6,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '暴击率',
    `crit_dmg` decimal(6,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '暴击伤害',
    `recharge` decimal(6,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '充能效率',
    `heal` decimal(6,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '属性伤害加成',
    `raw_data` json DEFAULT NULL COMMENT '四维基础数据',
    `is_listen` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '是否监听四维变化',
    `last_listen_time` int unsigned NOT NULL DEFAULT '0' COMMENT '上次监听时间',
    `created_at` datetime NOT NULL DEFAULT '2023-01-01 00:00:00',
    `updated_at` datetime NOT NULL DEFAULT '2023-01-01 00:00:00',
    PRIMARY KEY (`id`),
    UNIQUE KEY `UNIQUE_UID` (`user_id`,`uid`,`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='原神角色';

CREATE TABLE `ys_roler_history` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `roler_id` bigint NOT NULL DEFAULT '0' COMMENT '原神角色ID',
    `dt` date NOT NULL COMMENT '日期',
    `level` int unsigned NOT NULL DEFAULT '0' COMMENT '角色等级',
    `hp` int unsigned NOT NULL DEFAULT '0' COMMENT '生命值',
    `attack` int unsigned NOT NULL DEFAULT '0' COMMENT '攻击力',
    `defend` int unsigned NOT NULL DEFAULT '0' COMMENT '防御力',
    `element` int unsigned NOT NULL DEFAULT '0' COMMENT '元素精通',
    `crit` decimal(6,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '暴击率',
    `crit_dmg` decimal(6,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '暴击伤害',
    `recharge` decimal(6,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '充能效率',
    `heal` decimal(6,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '属性伤害加成',
    `created_at` datetime NOT NULL DEFAULT '2023-01-01 00:00:00',
    `updated_at` datetime NOT NULL DEFAULT '2023-01-01 00:00:00',
    PRIMARY KEY (`id`),
    KEY `INDEX_DT` (`roler_id`,`dt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='原神角色历史';

CREATE TABLE `ys_roler_target` (
   `id` bigint unsigned NOT NULL COMMENT '原神角色ID',
   `level` int unsigned NOT NULL DEFAULT '0' COMMENT '角色等级',
   `hp` int unsigned NOT NULL DEFAULT '0' COMMENT '生命值',
   `attack` int unsigned NOT NULL DEFAULT '0' COMMENT '攻击力',
   `defend` int unsigned NOT NULL DEFAULT '0' COMMENT '防御力',
   `element` int unsigned NOT NULL DEFAULT '0' COMMENT '元素精通',
   `crit` decimal(6,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '暴击率',
   `crit_dmg` decimal(6,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '暴击伤害',
   `recharge` decimal(6,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '充能效率',
   `heal` decimal(6,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '属性伤害加成',
   `created_at` datetime NOT NULL DEFAULT '2023-01-01 00:00:00',
   `updated_at` datetime NOT NULL DEFAULT '2023-01-01 00:00:00',
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='原神角色目标';
