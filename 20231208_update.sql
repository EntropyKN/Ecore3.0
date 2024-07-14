INSERT INTO `plang` (`name`, `usr`, `edt`, `it`, `en`, `ar`, `es`, `de`, `fr`, `pt`, `id`, `note`) VALUES ('upload_an_image', '0', '1', 'Carica una immagine', 'Upload an image', '', '', '', '', '', NULL, '');

INSERT INTO `plang` (`name`, `usr`, `edt`, `it`, `en`, `ar`, `es`, `de`, `fr`, `pt`, `id`, `note`) VALUES ('textual', '0', '1', 'Testuale', 'textual', '', '', '', '', '', NULL, '');

INSERT INTO `plang` (`name`, `usr`, `edt`, `it`, `en`, `ar`, `es`, `de`, `fr`, `pt`, `id`, `note`) VALUES ('by_images', '0', '1', 'Per immagini', 'By images', '', '', '', '', '', NULL, '');

INSERT INTO `plang` (`name`, `usr`, `edt`, `it`, `en`, `ar`, `es`, `de`, `fr`, `pt`, `id`, `note`) VALUES ('alternative_text', '0', '1', 'Testo alternativo', 'Alternative text', '', '', '', '', '', NULL, '');

ALTER TABLE `games_steps` ADD `answersType` ENUM('img','txt') NOT NULL DEFAULT 'txt' AFTER `feedback_4_scenario_id`, ADD `img_1` VARCHAR(255) NULL DEFAULT NULL AFTER `answersType`, ADD `img_2` VARCHAR(255) NULL DEFAULT NULL AFTER `img_1`, ADD `img_3` VARCHAR(255) NULL DEFAULT NULL AFTER `img_2`, ADD `img_4` VARCHAR(255) NULL DEFAULT NULL AFTER `img_3`;

ALTER TABLE `games_steps` ADD `imgAlt_1` VARCHAR(255) NOT NULL DEFAULT '' AFTER `img_4`, ADD `imgAlt_2` VARCHAR(255) NOT NULL DEFAULT '' AFTER `imgAlt_1`, ADD `imgAlt_3` VARCHAR(255) NOT NULL DEFAULT '' AFTER `imgAlt_2`, ADD `imgAlt_4` VARCHAR(255) NOT NULL DEFAULT '' AFTER `imgAlt_3`;


INSERT INTO `plang` (`name`, `usr`, `edt`, `it`, `en`, `ar`, `es`, `de`, `fr`, `pt`, `id`, `note`) VALUES ('missing_one_or_more_image_answers', '0', '1', 'Manca l\'immagine di una o più risposte', 'Missing one or more answers by images', '', '', '', '', '', NULL, '');


INSERT INTO `plang` (`name`, `usr`, `edt`, `it`, `en`, `ar`, `es`, `de`, `fr`, `pt`, `id`, `note`) VALUES ('image_answer', '0', '1', 'immagine di risposta', 'image answer', '', '', '', '', '', NULL, '');


INSERT INTO `plang` (`name`, `usr`, `edt`, `it`, `en`, `ar`, `es`, `de`, `fr`, `pt`, `id`, `note`) VALUES ('change_image', '0', '1', 'Cambia immagine', 'Change image', '', '', '', '', '', NULL, '');

INSERT INTO `plang` (`name`, `usr`, `edt`, `it`, `en`, `ar`, `es`, `de`, `fr`, `pt`, `id`, `note`) VALUES ('click_to_enlarge', '1', '0', 'Click per ingrandire', 'Click to enlarge', '', '', '', '', '', NULL, '');


INSERT INTO `plang` (`name`, `usr`, `edt`, `it`, `en`, `ar`, `es`, `de`, `fr`, `pt`, `id`, `note`) VALUES ('AUDIO_ANSWER_FOR_EQUATION', '1', '0', 'Ecco l\'equazione', 'here\'s the equation', '', '', '', '', '', NULL, '');


INSERT INTO `plang` (`name`, `usr`, `edt`, `it`, `en`, `ar`, `es`, `de`, `fr`, `pt`, `id`, `note`) VALUES ('AUDIO_ANSWER_FOR_IMAGE', '1', '0', 'Rispondo con questa immagine', 'I answer with this image', '', '', '', '', '', NULL, '');



ALTER TABLE `games_steps` CHANGE `imgAlt_1` `altImg_1` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `games_steps` CHANGE `imgAlt_2` `altImg_2` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `games_steps` CHANGE `imgAlt_3` `altImg_3` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `games_steps` CHANGE `imgAlt_4` `altImg_4` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
