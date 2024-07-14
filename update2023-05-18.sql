ALTER TABLE `games` CHANGE `winningPercStart` `winningPercStart` DECIMAL(10,2) NOT NULL DEFAULT '75.00';
update games set winningPercStart=75.00;

DELETE FROM avatars WHERE `avatars`.`id` = 3;

UPDATE `games_steps` SET `avatar_id` = '1000' WHERE `games_steps`.`avatar_id` = '3';

INSERT INTO `plang` (`name`, `usr`, `edt`, `it`, `en`, `ar`, `es`, `de`, `fr`, `pt`, `note`) VALUES
('debrief_graph_explain', '1', '1', 'Le percentuali mostrate sulle singole barre sono calcolate rispetto al massimo punteggio ottenibile in ogni step.<br />Il risultato finale è calcolato rapportando il punteggio conseguito con il massimo punteggio raggiungibile nel gioco.', 'The percentages shown on the individual bars are calculated in relation to the maximum score obtainable in each step.<br />The final result is calculated by comparing the score achieved with the maximum score achievable in the game', '', '', '', '', '',  '');
