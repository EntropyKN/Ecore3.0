ALTER TABLE `family` DROP INDEX `secret`;
ALTER TABLE `family` CHANGE `secret` `secret` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL;
ALTER TABLE `family` ADD `public` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL AFTER `family`;
ALTER TABLE `family` ADD `iss` VARCHAR(128) NOT NULL AFTER `family`;
ALTER TABLE `family` CHANGE `family` `family` VARCHAR(16) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL;
ALTER TABLE `family` ADD INDEX(`iss`);
ALTER TABLE `users` DROP INDEX `emailFamily`;
ALTER TABLE `users` ADD UNIQUE `muser_family` (`muser_id`, `family`) USING BTREE;