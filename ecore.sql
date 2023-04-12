-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Apr 12, 2023 alle 12:56
-- Versione del server: 5.7.41-log
-- Versione PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `psgameur_ecore`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `avatars`
--

CREATE TABLE `avatars` (
  `id` int(11) NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  `sex` enum('m','f','n') DEFAULT 'f',
  `invisble` tinyint(1) NOT NULL DEFAULT '0',
  `propertyUid` int(11) DEFAULT NULL,
  `creatorUid` int(11) DEFAULT NULL,
  `creationDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `publicWannabe` tinyint(1) NOT NULL DEFAULT '1',
  `voiceId_it` int(11) DEFAULT NULL,
  `voiceId_en` int(11) DEFAULT NULL,
  `voiceId_it_f` int(11) DEFAULT NULL COMMENT 'for id1000 only',
  `voiceId_en_f` int(11) DEFAULT NULL COMMENT 'for id1000 only'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `avatars`
--

INSERT INTO `avatars` (`id`, `name`, `sex`, `invisble`, `propertyUid`, `creatorUid`, `creationDate`, `publicWannabe`, `voiceId_it`, `voiceId_en`, `voiceId_it_f`, `voiceId_en_f`) VALUES
(1, 'Monica', 'f', 0, NULL, NULL, '2022-11-01 16:33:01', 1, 199, 70, NULL, NULL),
(2, 'John', 'm', 0, NULL, NULL, '2022-11-01 16:33:01', 1, 201, 71, NULL, NULL),
(3, 'Grace', 'f', 0, NULL, NULL, '2022-11-01 16:33:01', 1, 198, 72, NULL, NULL),
(1000, 'L_no_avatar', 'f', 0, NULL, NULL, '2022-11-01 16:33:01', 1, 201, 69, 199, 68),
(5, 'Rose', 'f', 0, NULL, NULL, '2022-11-01 16:33:01', 1, 199, 78, NULL, NULL),
(6, 'kate', 'f', 0, NULL, NULL, '2022-11-01 16:33:01', 1, 198, 80, NULL, NULL),
(7, 'Giorgia', 'f', 0, NULL, NULL, '2022-11-01 16:33:01', 1, 199, 82, NULL, NULL),
(8, 'Mario', 'm', 0, NULL, NULL, '2022-11-01 16:33:01', 1, 200, 79, NULL, NULL),
(9, 'George', 'm', 0, NULL, NULL, '2022-11-01 16:33:01', 1, 201, 81, NULL, NULL),
(10, 'Hassan', 'm', 0, NULL, NULL, '2022-11-01 16:33:01', 1, 200, 69, NULL, NULL),
(1006, 'Gruista Capo', 'm', 0, NULL, NULL, '2022-11-01 17:01:00', 1, 201, 71, NULL, NULL),
(1007, 'Gruista Sottoposto', 'm', 0, NULL, NULL, '2022-11-01 17:07:46', 1, 200, 79, NULL, NULL),
(1008, 'Jack Nerd', 'm', 0, NULL, NULL, '2022-11-01 17:12:53', 1, 201, 81, NULL, NULL),
(1009, 'Iva L\'alternativa', 'f', 0, NULL, NULL, '2022-11-01 17:13:35', 1, 198, 68, NULL, NULL),
(1019, 'Ernesto', 'm', 0, NULL, NULL, '2023-03-06 16:46:53', 1, 201, 79, NULL, NULL),
(1027, 'Lucy 24bit', 'f', 0, NULL, NULL, '2023-03-24 13:09:47', 1, 199, 70, NULL, NULL),
(1028, 'Sergio 24bit', 'm', 0, NULL, NULL, '2023-03-24 17:37:11', 1, 368, 79, NULL, NULL),
(1029, 'Direttrice 24bit', 'f', 0, NULL, NULL, '2023-03-24 19:39:29', 1, 367, 72, NULL, NULL),
(1030, 'Scienziato 24bit', 'm', 0, NULL, NULL, '2023-03-25 11:02:18', 1, 200, 81, NULL, NULL),
(1031, 'Davide 24bit', 'm', 0, NULL, NULL, '2023-03-25 17:12:16', 1, 201, 69, NULL, NULL),
(1032, 'Beatrice 24bit', 'f', 0, NULL, NULL, '2023-03-26 11:10:48', 1, 198, 78, NULL, NULL),
(1034, 'Addetto 24bit', 'm', 0, NULL, NULL, '2023-03-26 11:18:47', 1, 368, 71, NULL, NULL),
(1035, 'Emo', 'f', 0, NULL, NULL, '2023-03-29 13:15:59', 1, 367, 82, NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `email_validation`
--

CREATE TABLE `email_validation` (
  `email` varchar(255) NOT NULL,
  `code` varchar(5) NOT NULL,
  `validatets` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL,
  `editedts` int(11) NOT NULL,
  `createdts` int(11) NOT NULL DEFAULT '0',
  `validationIP` varchar(12) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `family`
--

CREATE TABLE `family` (
  `family` varchar(16) COLLATE latin1_general_ci NOT NULL COMMENT 'oauth_consumer_key',
  `secret` varchar(32) COLLATE latin1_general_ci NOT NULL,
  `title` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dump dei dati per la tabella `family`
--

INSERT INTO `family` (`family`, `secret`, `title`, `id`) VALUES
('demotest', '09i1o22gx9t8hgwxjxcynvp3hjdvaPUB', 'Test funzionamento', 1),
('entropy', '3gpahyo442ee9881o465h9nnj3yk8PUB', 'Entropy Knowledge Network', 10);

-- --------------------------------------------------------

--
-- Struttura della tabella `fonts`
--

CREATE TABLE `fonts` (
  `file` varchar(64) COLLATE latin1_general_ci NOT NULL,
  `name` varchar(64) COLLATE latin1_general_ci NOT NULL,
  `balloonSize` float(3,1) NOT NULL DEFAULT '21.0',
  `balloonSizeEditor` float(3,1) NOT NULL DEFAULT '11.0',
  `fformat` varchar(16) COLLATE latin1_general_ci NOT NULL DEFAULT 'woff'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dump dei dati per la tabella `fonts`
--

INSERT INTO `fonts` (`file`, `name`, `balloonSize`, `balloonSizeEditor`, `fformat`) VALUES
('COMICS.woff', 'Comics Regular', 23.5, 12.0, 'woff'),
('OpenDyslexic-Regular.otf', 'OpenDyslexic Regular', 21.0, 11.0, 'woff');

-- --------------------------------------------------------

--
-- Struttura della tabella `games`
--

CREATE TABLE `games` (
  `gameId` int(11) NOT NULL,
  `language` varchar(2) DEFAULT NULL,
  `cover_id` int(11) DEFAULT NULL,
  `cover` varchar(64) DEFAULT '0_640.jpg',
  `title` varchar(255) DEFAULT NULL,
  `Description` text,
  `Goal_1` text,
  `Goal_2` text,
  `Goal_3` text,
  `Goal_4` text,
  `Goal_5` text,
  `steps` int(2) DEFAULT '3',
  `audio` tinyint(1) DEFAULT NULL,
  `estimated_duration` varchar(255) DEFAULT NULL,
  `competence_target` varchar(255) DEFAULT NULL,
  `difficulty_level` varchar(255) DEFAULT NULL,
  `usr_female_avatar_id` int(11) DEFAULT NULL,
  `usr_male_avatar_id` int(11) DEFAULT NULL,
  `usr_description` text,
  `usr_goal1` text,
  `usr_goal2` text,
  `usr_goal3` text,
  `uid_creator` int(11) DEFAULT NULL,
  `createdTs` int(11) DEFAULT NULL,
  `uid_editor` int(11) DEFAULT NULL,
  `editTs` int(11) DEFAULT NULL,
  `valid_until` date DEFAULT NULL,
  `L1_comment` text,
  `L2_comment` text,
  `L3_comment` text,
  `L4_comment` text,
  `W1_comment` text,
  `W2_comment` text,
  `W3_comment` text,
  `W4_comment` text,
  `structure` enum('linear','fork') NOT NULL DEFAULT 'linear',
  `forkFrom` int(11) NOT NULL DEFAULT '0',
  `status` enum('draft','playable','offline','deleted') NOT NULL DEFAULT 'draft',
  `balloonFont` varchar(64) DEFAULT NULL,
  `dontShowDebriefScore` tinyint(1) NOT NULL DEFAULT '0',
  `endCredits` text,
  `videoIntro` varchar(128) DEFAULT NULL,
  `winningPercStart` decimal(10,2) NOT NULL DEFAULT '50.00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `games_spread`
--

CREATE TABLE `games_spread` (
  `gameId` int(11) NOT NULL,
  `spread` enum('L1','L2','L3','L4','W1','W2','W3','W4') NOT NULL,
  `spreadLP` decimal(10,2) NOT NULL,
  `spreadRP` decimal(10,2) NOT NULL,
  `spreadL` decimal(10,2) NOT NULL,
  `spreadR` decimal(10,2) NOT NULL,
  `idSpread` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `games_steps`
--

CREATE TABLE `games_steps` (
  `gameId` int(11) NOT NULL,
  `step` int(2) NOT NULL,
  `scene` enum('A','B','C','D') NOT NULL DEFAULT 'A',
  `goto1` enum('A','B','C','D') NOT NULL DEFAULT 'A',
  `goto2` enum('A','B','C','D') NOT NULL DEFAULT 'A',
  `goto3` enum('A','B','C','D') NOT NULL DEFAULT 'A',
  `goto4` enum('A','B','C','D') DEFAULT NULL,
  `scenario_id` int(11) DEFAULT NULL,
  `avatar_id` int(11) DEFAULT NULL,
  `avatar_size` varchar(16) DEFAULT 'S',
  `avatar_pos` varchar(255) DEFAULT NULL,
  `balloon_pos` varchar(16) DEFAULT '157,31',
  `arrowY` varchar(3) DEFAULT '11',
  `arrowPos` varchar(12) NOT NULL DEFAULT 'left',
  `avatar_sentence` text,
  `avatar_audio` varchar(255) DEFAULT NULL,
  `compulsoryAttachments` tinyint(1) NOT NULL DEFAULT '0',
  `answer_1` text,
  `ascore_1` int(2) DEFAULT NULL,
  `answer_2` text,
  `ascore_2` int(2) DEFAULT NULL,
  `answer_3` text,
  `ascore_3` int(2) DEFAULT NULL,
  `answer_4` text,
  `ascore_4` int(2) DEFAULT NULL,
  `type` enum('winning','loosing') DEFAULT NULL,
  `feedback_1` text,
  `feedback_2` text,
  `feedback_3` text,
  `feedback_4` text,
  `feedback_1_audio` varchar(64) DEFAULT NULL,
  `feedback_2_audio` varchar(64) DEFAULT NULL,
  `feedback_3_audio` varchar(64) DEFAULT NULL,
  `feedback_4_audio` varchar(64) DEFAULT NULL,
  `feedback_1_scenario_id` int(11) DEFAULT NULL,
  `feedback_2_scenario_id` int(11) DEFAULT NULL,
  `feedback_3_scenario_id` int(11) DEFAULT NULL,
  `feedback_4_scenario_id` int(11) DEFAULT NULL,
  `audioAnwers` varchar(255) DEFAULT NULL,
  `audioAnwersUpdate` int(11) DEFAULT NULL,
  `idStep` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `games_steps_attachments`
--

CREATE TABLE `games_steps_attachments` (
  `gameId` int(11) NOT NULL,
  `step` int(2) NOT NULL,
  `scene` enum('A','B','C','D') NOT NULL DEFAULT 'A',
  `title` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `type` varchar(32) NOT NULL DEFAULT 'attach',
  `mime` varchar(32) DEFAULT NULL,
  `idAttachment` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `game_family`
--

CREATE TABLE `game_family` (
  `gameId` int(11) DEFAULT NULL,
  `family` varchar(16) COLLATE latin1_general_ci DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `game_usersgroups`
--

CREATE TABLE `game_usersgroups` (
  `gameId` int(11) NOT NULL,
  `idgroup` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `matches`
--

CREATE TABLE `matches` (
  `idm` int(11) NOT NULL,
  `gameId` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) DEFAULT NULL,
  `final` varchar(2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `matches_step`
--

CREATE TABLE `matches_step` (
  `idm` int(11) NOT NULL,
  `step` int(11) NOT NULL,
  `scene` enum('A','B','C') NOT NULL DEFAULT 'A',
  `steps` int(11) NOT NULL,
  `ascore` int(11) NOT NULL,
  `answerN` int(2) NOT NULL,
  `ts` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `plang`
--

CREATE TABLE `plang` (
  `name` varchar(255) NOT NULL,
  `usr` enum('0','1') DEFAULT '0',
  `edt` enum('0','1') NOT NULL DEFAULT '0',
  `it` text NOT NULL,
  `en` text NOT NULL,
  `ar` text NOT NULL,
  `es` text NOT NULL,
  `de` text NOT NULL,
  `fr` text NOT NULL,
  `pt` text NOT NULL COMMENT 'português',
  `id` int(11) NOT NULL,
  `note` varchar(1024) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `plang`
--

INSERT INTO `plang` (`name`, `usr`, `edt`, `it`, `en`, `ar`, `es`, `de`, `fr`, `pt`, `id`, `note`) VALUES
('month_january', '1', '0', 'gennaio', 'January', '', 'enero', 'Jänner', 'janvier', 'janeiro', 1, ''),
('month_february', '1', '0', 'febbraio', 'February', '', 'febrero', 'Februar', 'février', 'fevereiro', 2, ''),
('month_march', '1', '0', 'marzo', 'March', '', 'marzo', 'März', 'mars', 'março', 3, ''),
('month_april', '1', '0', 'aprile', 'April', '', 'abril', 'April', 'avril', 'abril', 4, ''),
('month_may', '1', '0', 'maggio', 'May', '', 'mayo', 'Mai', 'mai', 'maio', 5, ''),
('month_june', '1', '0', 'giugno', 'June', '', 'junio', 'Juni', 'juin', 'junho', 6, ''),
('month_july', '1', '0', 'luglio', 'July', '', 'julio', 'Juli', 'juillet', 'julho', 7, ''),
('month_august', '1', '0', 'agosto', 'August', '', 'agosto', 'August', 'août', 'agosto', 8, ''),
('month_september', '1', '0', 'settembre', 'September', '', 'septiembre', 'September', 'septembre', 'setembro', 9, ''),
('month_october', '1', '0', 'ottobre', 'October', '', 'octubre', 'Oktober', 'octobre', 'outubro', 10, ''),
('month_november', '1', '0', 'novembre', 'November', '', 'noviembre', 'November', 'novembre', 'novembro', 11, ''),
('month_december', '1', '0', 'dicembre', 'December', '', 'diciembre', 'Dezember', 'décembre', 'dezembro', 12, ''),
('monday', '1', '0', 'lunedì', 'Monday', '', 'lunes', 'Montag', 'lundi', 'segunda', 13, ''),
('tuesday', '1', '0', 'martedì', 'Tuesday', '', 'martes', 'Dienstag', 'mardi', 'terça', 14, ''),
('wednesday', '1', '0', 'mercoledì', 'Wednesday', '', 'miércoles', 'Mittwoch', 'mercredi', 'quarta', 15, ''),
('thursday', '1', '0', 'giovedì', 'Thursday', '', 'jueves', 'Donnerstag', 'jeudi', 'quinta', 16, ''),
('friday', '1', '0', 'venerdì', 'Friday', '', 'viernes', 'Freitag', 'vendredi', 'sexta', 17, ''),
('saturday', '1', '0', 'sabato', 'Saturday', '', 'sábado', 'Samstag', 'samedi', 'sábado', 18, ''),
('sunday', '1', '0', 'domenica', 'Sunday', '', 'domingo', 'Sonntag', 'dimanche', 'domingo', 19, ''),
('msg_QUESTION_DOTS_on_facebook_and_google_too', '0', '0', '...anche su FB e Google?', '..on FB and Google as well?', '', '...¿también en FB y Google?', '', '...même sur FB et Google?', '...Também no FB e Google?', 20, ''),
('about_a_week_ago', '1', '0', 'la settimana scorsa', 'a week ago', '', '', '', '', '', 1487, ''),
('day', '1', '0', 'Giorno', 'Day', '', 'Día', 'Tag', 'Jour', 'Dia', 22, ''),
('month', '1', '0', 'Mese', 'Month', '', 'Mes', 'Monat', 'Mois', 'Mês', 23, ''),
('year', '1', '0', 'Anno', 'Year', '', 'Año', 'Jahr', 'Année', 'Ano', 24, ''),
('we_re_sorry_too_many_connections', '0', '0', 'Ci spiace ma in questo momento ci sono un po\' troppe connessioni', 'Sorry, too many connections at the moment', '', 'Lo siento, demasiadas conexiones en este momento', '', 'Désolés, mais dans ce moment il y a trop de connexions', 'Desculpe, actualmente existem muitas conexões', 25, ''),
('try_later', '0', '0', 'Riprova tra qualche istante', 'Try later', '', 'Por favor, intentelo más tarde', 'versuchen Sie es späte', 'Réessayez après quelques instants', 'Tente novamente em alguns minutos', 26, ''),
('birth_date', '0', '0', 'Data di nascita', 'Birth date', '', 'Fecha del nacimiento', '', 'Date de naissance', 'Data de nascimento', 27, ''),
('msg_sign_up_digit_your_new_password', '0', '0', 'Digita la tua nuova password', 'Digit your new password', '', 'Escriba su nueva contraseña', '', 'Saisissez votre nouveau mot de passe', 'Digite a sua nova senha', 912, ''),
('tag', '0', '0', 'Tag', 'Tag', '', 'Tag', '', 'Tag', 'Tag', 31, ''),
('undo', '0', '0', 'ripristina', 'Undo', '', 'restaurar', '', 'rétablir', 'restaurar', 46, ''),
('msg_sharing_box_edit', '0', '0', 'modifica', 'Edit', '', 'editar', '', 'modifier', 'editar', 47, ''),
('msg_txt_tags', '0', '0', 'Tags', 'Tags', '', 'Tags', '', 'Tags', 'Tags', 49, ''),
('msg_txt_add', '0', '0', 'Aggiungi', 'Add', '', 'Añadir', '', 'Ajoutez', 'adicionar', 70, ''),
('are_you_sure', '1', '1', 'Sei sicuro?', 'Are you sure?', 'هل أنت واثق؟', '¿Está seguro?', '', 'êtes-vous sûrs?', 'Tem certeza?', 81, ''),
('read_more', '0', '0', 'mostra tutto', 'Show all', '', 'Ver más', '', 'afficher tout', 'ver mais', 100, ''),
('show_less', '0', '0', 'riduci', 'show less', '', 'Ver menos', '', 'masquer', 'ver menos', 101, ''),
('loading', '1', '0', 'Sto caricando', 'Loading', 'المحمل', 'Estoy cargando (Lo juro)', '', 'Chargement (Je jure)', 'estou carregando (eu juro:-)', 102, ''),
('close', '1', '0', 'chiudi', 'close', 'أغلق', 'cerrar', '', 'fermer', 'fechar', 103, ''),
('image_doesnt_exist', '0', '0', 'Immagine inesistente', 'The image doesn\'t exist', '', 'la imagen no existe', '', 'Image inexistante', 'A imagem não existe', 106, ''),
('image_doesnt_exist_description', '0', '0', 'L\'immagine non esiste più... probabilmente é stata rimossa, o spostata', 'The image doesn\'t exists anymore... maybe it has been removed or moved', '', 'La imagen no existe más ... Tal vez se ha eliminado o movido', '', 'L\'image n\'existe plus...probablement elle a été supprimée, ou déplacée', 'A imagem não existe mais... Talvez tenha sido excluído ou movido', 107, ''),
('vabe', '1', '0', 'Vabé', 'That\'s right', '', 'No pasa nada', '', 'Bien', 'Ok', 108, ''),
('error', '1', '0', 'errorino', 'small mistake', 'خطأ صغير', 'problemita', '', 'petit erreur', 'Houston, temos um problema', 109, ''),
('error_description', '0', '0', 'sembra che ci sia un problemino, prova a controllare la tua connessione', 'it seems like you have a little problem, check your connection', '', 'parece que hay un problema, prueba a ver tu conección', '', 'il semble qu\'il y a un petit problème, esseyez de contrôler votre connexion', 'parece ser um problema, tente verificar a sua conexão', 110, ''),
('msg_txt_login', '1', '0', 'Entra', 'LogIn', 'تسجيل الدخول', 'Acceder', '', 'Connexion', 'Entrar', 126, ''),
('logout', '1', '1', 'Esci', 'LogOut', 'خروج', 'Salir', '', 'Déconnexion', 'Sair', 127, ''),
('to', '1', '1', 'a', 'To', 'To(ar)', 'Para', '', 'À', 'Para', 130, ''),
('from', '1', '1', 'Da', 'From', 'From(ar)', 'de', '', 'De', 'Do', 131, ''),
('send', '1', '0', 'Invia', 'Send', 'إرسال', 'Envíar', '', 'Envoyer', 'Enviar', 135, ''),
('cancel', '1', '1', 'Annulla', 'Cancel', '', 'Cancelar', '', 'Annuler', 'cancelar', 136, ''),
('AND', '0', '0', 'e', 'and', '', 'y', '', 'et', 'e', 138, ''),
('OR', '0', '0', 'o', 'or', '', 'o', '', 'ou', 'ou', 139, ''),
('peoples', '0', '0', 'persone', 'people', '', 'personas', '', 'personnes', 'pessoas', 140, ''),
('person', '0', '0', 'persona', 'person', '', 'persona', '', 'personne', 'pessoa', 141, ''),
('remove', '0', '0', 'elimina', 'remove', '', 'elimina', '', 'supprimer', 'remover', 176, ''),
('sign_up', '1', '0', 'Iscriviti', 'SignUp', 'الاشتراك', 'Regístrate', '', 'Inscrivez-vous', 'Cadastre-se', 223, ''),
('signup_form', '0', '0', 'Iscrizione', 'signup form', '', 'Regístrate', '', 'Inscription', 'Inscrição', 224, ''),
('please_be_honest', '0', '0', 'per favore sii sincero', 'please be honest', '', 'por favor, se honesto', '', 'soyez sincères, s\'il vous plaît', 'por favor, seja honesto', 225, ''),
('log_in', '1', '0', 'Accedi', 'Log In', 'تسجيل الدخول', 'Entrar', '', 'Connexion', 'Accesse', 226, ''),
('keep_me_logged_in', '0', '0', 'resta connesso', 'keep me logged in', '', 'no cerrar sesión', '', 'garder ma session active', 'Mantenha-me conectado', 227, ''),
('msg_txt_continue', '1', '0', 'Continua', 'Continue', '', 'Siguen', '', 'Continuer', 'Continuar', 244, ''),
('msg_login_banned', '0', '0', 'Account sospeso', 'Account suspended', '', 'Cuenta suspendida', '', 'Compte suspendu', 'Conta suspensa', 260, ''),
('msg_login_banned_description', '0', '0', 'ci spiace comunicarti che il tuo account é stato sospeso.', 'we are sorry to inform you that your account has been suspended.', '', 'Lamentamos informarte que tu cuenta ha sido suspendida.', '', 'désolés de vous communiquer que votre compte a été suspendu', 'Lamentamos informar que sua conta foi suspensa', 261, ''),
('msg_txt_account', '0', '0', 'Account', 'Account', '', 'Cuenta', '', 'Compte', 'Conta', 268, ''),
('user', '1', '1', 'Utente', 'User', 'مستخدم', 'Usuario', '', 'Utilisateur', 'Usuário', 281, ''),
('password', '1', '1', 'Password', 'Password', 'كلمة المرور', 'Contraseña', '', 'Mot de passe', 'Senha', 282, ''),
('email', '1', '1', 'Email', 'Email', '', 'Tu correo electrónico', '', 'Adresse électronique', 'E-mail', 283, ''),
('username', '0', '0', 'Nome Utente', 'UserName', '', 'Nombre de usuario', '', 'Nom d\'utilisateur', 'Nome de usuário', 284, ''),
('lastname', '1', '1', 'Cognome', 'Last Name', '', 'Apellido', '', 'Nom de famille', 'Sobrenome', 286, ''),
('firstname', '1', '1', 'Nome', 'First Name', '', 'Nombre', '', 'Prénom', 'Nombre', 287, ''),
('your_real_lastname', '0', '0', 'il tuo VERO Cognome', 'Your real Last Name', '', 'Su apellido REAL', '', 'Votre vrai nom de famille', 'seu VERDADEIRO Sobrenome', 288, ''),
('your_real_firstname', '0', '0', 'il tuo VERO Nome', 'Your real first Name', '', 'Su nombre REAL', '', 'Votre vrai prénom', 'seu VERDADEIRO Nombre', 289, ''),
('reenter_email', '1', '0', 'Per sicurezza, riscrivi la tua email', 'Please, re-enter your email again', '', 'Por seguridad, escribe de nuevo tu correo electrónico', '', 'Pour être plus sûrs, récrivez votre adresse électronique', 'Para maior segurança, digite seu e-mail novamente', 290, ''),
('msg_sign_up_digit_your_password', '0', '0', 'Digita la tua password', 'Digit your password', '', 'Escriba su contraseña', '', 'Écrivez votre mot de passe', 'Digite sua senha', 291, ''),
('not_correct', '0', '0', 'Non corretto', 'incorrect', '', 'incorrecto', '', 'pas exact', 'incorreto', 292, ''),
('digit', '0', '1', 'Digita', 'Digit', '', 'Escribir', '', 'Écrivez', 'Digite', 293, ''),
('it_cant_be_changed', '0', '0', 'non può essere cambiato', 'it cannot be changed', '', 'no puede ser cambiado', '', 'ne peut pas être changé', 'não pode ser alterado', 296, ''),
('attention', '0', '1', 'Attenzione', 'Attention', 'ملاحظة', 'Cuidado', '', 'Attention', 'Atenção', 297, ''),
('save', '1', '1', 'Salva', 'Save', 'حفظ', 'Guardar', '', 'Enregistrer', 'salvar', 298, ''),
('not_available', '1', '1', 'Non disponibile', 'Not available', '', 'No está disponible', '', 'Non disponible', 'Indisponível', 301, ''),
('available', '0', '0', 'disponibile', 'available', '', 'disponible', '', 'disponible', 'disponível', 302, ''),
('too_short', '0', '1', 'Troppo breve', 'too short', '', 'demasiado corto', '', 'Trop bref', 'muito curto', 303, ''),
('too_long', '0', '0', 'Troppo lungo', 'too long', '', 'demasiado largo', '', 'Trop long', 'muito longo', 304, ''),
('not_complete', '0', '0', 'incompleto', 'incomplete', '', 'incompleto', '', 'incomplet', 'incompleto', 305, ''),
('checking', '0', '0', 'do una controllata...', 'let\'s check...', '', 'veamos un poco', '', 'je contrôle un peu...', 'estou verificando', 306, ''),
('email_exists', '1', '0', 'Email già registrata', 'This email already exists', '', 'Correo ya registrado', '', 'Adresse électronique déjà enregistrée', 'E-mail já registrada', 307, ''),
('sex', '1', '1', 'Sesso', 'Gender', '', 'Sexo', '', 'Sexe', 'Gênero', 308, ''),
('male', '1', '1', 'Maschio', 'Male', '', 'Hombre', '', 'Homme', 'Masculino', 309, ''),
('female', '1', '1', 'Femmina', 'Female', '', 'Mujer', '', 'Femme', 'Feminino', 310, ''),
('province', '0', '0', 'Provincia', 'Province', '', 'Provincia', '', 'Province', 'Condado', 324, ''),
('country', '0', '0', 'Nazione', 'Nation', '', 'Nación', '', 'État', 'Nação', 325, ''),
('region', '0', '0', 'Regione', 'Region', '', 'Región', '', 'Région', 'Região', 326, ''),
('note', '1', '0', 'NOTA', 'NOTE', 'ملاحظة', 'NOTA', '', 'NOTE', 'NOTA', 339, ''),
('sorry', '1', '1', 'Ci spiace', 'We are sorry', 'آسف', 'Lo sentimos', '', 'Désolés', 'Desculpe', 342, ''),
('it_seems_like_you_are_not_logged', '0', '0', 'sembra che tu non sia connesso in questo momento', 'it seems like you cannot connect at the moment', '', 'parece que no está conectado en este momento', '', 'il semble que vous n\'êtes pas connectés dans ce moment', 'Parece que você não está conectado neste momento', 343, ''),
('try_to_log_in_again', '0', '0', 'prova ad effettuare nuovamente il LOG-IN', 'try to LOGIN again', '', 'Tratar de entrar de nuevo', '', 'essayez à effectuer de nouveau le LOG-IN', 'Tente fazer o login novamente', 344, ''),
('show_all_SINGULAR', '1', '0', 'Mostra tutto', 'Show all', '\nعرض الكل', 'Mostra todo', '', 'Afficher tout', 'Ver todos', 385, ''),
('show_all_PLURAL', '1', '0', 'Mostra tutti', 'Show all', 'عرض الكل', 'Mostrar todos', '', 'Afficher tous', 'Ver todos', 386, ''),
('show_all_about', '0', '0', 'Mostra tutto su', 'Show all about', '', 'Muestra todo sobre', '', 'Afficher tout sur', 'Mostra tudo sobre', 387, ''),
('tags', '0', '0', 'tags', 'tags', '', 'tags', '', 'tags', 'tags', 391, ''),
('page_not_found', '0', '0', 'Pagina non trovata', 'Page not found', '', 'Página no encontrada', '', 'Page introuvable', 'Página não encontrada', 392, ''),
('the_page_you_requested_was_not_found', '0', '0', 'La pagina richiesta non è stata trovata', 'The page you requested was not found', '', 'No se pudo encontrar la página solicitada', '', 'La page cherchée est introuvable', 'A página solicitada não foi encontrada', 393, ''),
('you_may_have_clicked_an_expired_link_or_mistyped_the_address', '1', '0', 'Potresti aver cliccato su un link scaduto o aver digitato male l\'indirizzo', 'you may have clicked an expired link or mistyped the address', '', 'Puedes que hicieras clic en un enlace caducado o que escribieras mal la dirección', '', 'Ce lien n\'existe plus ou vous avez saisi une adresse incorrecte', 'Você pode ter clicado em um link expirado ou digitado o endereço errado', 394, ''),
('return_home', '0', '0', 'Torna in home page', 'Back home', '', 'Volver a la página de inicio', '', 'Retour à la page d\'accueil', 'Retornar à página inicial', 396, ''),
('home_page', '0', '0', 'Home Page', 'Home Page', '', 'Página de inicio', '', 'Accueil', 'Página inicial', 397, ''),
('go_back_to_the_previous_page', '0', '0', 'Torna alla pagina precedente', 'Back to the previous page', '', 'Volver a la página anterior', '', 'Retour à la page précédente', 'Retornar à página anterior', 398, ''),
('msg_tab_real_time', '0', '0', 'Tempo reale', 'Real Time', '', 'Tiempo real', '', 'Temps réel', 'Tempo real', 400, ''),
('yes', '1', '1', 'Sì', 'Yes', 'بلى', 'Sì', '', 'Oui', 'Sim', 461, ''),
('no', '1', '1', 'No', 'No', 'لا', 'No', '', 'Non', 'Não', 462, ''),
('moderator_options', '1', '0', 'Moderator\'s Options', 'Moderator\'s Options', 'Moderator\'s Options', 'Opciones de moderador', '', 'options du modérateur', 'Opções do moderador', 472, ''),
('ok', '1', '1', 'OK', 'OK', 'حسنا', 'OK', '', 'OK', 'OK', 473, ''),
('it_seems_like_youre_not_logged_in', '0', '0', 'Sembra che tu non abbia effettuato l\'accesso', 'It seems like you\'re not logged in', '', 'Parece que tú no está conectado', '', 'Il semble que vous n\'avez pas effectué la connexion', 'Parece que você não está conectado', 615, ''),
('log_in_and_try_again', '0', '0', 'Accedi e riprova', 'Log in and try again', '', 'Entrar y vuelva a intentarlo', '', 'Connettez-vous et ressayez', 'Entra e tente novamente', 616, ''),
('try_again', '0', '0', 'Riprova', 'Try again', '', 'volver a probar', '', 'Ressayez', 'tente novamente', 618, ''),
('suggest', '0', '0', 'Suggerisci', 'Suggest', '', 'sugerir', '', 'Suggérez', 'sugerir', 623, ''),
('when', '0', '0', 'Quando', 'When', '', 'Cuando', '', 'Quand', 'Quando', 624, ''),
('from_DATE', '1', '0', 'Da', 'From', '', 'Del', '', 'De', 'De', 625, ''),
('to_DATE', '1', '0', 'a', 'To', '', 'Al', '', 'à', 'a', 626, ''),
('tomorrow', '0', '0', 'domani', 'tomorrow', '', 'mañana', '', 'demain', 'amanhã', 647, ''),
('tonight', '0', '0', 'stasera', 'tonight', '', 'esta noche', '', 'ce soir', 'esta noite', 648, ''),
('today', '0', '0', 'oggi', 'today', '', 'hoy', '', 'aujourd\'hui', 'hoje', 649, ''),
('in_all', '0', '0', 'in tutto', 'in all', '', 'en total', '', 'en tout', 'no total', 659, ''),
('users', '1', '1', 'Utenti', 'Users', '', 'Usuarios', '', 'Utilisateurs', 'Usuarios', 673, ''),
('select_your_language', '1', '0', 'Seleziona la tua lingua', 'Select Your Language', 'اختر لغتك', 'Selecciona tu idioma', '', 'Sélectionnez votre langue', 'Selecione seu idioma', 675, ''),
('see_available_languages', '1', '0', 'Visualizza le lingue disponibili', 'Show available languages', 'مشاهدة اللغات المتوفرة', 'Mostrar los idiomas disponibles', '', 'Afficher toutes les langues disponibles', 'Mostrar idiomas disponíveis', 679, ''),
('privacy', '0', '0', 'Privacy', 'Privacy', '', 'Privacy', 'Privacy', 'Confidentialité', 'Privacidade', 701, 'no dialetto'),
('see_more_results_for', '0', '0', 'Visualizza tutti i risultati per', 'See more results for', '', 'Ver más resultados para', '', 'Voir tous les résultats pour', 'Ver todos os resultados para', 711, ''),
('displayed_results', '0', '0', 'Risultati visualizzati', 'Displayed results', '', 'Resultados mostrados', '', 'Résultats vus', 'Resultados exibidos', 712, ''),
('search', '0', '0', 'cerca', 'search', '', 'buscar', '', 'recherche', 'procurar', 724, ''),
('search_results', '0', '0', 'Risultati di ricerca', 'Search results', '', 'Resultados de búsqueda', '', 'Résultats de la recherche', 'Resultados da Pesquisa', 725, ''),
('search_results_for_TERM', '0', '0', 'Risultati di ricerca per', 'Search results for', '', 'Resultados de búsqueda para', '', 'Résultats de la recherche pour', 'Resultados da Pesquisa por', 726, ''),
('log_in_or_sign_up', '0', '0', 'Accedi o registrati', 'Log in or sign up', '', 'Ingresa o regístrate', '', 'Connettez-vous ou enregistrez-vous', 'Entre ou Cadastre-se', 768, ''),
('more', '1', '0', 'Altro', 'More', '', 'Más', '', 'Plus', 'Mais', 794, ''),
('welcome_MALE', '1', '0', 'Benvenuto', 'Welcome', 'ترحيب', 'Bienvenido', '', 'Bienvenu', 'Bem vindo', 853, ''),
('welcome_FEMALE', '1', '0', 'Benvenuta', 'Welcome', 'ترحيب', 'Bienvenida', '', 'Bienvenue', 'Ben vinda', 854, ''),
('welcomeback_MALE', '0', '0', 'Bentornato', 'Welcome back', '', 'Bienvenido de nuevo', '', 'Bienvenu', 'Bem-vindo de volta', 855, ''),
('welcomeback_FEMALE', '0', '0', 'Bentornata', 'Welcome back', '', 'Bienvenida de nuevo', '', 'Bienvenue', 'Bem-vinda de volta', 856, ''),
('title_is_too_short', '0', '0', 'Il titolo è troppo breve', 'The title is too short', '', 'El título es demasiado corto', '', 'Le titre est trop bref', 'O título é demasiado curto', 921, ''),
('no_title', '1', '0', 'Nessun titolo', 'No title', 'بلا عنوان', 'Sin título', '', 'Sans titre', 'Sem título', 929, ''),
('edit_title', '0', '0', 'modifica titolo', 'edit title', '', 'cambiar el título', '', 'modifier le titre', 'mudar o título', 931, ''),
('download_and_print', '0', '0', 'Scarica e Stampa', 'Download and Print', '', 'Descargue e Imprima', '', 'Téléchargez et Imprimez', 'Descarregar e Imprimir', 932, 'no dialetto'),
('last_update', '0', '0', 'ultimo aggiornamento', 'last update', '', 'última actualización', '', 'dernière actualisation', 'última actualização', 933, 'no dialetto'),
('INFO_main', '1', '0', 'Informazioni di base', 'Session Info', 'معلومات الدورة', '', '', '', '', 999, ''),
('charaters', '1', '1', 'Personaggi', 'Charaters', 'الأحرف', '', '', '', '', 1000, ''),
('goals', '1', '0', 'Obiettivi', 'Goals', 'أهداف', '', '', '', '', 1001, ''),
('show_all', '1', '0', 'Mostra tutto', 'Show all', 'عرض الكل', 'Mostra todo', '', 'Afficher tout', 'Ver todos', 1002, ''),
('next', '1', '0', 'prossimo', 'next', 'بعد', '', '', '', '', 1003, ''),
('previous', '1', '0', 'precedente', 'previous', 'سابق', '', '', '', '', 1004, ''),
('DFORM_send', '1', '0', 'Invia', 'Send', 'إرسال', 'Envíar', '', 'Envoyer', 'Enviar', 1005, ''),
('show_session_info', '1', '0', 'informazioni sulla sessione', 'Show Session info', 'معلومات اللعبة', '', '', '', '', 1006, ''),
('available_languages', '1', '0', 'Lingue disponibili', 'Available languages', 'اللغات المتوفرة', 'Idiomas disponibles', '', 'Langues disponibles', 'Idiomas disponíveis', 1007, ''),
('preview', '1', '0', 'Anteprima', 'Preview', 'معاينة', '', '', '', '', 1008, ''),
('show_last_exchange', '1', '0', 'Mostra l\'ultimo scambio', 'Show last exchange', 'عرض التبادل الماضي', '', '', '', '', 1010, ''),
('username_or_password_not_correct', '1', '0', 'lo username o la password non sono corretti', 'The Username or Password is incorrect', 'اسم المستخدم أو كلمة المرور غير صحيح', '', '', '', '', 1011, ''),
('LOGIN_username', '1', '0', 'Username', 'Username', 'اسم المستخدم', '', '', '', '', 1012, ''),
('LOGIN_password', '1', '0', 'Password', 'Password', 'كلمه السر', '', '', '', '', 1013, ''),
('you', '1', '0', 'Tu', 'You', 'أنت', 'Tu', '', 'Vous', 'Você', 120, ''),
('dashboard', '1', '1', 'Dash Board', 'Dash Board', 'لوحة القيادة', 'Tablero', '', '', '', 1014, ''),
('editor', '1', '1', 'Editor', 'Editor', 'محرر', '', '', '', '', 1015, ''),
('bot', '1', '1', 'Bot', 'Bot', 'رجل الالي', '', '', '', '', 1016, ''),
('parallel_sentences', '0', '1', 'Frasi parallele', 'Parallel sentences', 'الجمل المتوازية', '', '', '', '', 1017, ''),
('mood', '0', '1', 'Mood', 'Mood', 'مزاج', '', '', '', '', 1018, ''),
('do_you_want_to_save_the_changes', '0', '1', 'Salvare le modifiche?', 'Do you want to save the changes?', 'هل تريد حفظ التغييرات؟', '', '', '', '', 1019, ''),
('draft', '1', '1', 'Bozza', 'Draft', 'مسودة', '', '', '', '', 1020, ''),
('drafts', '1', '1', 'Bozze', 'Drafts', 'الداما', '', '', '', '', 1021, ''),
('normale_sereno', '1', '1', 'Normale, sereno', 'Normal, peaceful', 'Normale, sereno (ar)', '', '', '', '', 1023, ''),
('gioia', '1', '1', 'Gioia', 'Joy', 'Gioia (ar)', '', '', '', '', 1024, ''),
('sorpresa', '1', '1', 'Sorpresa', 'Surprise', 'Surprise (ar)', '', '', '', '', 1025, ''),
('rabbia_irritazione_disappunto', '1', '1', 'Rabbia, irritazione, disappunto', 'Anger, irritation, disappointment', 'Rabbia, irritazione, disappunto (ar)', '', '', '', '', 1026, ''),
('ansia_paura', '1', '1', 'Ansia, Paura', 'Anxiety , Fear', 'Anxiety , Fear (ar)', '', '', '', '', 1027, ''),
('diffidenza', '1', '1', 'Diffidenza', 'Distrust', 'distrust (ar)', '', '', '', '', 1028, ''),
('entusiasmo', '1', '1', 'Entusiasmo', 'Enthusiasm', 'Enthusiasm (ar)', '', '', '', '', 1029, ''),
('dispiacere', '1', '1', 'Dispiacere', 'Displeasure ', 'Displeasure (ar)', '', '', '', '', 1030, ''),
('interesse', '1', '1', 'Interesse', 'Interest', 'interest (ar)', '', '', '', '', 1031, ''),
('fiducia', '1', '1', 'Fiducia', 'Confidence ', 'Confidence (ar)', '', '', '', '', 1032, ''),
('upload_an_audio_file', '0', '1', 'Carica un file audio', 'Upload an audio file', 'Upload an audio file (AR)', '', '', '', '', 1033, ''),
('play', '0', '1', 'Play', 'Play', 'Play (ar)', '', '', '', '', 1034, ''),
('delete_the_current_audiofile_and_upload_a_new_one', '0', '1', 'Cancella questo file audio e caricane un altro', 'Delete the current audio file and upload a new one', 'حذف الملف الصوتي الحالي وتحميل واحدة جديدة', '', '', '', '', 1035, ''),
('pause', '0', '1', 'Pause', 'Pause', 'Pause (ar)', '', '', '', '', 1036, ''),
('insert_comment', '1', '1', 'inserisci un commento', 'Insert comment', 'Insert comment (ar)', '', '', '', '', 1037, ''),
('comment_this_exchange', '0', '1', 'Commenta questo scambio', 'Comment this exchange', 'Comment this exchange (ar)', '', '', '', '', 1038, ''),
('happy_assertive_ending', '1', '1', 'Lieto fine assertivo', 'Happy assertive ending', 'Happy \'assertive\' ending (ar)', '', '', '', '', 1039, ''),
('bot_temperament', '1', '1', 'Temperamento del Bot', 'Bot temperament', 'Bot temperament (ar)', '', '', '', '', 1042, ''),
('very_submissive', '1', '1', 'Molto inibito', 'Very shy', 'Very submissive (ar)', '', '', '', '', 1043, ''),
('submissive', '1', '1', 'Inibito', 'Shy', 'Submissive (ar)', '', '', '', '', 1044, ''),
('assertive', '1', '1', 'Assertivo', 'Assertive', 'Assertive (ar)', '', '', '', '', 1045, ''),
('aggressive', '1', '1', 'Aggressivo', 'Aggressive', 'Aggressive (ar)', '', '', '', '', 1046, ''),
('very_aggressive', '1', '1', 'Molto aggressivo', 'Very aggressive', 'Very aggressive (ar)', '', '', '', '', 1047, ''),
('BOT_TEMPERAMENT_INDEFINITE', '0', '1', 'Non lo so :-( prova ad assegnare più punteggi', 'I dont know :-( Try to assign more \"scores\"', 'I dont know :-( Try to complete more scores (ar)', '', '', '', '', 1048, ''),
('delete', '0', '1', 'Cancella', 'Delete', 'Delete (ar)', '', '', '', '', 1049, ''),
('add', '0', '1', 'Aggiungi', 'Add', 'Add(ar)', '', '', '', '', 1050, ''),
('back', '1', '1', 'Indietro', 'Back', 'الى الخلف', '', '', '', '', 1051, ''),
('go_to_next_step', '1', '1', 'Vai al prossimo step', 'Go to the next step', 'Go to the next step(ar)', '', '', '', '', 1052, ''),
('to_the_first_step', '0', '1', 'al primo step', 'to the first step', 'إلى الخطوة الأولى', '', '', '', '', 1053, ''),
('debriefing_simulation', '0', '1', 'Debriefing Simulation', 'Debriefing Simulation', 'Debriefing Simulation(ar)', '', '', '', '', 1054, ''),
('scores_are_not_properly_assigned', '0', '1', 'Punteggi non assegnati correttamente', 'Scores are not properly assigned', 'Scores are not properly assigned (ar)', '', '', '', '', 1055, ''),
('qualitative_comment', '1', '1', 'Commento Qualitativo', 'Qualitative Comment', 'Qualitative Comment (ar)', '', '', '', '', 1056, ''),
('quantitative_comment', '1', '1', 'Commento Quantitativo', 'Quantitative Comment', 'Quantitative Comment (ar)', '', '', '', '', 1057, ''),
('EDITOR_CHECK_TEXT', '0', '1', 'Il Game è attualmente in modalità DRAFT e quindi non disponibile per il gioco. \r\nPer renderlo \'Playable\'...\r\n', 'The Game is actually saved as a DRAFT so it\'s not playble yet.<br />To save it as Playable, Please...', '', '', '', '', '', 1058, ''),
('step', '0', '1', 'Step', 'Step', '', '', '', '', '', 1552, ''),
('missing', '0', '1', 'Mancante', 'Missing', '', '', '', '', '', 1553, ''),
('check_missing_values', '0', '1', 'Controlla valori mancanti', 'Check missing values', 'تحقق القيم المفقودة', '', '', '', '', 1059, ''),
('comment_result_for_this_range', '0', '1', 'Commento per il risultato in questo range', 'Comment result for this range ', 'Comment result for this range (ar)', '', '', '', '', 1060, ''),
('add_user_goal', '0', '1', 'Aggiungi Scopo Utente', 'Add User Goal', 'Add User Goal (ar)', '', '', '', '', 1062, ''),
('add_bot_goal', '0', '1', 'Aggiungi Scopo Bot', 'Add Bot Goal', 'Add Bot Goal (ar)', '', '', '', '', 1063, ''),
('state', '1', '1', 'Stato', 'State', 'State(ar)', '', '', '', '', 1065, ''),
('not_completed', '1', '1', 'Non completato', 'Not completed', 'Not completed(ar)', '', '', '', '', 1066, ''),
('group', '1', '1', 'Gruppo', 'Group', 'Group(ar)', '', '', '', '', 1067, ''),
('score_not_propertly_assigned', '0', '1', 'Punteggi non assegnati correttamente', 'Scores not properly assigned', 'Scores not properly assigned (ar)', '', '', '', '', 1068, ''),
('range', '0', '1', 'Range', 'Range', 'Range(ar)', '', '', '', '', 1069, ''),
('exchange', '1', '1', 'Scambio', 'Exchange', 'Exchange(ar)', '', '', '', '', 1070, ''),
('session_date', '1', '1', 'Data Sessione', 'Session Date', 'Session Date(ar)', '', '', '', '', 1071, ''),
('my_last_sessions', '1', '0', 'Le mie ultime sessioni', 'My last sessions', 'My last sessions(ar)', '', '', '', '', 1072, ''),
('bot_initial_escalation', '0', '1', 'Escalation Iniziale del Bot', 'Bot Initial Escalation', 'Bot Initial Escalation(ar)', '', '', '', '', 1074, ''),
('missing_comment_s', '0', '1', 'uno o più commenti mancanti', 'one or more comments are missing', '', '', '', '', '', 1075, ''),
('missing_the_final_comment', '0', '1', 'Manca il commento finale', 'The final comment is missing', 'Missing the final comment(ar)', '', '', '', '', 1076, ''),
('missing_one_or_more_user_texts', '0', '1', 'Mancano uno o più testi dello User', 'One or more User\'s texts are missing', 'Missing one or more User\'s texts(ar)', '', '', '', '', 1077, ''),
('missing_one_or_more_bot_texts', '', '1', 'Mancano uno o più testi del Bot', 'one or more of Bot\'s texts are missing', 'Missing one or more Bot\'s texts(ar)', '', '', '', '', 1078, ''),
('missing_the_bot_emotion', '', '1', 'Manca l\'emozione del Bot', 'Bot emotion is missing', 'Missing the Bot emotion(ar)', '', '', '', '', 1079, ''),
('missing_the_user_emotion', '', '1', 'Manca l\'emozione dello user', 'User’s emotion is missing', 'Missing the User emotion(ar)', '', '', '', '', 1080, ''),
('missing_one_or_more_bot_audioclips', '0', '1', 'Mancano una o più audio clip del Bot', 'One or more Bot audioclips are missing', 'Missing one or more Bot audioclips (ar)', '', '', '', '', 1081, ''),
('missing_one_or_more_user_audioclips', '0', '1', 'Mancano una o più audio clip dello User', 'One or more User audioclips are missing', 'Missing one or more User audioclips (ar)', '', '', '', '', 1082, ''),
('not_commented', '0', '1', 'non commentato', 'not commented', 'not commented(ar)', '', '', '', '', 1083, ''),
('playing_simulation', '0', '1', 'Simulazione di gioco', 'Game simulation', 'Playing simulation(ar)', '', '', '', '', 1084, ''),
('SAVE_PLAYABLE_ADVICE', '0', '1', 'ATTENZIONE: non potrai modificare più il Game, potrai però cancellarlo o copiarlo', 'WARNING: you won\'t be able to edit it anymore. You\'ll be able to delete or copy it', '', '', '', '', '', 1086, ''),
('the_first_two_answers_are_mandatory', '0', '1', 'Le prime due risposte sono obbligatorie', 'The first two answers are mandatory', '', '', '', '', '', 1555, ''),
('operations', '1', '1', 'operazioni', 'operations', 'operations(ar)', '', '', '', '', 1088, ''),
('create_a_copy_in_drafts', '1', '0', 'Crea una copia in Bozze', 'Create a copy in Drafts', 'Create a copy in Drafts(ar)', '', '', '', '', 1089, ''),
('set_offline', '1', '0', 'Metti OffLine', 'Set OffLine', 'Set OffLine(ar)', '', '', '', '', 1090, ''),
('copy_of_SOMETHING', '1', '1', 'Copia di', 'Copy of', 'نسخة من', '', '', '', '', 1091, ''),
('end_of_match', '1', '1', 'Fine Match', 'End of the Match', 'نهاية المباراة', '', '', '', '', 1093, ''),
('the_complete_results', '1', '1', 'I Risultati completi', 'The Complete results', 'النتائج الكاملة', '', '', '', '', 1094, ''),
('DIALOGUE_BOX_LOG_INTRO', '1', '0', 'Qui troverai tutti gli scambi effettuati durante il dialogo tra #user# e #bot#', 'Here you will find all the dialogue exchanges between #user# and #bot#', 'هنا سوف تجد جميع التبادلات الحوار بينك وبين بوت', '', '', '', '', 1095, ''),
('dialogue', '1', '0', 'Dialogo', 'Dialogue', 'حوار', '', '', '', '', 1096, ''),
('evaluating_your_performance', '1', '0', 'Sto valutando la tua performance', 'Evaulating your performance', 'تقييم أدائك', '', '', '', '', 1097, ''),
('say_it', '1', '0', 'Dillo', 'Choose', 'قل', '', '', '', '', 1098, ''),
('final', '1', '1', 'Finale', 'Final', 'نهائي', '', '', '', '', 1099, ''),
('BOT_INITIAL_ESCALATON_DISCLAIMER_NEGATIVE', '1', '0', 'Il Bot partiva con un atteggiamento iniziale di sottomissione pari a', 'The Bot started with an initial submissive attitude of', 'بدأ الصبي مع الموقف المبدئي منقاد من', '', '', '', '', 1100, ''),
('BOT_INITIAL_ESCALATON_DISCLAIMER_POSITIVE', '1', '0', 'Il Bot partiva con un atteggiamento iniziale di aggressività pari a', 'The Bot started with an initial aggressive attitude of', 'بدأ الصبي مع الموقف المبدئي منقاد من', '', '', '', '', 1101, ''),
('the_scale_of_values_varies_from_100_to_100', '1', '0', 'La scala di valori varia da -100 a +100', 'The scale of values varies from -100 to +100', 'سلم القيم يختلف من -100 إلى +100', '', '', '', '', 1102, ''),
('the_winning_area_goes_from_X_to_Y', '1', '0', 'L\'area vincente va da #X# a #Y#', 'The winning area goes from #X# to #Y#', 'منطقة كسب وغني عن #X# إلى #Y#', '', '', '', '', 1103, ''),
('bot_initiial_temperament', '1', '0', 'Orientamento iniziale del Bot', 'Bot starting temperament ', 'Bot starting temperament(AR)', '', '', '', '', 1104, ''),
('total_time_played', '1', '0', 'Tempo totale di gioco', 'Total time played', 'الوقت الإجمالي لعبت', '', '', '', '', 1105, ''),
('reached_score', '1', '0', 'Punteggio Conseguito', ' Score Reached ', 'النتيجة التي تم التوصل إليها', '', '', '', '', 1106, ''),
('epic_fail', '1', '0', 'Epic Fail', 'Epic Fail', 'Epic FailAR', '', '', '', '', 1107, ''),
('magic_moment', '1', '0', 'Magic Moment', 'Magic Moment', 'Magic MomentAR', '', '', '', '', 1108, ''),
('watch_again', '1', '1', 'Rivedi', 'Watch again', 'نهاية المباراة', '', '', '', '', 1109, ''),
('watch_the_full_movie_of_your_match', '1', '0', 'Guarda il \"film\" del tuo Match', 'Watch the full movie of your match', 'مشاهدة الفيلم الكامل لمباراة الخاص بك', '', '', '', '', 1110, ''),
('thirty_years_old_man', '1', '1', 'Uomo trentenne', 'A thirty-year-old man', 'رجل في الثلاثين من عمره', '', '', '', '', 1111, ''),
('thirty_years_old_woman', '1', '1', 'Donna trentenne', 'A thirty-year-old woman', 'رجل في الثلاثين من عمره', '', '', '', '', 1112, ''),
('forty_years_old_woman', '1', '1', 'Donna quarantenne', 'A forty-year-old woman', 'رجل في الثلاثين من عمره', '', '', '', '', 1113, ''),
('fifty_years_old_man', '1', '1', 'Uomo cinquantenne', 'A fifty-year-old man', 'رجل في الثلاثين من عمره', '', '', '', '', 1114, ''),
('title', '0', '1', 'Titolo', 'Title', 'Title(ar)', '', '', '', '', 1116, ''),
('description', '1', '1', 'Descrizione', 'Description', 'DescriptionAR', '', '', '', '', 1118, ''),
('scenario', '0', '1', 'Scenario', 'Scenario', '', '', '', '', '', 1119, ''),
('states', '0', '1', 'Stati', 'States', 'StatesAR', '', '', '', '', 1120, ''),
('sentences_groups', '0', '1', 'Gruppi di frasi', 'Groups of sentencs', 'Sentences GroupsAR', '', '', '', '', 1121, ''),
('select', '0', '1', 'Seleziona', 'Select', 'SelectAR', '', '', '', '', 1122, ''),
('will_you_use_audio', '0', '1', 'Vuoi usare audio?', 'Will you use audio?', 'سوف تستخدم الصوت؟', '', '', '', '', 1123, ''),
('user_avatar', '0', '1', 'Avatar dell\'Utente', 'User\'s avatar', 'User s avatarAR', '', '', '', '', 1124, ''),
('user_avatar_name', '0', '1', 'Nome dell\'avatar Utente', 'User\'s avatar’s name', 'User\'s avatar nameAR', '', '', '', '', 1125, ''),
('user_avatar_description', '0', '1', 'Descrizione dell\'avatar Utente', 'User\'s avatar’s description', 'User\'s avatar descriptionAR', '', '', '', '', 1126, ''),
('user_goal', '0', '1', 'Obiettivo dell\'utente', 'User\'s goal', 'User s goalAR', '', '', '', '', 1127, ''),
('bot_avatar', '0', '1', 'Avatar del Bot', 'Bot\'s Avatar', 'Bot s AvatarAR', '', '', '', '', 1128, ''),
('bot_avatar_name', '0', '1', 'Nome dell\'avatar Bot', 'Bot\'s avatar’s name', 'Bot s avatar nameAR', '', '', '', '', 1129, ''),
('bot_avatar_description', '0', '1', 'Descrizione dell\'avatar del Bot', 'Bot\'s avatar’s description', 'Bot s avatar descriptionAR', '', '', '', '', 1130, ''),
('bot_goal', '0', '1', 'Obiettivo del Bot', 'Bot\'s goal', 'Bot s goal', '', '', '', '', 1131, ''),
('my_matches', '1', '0', 'I miei match', 'My Matches', 'مبارياتي', '', '', '', '', 1132, ''),
('more_matches', '1', '0', 'Altri Match', 'More Matches', 'المزيد من المباريات', '', '', '', '', 1133, ''),
('more_drafts', '1', '0', 'Altre Bozze', 'More Drafts', 'المزيد من المسودات', '', '', '', '', 1135, ''),
('NO_RESULTS_MATCHES', '1', '0', 'Non hai ancora avuto nessun match... <br/>\r\nComincia subito: clicca su uno dei game qui sopra!', 'you have no matches yet...<br/> Start now: click on a Game above ', '', '', '', '', '', 1136, ''),
('the_first_three_answers_are_mandatory', '0', '1', 'Le prime tre risposte sono obbligatorie', 'The first three answers are mandatory', '', '', '', '', '', 1585, ''),
('NO_RESULTS_DRAFTS', '1', '0', 'La cartella bozze è vuota', 'The draft box is empty\n', '', '', '', '', '', 1137, ''),
('last_match', '1', '0', 'Ultimo Match', 'Last Match', 'المبارة الاخيرة', '', '', '', '', 1138, ''),
('N_months_ago', '1', '0', 'mesi fa', 'months ago', 'قبل أشهر', '', '', '', '', 1139, ''),
('N_days_ago', '1', '0', 'giorni fa', 'days ago', 'قبل أشهر', '', '', '', '', 1140, ''),
('N_hours_ago', '1', '0', 'ore fa', 'hours ago', 'قبل أشهر', '', '', '', '', 1141, ''),
('N_years_ago', '1', '0', 'anni fa', 'years ago', 'قبل أشهر', '', '', '', '', 1142, ''),
('N_weeks_ago', '1', '0', 'settimane fa', 'weeks ago', 'قبل أشهر', '', '', '', '', 1143, ''),
('N_minutes_ago', '1', '0', 'minuti fa', 'minutes ago', 'قبل أشهر', '', '', '', '', 1144, ''),
('N_seconds_ago', '1', '0', 'secondi fa', 'seconds ago', 'قبل أشهر', '', '', '', '', 1145, ''),
('show_report', '1', '0', 'Mostra Report', 'Show Report', 'عرض تقرير', '', '', '', '', 1146, ''),
('play_ESCLAMATIVE', '1', '0', 'Gioca!', 'Play now!', 'العب الان!', '', '', '', '', 1147, ''),
('edit', '1', '0', 'Modifica', 'Edit', 'تعديل', 'cambiar', '', 'modifier', 'mudar', 1148, ''),
('offline', '1', '0', 'Offline', 'Offline', 'غير متصل', 'Desconectado', '', '', '', 1150, ''),
('beginner', '1', '0', 'Beginner', 'Beginner', 'مبتدئ', '', '', '', '', 1152, ''),
('cover', '0', '1', 'Copertina', 'Cover', 'صورة الغلاف', '', '', '', '', 1153, ''),
('please_select_the_avatars', '0', '1', 'Per favore seleziona i due avatar', 'Please, select the two avatars', 'رجاءا، اختر الآلهة', '', '', '', '', 1154, ''),
('the_user_character', '0', '1', 'Il personaggio dello User', 'the User character', 'شخصية المستخدم', '', '', '', '', 1155, ''),
('the_bot_character', '0', '1', 'Il personaggio del Bot', 'The Bot character', 'الطابع بوت', '', '', '', '', 1156, ''),
('sorry_the_following_fields_marked_in_red_are_not_correct', '0', '1', 'Mi spiace ma i seguenti campi - evidenziati in rosso - non sembrano corretti', 'Sorry, the following fields - marked in red - are not correct', 'عذرا، الحقول التالية - باللون الأحمر - غير صحيحة', '', '', '', '', 1157, ''),
('click_on_a_cover_to_select', '0', '1', 'fai click su una copertina per selezionarla', 'Click on a cover to select it', 'انقر على غلاف لتحديده', '', '', '', '', 1158, ''),
('optional_information', '0', '1', 'Informazioni facoltative', 'Optional Information', 'Optional Information', '', '', '', '', 1159, ''),
('estimated_duration', '1', '1', 'Durata Stimata', 'Estimated Duration', 'Estimated Duration', '', '', '', '', 1160, ''),
('competence_target', '1', '1', 'Obiettivo competenza', 'Competence Target', 'Competence Target', '', '', '', '', 1161, ''),
('difficulty_level', '1', '1', 'Livello di Difficoltà', 'Difficulty Level', 'Difficulty Level', '', '', '', '', 1162, ''),
('sign_up_for_free', '1', '0', 'Iscriviti', 'Sign up', '', '', '', '', '', 1163, ''),
('new_password', '1', '1', 'Nuova Password', 'New Password', '', '', '', '', '', 1164, ''),
('SIGN_UP_DISCLAIMER', '1', '0', 'Cliccando su Iscriviti, accetti le nostre Condizioni e confermi di aver letto <a  target=\"_BLANK\" href=\"/informativa.pdf\">la nostra Normativa sui dati</a>, e sull\\\'uso dei cookie', 'By clicking Sign Up, you agree to our Terms and confirm that you have read <a href=\"/informativa .pdf\" target=\"_BLANK\">our Data Policy</a>, including our Cookie Use.', '', '', '', '', '', 1166, ''),
('EMAIL_ACCOUNT_CONFIRM_SUBJECT', '1', '0', 'Azione richiesta: conferma il tuo account PAL.MA.', 'Action required: confirm your PAL.MA. account', '', 'Acción requerida: Confirmar cuenta de PAL.MA.', '', 'Action demandée: confirmer votre compte PAL.MA.', 'Ação necessária: Confirme sua conta PAL.MA.', 1391, ''),
('EMAIL_ACCOUNT_CONFIRM_BODY', '1', '0', 'Ciao #!name!#,\n\nRecentemente ti sei iscritto/a a PAL.MA. \n\nPer completare l\'iscrizione, segui questo link:\n#!url!#\n\nGrazie,\nPal.Ma. Team\nhttps://palma.entropy4fad.it', 'Ciao #!name!#,   You\'ve recently signed up to AL.MA.   Follow this link to complete your registration: #!url!#  Thanks The Team of Pal.Ma.  https://palma.entropy4fad.it', '', 'Hola #!name!#,\n\nRecientemente se ha inscrito en PAL.MA.\n\nPara completar la inscripción, siga este enlace:\n\n#!url!#\n\nGracias,\nEl equipo de Pal.Ma. \nhttps://palma.entropy4fad.it', '', 'Salut #!name!#,\n\nRécemment vous vous êtes inscrit(e) à PAL.MA. \n\nPour compléter l\'inscrition, suivez ce lien:\n#!url!#\nMerci,\nLe team de Pal.Ma. \nhttps://palma.entropy4fad.it', 'Olá #!name!#,\n\nRecentemente, se inscreveu en PAL.MA.\n\nPara concluir a inscrição, siga este link:\n\n#!url!#\n\nObrigado,\nA equipe Pal.Ma. Team\nhttps://palma.entropy4fad.it', 1392, ''),
('EMAIL_ACCOUNT_CONFIRM_REMINDER_SUBJECT', '1', '0', 'Per #!name!# da Pal.Ma.', 'To #!name!# from PAL.MA.', '', 'Para #!name!# desde PAL.MA.', '', 'Pour #!name!# de PAL.MA.', 'Para #!name!# do PAL.MA.', 1398, ''),
('EMAIL_ACCOUNT_CONFIRM_REMINDER_BODY', '1', '0', 'Ciao #!name!#,\nScusa se ti disturbiamo ma abbiamo notato che nonostante ti sia iscritto non hai ancora confermato il tuo indirizzo email. \n\nPer farlo basta cliccare questo link:\n#!url!#\n\nPer qualunque altro problema non esitare.\n\nPal.Ma. Team\nhttps://palma.entropy4fad.it', 'Ciao #!name!#, sorry to disturb you, but we have noticed you have not validated your email address yet.  Just click this link to complete your registration: #!url!#  For any problems please don\'t hesitate to contact us.  Pal.Ma. Team https://palma.entropy4fad.it', '', 'Hola #!name!#,\nSoy Corinne de AL.MA.\nPerdona que te moleste,\npero hemos notado que todavía no se ha activado su cuenta\nPara completar la inscripción, siga este enlace:\n#!url!#\no puedo hacerlo manualmente Si responde a este mensaje.\n\nBuen día \nEl equipo de \nPal.Ma. Team\nhttps://palma.entropy4fad.it', '', 'Salut #!name!#,\nDésolé de vous déranger,\n\nrécemment vous vous êtes inscrit(e) à AL.MA. Pour compléter l\'inscrition, suivez ce lien:\n#!url!#\nMerci,\nLe team de Pal.Ma.\nhttps://palma.entropy4fad.it', 'Olá #!name!#,\nSou Corinne de AL.MA.\nnotamos que você não ativou sua conta ainda\n\nPara concluir a inscrição, siga este link:\n#!url!#\nou eu posso fazê-lo manualmente se você responder a este e-mail\n\nTenha um bom dia \nA equipe Pal.Ma.\nhttps://palma.entropy4fad.it', 1399, 'Altrimenti posso farlo io manualmente se rispondi a questa email.  or i can do this manually if you reply to this mail.'),
('your_email_has_already_been_verified', '1', '0', 'La tua email è stata già verificata', 'Your email has already been verified', '', '', '', '', '', 1419, ''),
('your_email_has_been_verified', '1', '0', 'La tua email è stata verificata', 'Your email has been verified', '', '', '', '', '', 1420, ''),
('email_confirmation', '1', '0', 'Conferma email', 'Email Confirmation', '', '', '', '', '', 1421, ''),
('thanks', '1', '0', 'Grazie', 'Thanks', '', '', '', '', '', 1422, ''),
('insert_your_email_and_password_to_login', '1', '1', 'Inserisci email e password per accedere', 'Insert your email and password to log in', '', '', '', '', '', 1423, ''),
('please_confirm_your_email_by_clicking_on_the_link_we_sent_you', '1', '0', 'Per favore, conferma la tua email facendo click sul link che ti abbiamo inviato', 'Please, confirm your email address by clicking on the link we sent you', '', '', '', '', '', 1424, ''),
('send_me_the_email_again', '1', '0', 'Inviami nuovamente l\'email', 'Send me the email again', '', '', '', '', '', 1426, ''),
('SIGN_UP_OK_MESSAGE', '1', '0', 'Bene #user,<br />\nabbiamo appena inviato una email a #email<br /><br />\nClicca sul link che trovi nel messaggio per confermare il tuo indirizzo email.<br /><br />\nSe non trovi il messaggio non dimenticare di cercare nello spam.', 'Bene #user,<br />\nWe have just sent an email to #email<br /><br />\nClick the confirmation link that you will find in the message to confirm your email address.<br /><br />\nIf you don’t find the message, don’t forget to check the spam folder', '', '', '', '', '', 1425, 'manca'),
('EMAIL_CONFIRMATION_CODE_ERROR', '1', '0', 'Ci Spiace ma il codice (#code) non sembra corretto.<br /><br />\nFai click nuovamente sul link contenuto nell\'email e controlla anche nello spam<br ><br >\nOppure entra con email e password e poi scegli \'#L_send_me_the_email_again\'', 'We are sorry, but the code (#code) is incorrect.<br /><br />\nClick the link again and check the spam folder<br ><br >\nor login with your email and password and then choose \'#L_send_me_the_email_again\'', '', '', '', '', '', 1427, 'manca'),
('usersX', '1', '1', 'Utenti', 'Users', '', '', '', '', '', 1429, ''),
('group_name', '1', '1', 'Nome del Gruppo', 'Group\'s Name', '', '', '', '', '', 1430, ''),
('groups', '1', '1', 'Gruppi', 'Groups', '', '', '', '', '', 1431, ''),
('nothing_yet', '1', '1', 'Ancora nulla', 'Nothing yet', '', '', '', '', '', 1432, ''),
('new_group', '0', '1', 'Nuovo Gruppo', 'New Group', '', '', '', '', '', 1433, ''),
('edit_group', '0', '1', 'Modifica Gruppo', 'Edit Group', '', '', '', '', '', 1434, ''),
('no_results', '1', '1', 'Nessun risultato', 'No results', '', 'Resultados mostrados', '', 'Résultats vus', 'Resultados exibidos', 1435, ''),
('the_groups_name_is_too_short', '0', '1', 'Il titolo è troppo breve', 'the Group\'s Name is too short', '', 'El título es demasiado corto', '', 'Le titre est trop bref', 'O título é demasiado curto', 1437, ''),
('delete_this_group', '0', '1', 'Cancella questo gruppo', 'Delete this group', '', '', '', '', '', 1438, ''),
('saved', '0', '1', 'Salvato', 'Saved', '', '', '', '', '', 1439, ''),
('user_edit', '0', '1', 'Modifica Utente', 'Edit User', '', '', '', '', '', 1442, ''),
('role', '1', '1', 'Ruolo', 'Role', '', '', '', '', '', 1443, ''),
('moderator', '1', '1', 'Moderatore', 'Moderator', '', '', '', '', '', 1444, ''),
('super_user', '1', '1', 'Super User', 'Super User', '', '', '', '', '', 1445, ''),
('add_groups', '0', '1', 'Aggiungi Gruppi', 'Add Groups', '', '', '', '', '', 1446, ''),
('activity', '1', '1', 'Attività', 'Activity', '', '', '', '', '', 1447, ''),
('duration', '1', '1', 'Durata', 'Duration', 'Duration(ar)', '', '', '', '', 1448, ''),
('date_time', '1', '1', 'Data/Ora', 'Date/Time', 'Date/Time', '', '', '', '', 1449, ''),
('add_insighters', '0', '1', 'Aggiungi Insighters', 'Add Insighters', '', '', '', '', '', 1450, ''),
('insighters', '0', '1', 'Insighters', 'Insighters', '', '', '', '', '', 1451, ''),
('insights', '1', '1', 'Insights', 'Insights', '', '', '', '', '', 1452, ''),
('actually_you_have_no_permission_to_access_this_area', '1', '1', 'Al momento non hai alcun permesso per accedere a quest\'area', 'At the moment you have no permission to access this area', '', '', '', '', '', 1453, ''),
('this_week', '1', '0', 'Questa settimana', 'This week', '', '', '', '', '', 1454, ''),
('last_week', '1', '0', 'La scorsa settimana', 'Last week', '', '', '', '', '', 1455, ''),
('NUMBER_weeks_ago', '1', '0', 'settimane fa', 'weeks ago', '', '', '', '', '', 1456, ''),
('NUMBER_months_ago', '1', '0', 'mesi fa', 'months ago', '', '', '', '', '', 1457, ''),
('NUMBER_days_ago', '1', '0', 'giorni fa', 'days ago', '', '', '', '', '', 1458, ''),
('this_month', '1', '0', 'Questo mese', 'This month', '', '', '', '', '', 1459, ''),
('last_month', '1', '0', 'Il mese scorso', 'last month', '', '', '', '', '', 1460, ''),
('custom_period', '1', '0', 'Periodo personalizzato', 'Customized period', '', '', '', '', '', 1462, ''),
('generate', '1', '0', 'Genera', 'Generate', '', '', '', '', '', 1463, ''),
('all', '1', '0', 'Tutti', 'All', '', 'Todos', '', 'Tous', 'Todos', 1464, ''),
('none', '1', '0', 'Nessuno', 'None', '', '', '', '', '', 1465, ''),
('matches', '1', '0', 'Matches', 'Matches', '', '', '', '', '', 1466, ''),
('unique_players', '1', '0', 'Giocatori unici', 'Unique players', '', '', '', '', '', 1467, ''),
('players', '1', '0', 'Players', 'Players', '', '', '', '', '', 1468, ''),
('player', '1', '0', 'Player', 'Player', '', '', '', '', '', 1469, ''),
('durations_are_expressed_in_minutes', '1', '0', 'Le durate sono espresse in Minuti', 'Duration is expressed in minutes', '', '', '', '', '', 1470, ''),
('details', '1', '0', 'Dettagli', 'Details', '', '', '', '', '', 1472, ''),
('status', '1', '0', 'Status', 'Status', '', '', '', '', '', 1473, ''),
('history', '1', '0', 'History', 'History', '', '', '', '', '', 1475, ''),
('change_status', '1', '0', 'Cambio stato', 'Status Change', '', '', '', '', '', 1476, ''),
('options', '1', '0', 'Opzioni', 'Options', '', '', '', '', '', 1477, ''),
('anonymous', '1', '0', 'Anonimo', 'Anonymous', '', '', '', '', '', 1478, ''),
('TIME_ago_post', '1', '1', 'fa', 'ago', '', '', '', '', '', 1479, ''),
('TIME_ago_pre', '0', '0', '', '', '', '', '', '', '', 1480, ''),
('TIME_at', '0', '0', 'alle', 'at', '', '', '', '', '', 1481, ''),
('days', '1', '0', 'giorni', 'days', '', '', '', '', '', 1482, ''),
('hours', '1', '0', 'ore', 'hours', '', '', '', '', '', 1483, ''),
('seconds', '1', '0', 'secondi', 'seconds', '', '', '', '', '', 1484, ''),
('years', '1', '0', 'anni', 'years', '', '', '', '', '', 1485, ''),
('months', '1', '0', 'mesi', 'months', '', '', '', '', '', 1486, ''),
('language', '1', '0', 'Lingua', 'Language', 'لغة', 'Idioma', 'Language', '', '', 21, ''),
('a_months_ago', '1', '0', 'un mese fa', 'a month ago', '', '', '', '', '', 1488, ''),
('minutes', '1', '0', 'minuti', 'minutes', '', '', '', '', '', 1489, ''),
('yesterday', '1', '0', 'ieri', 'yesterday', '', '', '', '', '', 1490, ''),
('the_games', '1', '0', 'i Games', 'The Games', '', '', '', '', '', 1491, ''),
('the_game', '1', '0', 'il Game', 'the Game', '', '', '', '', '', 1492, ''),
('create_a_new_game', '1', '1', 'Crea un nuovo Game', 'Create a new Game', '', '', '', '', '', 1493, ''),
('add_game_goal', '0', '1', 'Aggiungi scopo al game', 'Add Game Goal', '', '', '', '', '', 1494, ''),
('game_debriefing', '1', '1', 'Debriefing Game', 'Game Debriefing', '', '', '', '', '', 1495, ''),
('save_the_game_as_playable', '0', '1', 'Salva il Game come PLAYABLE', 'Save the Game as PLAYABLE', '', '', '', '', '', 1496, ''),
('ALERT_GAME_SAVED_AS_PLAYABLE', '1', '1', 'Il Game è stato salvato come PLAYABLE ed è ora disponibile per il gioco se inserito in uno o più gruppi', 'The Game has been saved as PLAYABLE and it\'s now available to play if added to groups', '', '', '', '', '', 1497, ''),
('ALERT_GAME_COPIED', '1', '1', 'E\' stata creata una copia del Game disponibile nelle Bozze', 'The copy of the Game is now available in Drafts', '', '', '', '', '', 1498, ''),
('game_goal', '0', '1', 'Scopo del Game', 'Game goal', '', '', '', '', '', 1510, ''),
('more_games', '1', '0', 'Altri Games', 'More Games', '', '', '', '', '', 1511, ''),
('ALERT_GAME_SETTED_OFF', '1', '0', 'Il Game è ora \'offline\' quindi non disponibile per il gioco', 'The Game is now offline; therefore, it is so not visible nor playable', '', '', '', '', '', 1512, ''),
('more_offline_games', '1', '0', 'Altri game offline', 'More offline games', '', '', '', '', '', 1513, ''),
('never_been_in_a_game', '1', '0', 'Mai stato in un serious Game?', 'Never been in a serious Game?', '', '', '', '', '', 1514, '');
INSERT INTO `plang` (`name`, `usr`, `edt`, `it`, `en`, `ar`, `es`, `de`, `fr`, `pt`, `id`, `note`) VALUES
('games', '1', '1', 'Games', 'Games', '', '', '', '', '', 1515, ''),
('add_games_and_users', '0', '1', 'Aggiungi Game e Utenti', 'Add Games and Users', '', '', '', '', '', 1516, ''),
('game', '1', '1', 'Game', 'Game', '', '', '', '', '', 1517, ''),
('games_without_group', '1', '0', 'Games senza gruppo', 'Games without group', '', '', '', '', '', 1518, ''),
('valid_until', '1', '1', 'Valido fino al', 'Valid until', '', '', '', '', '', 1519, ''),
('masculine_avatar', '0', '1', 'Avatar Maschile', 'Masculine Avatar', '', '', '', '', '', 1520, ''),
('feminine_avatar', '0', '1', 'Avatar femminile', 'Feminine avatar', '', '', '', '', '', 1521, ''),
('forever', '0', '1', 'per sempre', 'forever', '', '', '', '', '', 1522, ''),
('editing', '0', '1', 'Editing', 'Editing', '', '', '', '', '', 1523, ''),
('avatar', '1', '1', 'Avatar', 'Avatar', '', 'Avatar', '', '', '', 1524, ''),
('avatar_position', '0', '1', 'Posizione Avatar', 'Avatar\'s Position', '', '', '', '', '', 1525, ''),
('camera_on_protagonist_only', '0', '1', 'Inquadratura solo sul protagonista', 'Camera on protagonist only', '', '', '', '', '', 1526, ''),
('answer', '1', '1', 'Risposta', 'Answer', '', '', '', '', '', 1527, ''),
('score', '1', '1', 'Punteggio', 'Score', '', '', '', '', '', 1528, ''),
('avatar_sentence', '0', '1', 'Battuta dell\'Avatar', 'Avatar\'s sentence', '', '', '', '', '', 1529, ''),
('select_scenario', '0', '1', 'Seleziona Scenario', 'Select Scenario', '', '', '', '', '', 1530, ''),
('select_avatar', '0', '1', 'Seleziona Avatar', 'Select Avatar', '', '', '', '', '', 1531, ''),
('avatar_size', '0', '1', 'Taglia Avatar', 'Avatar\'s Size', '', '', '', '', '', 1532, ''),
('drag_to_reposition', '0', '1', 'Trascina per riposizionare', 'Drag to reposition', '', '', '', '', '', 1533, ''),
('upload', '0', '1', 'Carica', 'Upload', '', '', '', '', '', 1534, ''),
('feminine', '0', '1', 'Femminile', 'Feminine', '', '', '', '', '', 1535, ''),
('masculine', '0', '1', 'Maschile', 'Masculine', '', '', '', '', '', 1536, ''),
('steps', '1', '1', 'Step', 'Step', '', '', '', '', '', 1537, ''),
('saving', '1', '1', 'Sto salvando', 'Saving', '', '', '', '', '', 1538, ''),
('add_an_answer', '0', '1', 'Aggiungi una risposta', 'Add an answer', '', '', '', '', '', 1539, ''),
('players_answers', '0', '1', 'Risposte del giocatore', 'Player\'s Answers', '', '', '', '', '', 1540, ''),
('attachments', '1', '1', 'Allegati', 'Attachments', '', '', '', '', '', 1541, ''),
('file', '1', '1', 'File', 'File', '', '', '', '', '', 1542, ''),
('youtube_video', '1', '1', 'Video Youtube', 'Youtube Video', '', '', '', '', '', 1543, ''),
('link', '1', '1', 'Link', 'Link', '', '', '', '', '', 1544, ''),
('load', '1', '1', 'Carica', 'Load', '', '', '', '', '', 1545, ''),
('add_url', '1', '1', 'Aggiungi URL', 'Add URL', '', '', '', '', '', 1546, ''),
('this_type_of_file_is_not_acceptable', '0', '1', 'Questo tipo di file non è accettato', 'this type of file is not_supported', '', '', '', '', '', 1547, ''),
('the_url_does_not_seem_to_be_correct', '1', '1', 'L\'url non sembra essere corretta', 'The url does not seem to be correct', '', '', '', '', '', 1548, ''),
('COMPULSORY_ATTACHMENTS_YES', '0', '1', 'Il player DEVE cliccare su ognuno degli allegati per poter proseguire e scegliere una risposta', 'The player MUST click on each attachment to go on playing and pick an answer', '', '', '', '', '', 1549, ''),
('change', '0', '1', 'Cambia', 'Change', '', '', '', '', '', 1550, ''),
('COMPULSORY_ATTACHMENTS_NO', '0', '1', 'Il player può continuare il gioco anche se non ha cliccato su alcun allegato', 'The player can go on playing even if he didn\'t click on attachment links', '', '', '', '', '', 1551, ''),
('avatar_sentence_audio', '0', '1', 'Audio della frase dell\'avatar', 'audio of the Avatar\'s sentence', '', '', '', '', '', 1554, ''),
('you_cannot_use_question_4_without_using_question_3', '0', '1', 'La domanda 4 non può essere usata se prima non si utilizza la domanda 3', 'You cannot use question 4 without first using question 3', '', '', '', '', '', 1556, ''),
('questions_score', '0', '1', 'punteggio della domanda', 'question\'s score', '', '', '', '', '', 1557, ''),
('answers_have_the_same_score', '0', '1', 'Le risposte hanno tutte lo stesso punteggio', 'All answers have the same score', '', '', '', '', '', 1558, ''),
('endings', '0', '1', 'Finali', 'Endings', '', '', '', '', '', 1559, ''),
('winning_end', '0', '1', 'Finale vincente', 'Winning end', '', '', '', '', '', 1560, ''),
('loosing_end', '0', '1', 'Finale perdente', 'Losing end', '', '', '', '', '', 1561, ''),
('loosing_area', '0', '1', 'Area perdente', 'Losing area', '', '', '', '', '', 1562, ''),
('winning_area', '0', '1', 'Area vincente', 'Winning area', '', '', '', '', '', 1563, ''),
('not_available_yet', '1', '1', 'Non ancora disponibile', 'Not available yet', '', '', '', '', 'Indisponível', 1564, ''),
('final_sentence', '1', '1', 'Frase finale', 'Final sentence', '', '', '', '', '', 1565, ''),
('final_sentence_audio', '1', '1', 'Audio della frase finale', 'Audio of the final sentence', '', '', '', '', '', 1566, ''),
('comment', '1', '1', 'Commento', 'Comment', '', '', '', '', '', 1567, ''),
('qualitative_comments', '1', '1', 'Commenti qualitativi', 'Qualitative comments', '', '', '', '', '', 1568, ''),
('no_avatar', '0', '1', 'Nessun avatar', 'No avatar', '', '', '', '', '', 1569, ''),
('sentence', '0', '1', 'Frase', 'Sentence', '', '', '', '', '', 1570, ''),
('DIALOGUES_BOX_LOG_INTRO', '1', '0', 'Qui troverai tutti gli scambi effettuati durante il dialogo tra te e gli avatar', 'Here you will find all the dialogue exchanges between you and the avatars', '', '', '', '', '', 1571, ''),
('thinking_over', '1', '0', 'Rifletto', 'Thinking over', '', '', '', '', '', 1572, ''),
('please_take_a_look_at_the_following_attachments_before_answering', '1', '0', 'Si consiglia di visionare gli allegati prima di rispondere', 'Please, take a look at the attachments before answering', '', '', '', '', '', 1573, ''),
('you_cant_answer_before_reading_the_following_attachments', '1', '0', 'Visiona gli allegati per continuare il gioco', 'Read the attachments to continue the game', '', '', '', '', '', 1574, ''),
('show', '1', '1', 'Mostra', 'Show', '', '', '', '', '', 1575, ''),
('L1_SHORT_COMMENT', '1', '1', 'Purtroppo è andata decisiamente male', 'Unfortunately, you did fail', '', '', '', '', '', 1576, ''),
('L2_SHORT_COMMENT', '1', '1', 'E\' andata male, ma c\'e\' di peggio', 'You failed! But it is not that bad', '', '', '', '', '', 1577, ''),
('L3_SHORT_COMMENT', '1', '1', 'E\' andata maluccio', 'It didn’t go well!', '', '', '', '', '', 1578, ''),
('L4_SHORT_COMMENT', '1', '1', 'Non hai vinto, ma c\'eri quasi', 'You were almost there', '', '', '', '', '', 1579, ''),
('W1_SHORT_COMMENT', '1', '1', 'Hai vinto. Per un pelo ma hai vinto', 'You barely made it', '', '', '', '', '', 1580, ''),
('W2_SHORT_COMMENT', '1', '1', 'Hai vinto, un buon risultato ma puoi dare di più', 'Hey you got a good score, but you can improve!', '', '', '', '', '', 1581, ''),
('W3_SHORT_COMMENT', '1', '1', 'Benissimo, manca poco all\'eccellenza', 'Very well, almost excellent. Try again', '', '', '', '', '', 1582, ''),
('W4_SHORT_COMMENT', '1', '1', 'Un risultato eccellente, complimenti', 'Great, you totally rocked!', '', '', '', '', '', 1583, ''),
('the_scale_of_values_varies_from_0_to_100_percent', '1', '0', 'La scala di valori varia da 0% a 100%', 'Scores range from 0 to 100%', '', '', '', '', '', 1584, ''),
('at_least_one_score_must_be_zero', '0', '1', 'Almeno un punteggio deve essere pari a zero', 'At least one score must be zero', '', '', '', '', '', 1586, ''),
('structure', '0', '1', 'Struttura', 'Structure', '', '', '', '', '', 1587, ''),
('sequential', '0', '1', 'Sequenziale', 'Sequential', '', '', '', '', '', 1588, ''),
('parallel', '0', '1', 'Parallela', 'Parallel', '', '', '', '', '', 1589, ''),
('forkFrom', '0', '1', 'Biforca da', 'Fork off from', '', '', '', '', '', 1590, ''),
('story_structure', '0', '1', 'struttura della storia', 'Story structure', '', '', '', '', '', 1591, ''),
('goto', '0', '1', 'vai a', 'Go to', '', '', '', '', '', 1592, ''),
('administrator', '1', '1', 'Administrator', 'Administrator', '', '', '', '', '', 1593, ''),
('create_the_first_group', '1', '0', 'Crea il primo gruppo', 'Create the first group', '', '', '', '', '', 1594, ''),
('admin', '1', '0', 'Admin', 'Admin', '', '', '', '', '', 1595, ''),
('STATUS_LEGENDA_HTML', '1', '0', '&bull; <span>Draft:</span> Il game è visibile solo agli editor, non è quindi online per gli utenti<br />&bull; <span>Playable:</span> Il game è disponibile online ai giocatori in funzione dei gruppi<br />&bull; <span>Offline:</span> Il game non è, o non è più, disponibile agli utenti<br />&bull; <span>Deleted:</span> Il game è off line e inoltre, non è visibile negli insights', '&bull; <span>Draft:</span> Users can not play the Game, it\'s a draft<br />&bull; <span>Playable:</span> Users, as per groups, can play the Game<br />&bull; <span>Offline:</span> the Game is not, or not anymomore, available to users<br />&bull; <span>Deleted:</span> the Game is off line and it\'s not visible in the insights section', '', '', '', '', '', 1596, ''),
('DO_YOU_REALLY_WANT_TO_DELETE_THIS_STEP', '0', '1', 'Vuoi davvero cancellare questo step?', 'Do you really want to delete this step?', '', '', '', '', '', 1599, ''),
('DO_YOU_REALLY_WANT_TO_DELETE_THIS_SCENE', '0', '1', 'Vuoi davvero cancellare questa scena?', 'Do you really want to delete this scene?', '', '', '', '', '', 1598, ''),
('remove_the_step', '0', '1', 'Rimuovi lo step', 'Remove the step', '', '', '', '', '', 1600, ''),
('add_the_step', '0', '1', 'Aggiungi lo step', 'Add the step', '', '', '', '', '', 1601, ''),
('missing_one_or_more_answers', '0', '1', 'Manca il testo di una o più risposte', 'Missing one or more answers', '', '', '', '', '', 1602, ''),
('no_answer_leads_to_this_scene', '0', '1', 'Nessuna risposta punta a questa scena', 'No answer leads to this scene', '', '', '', '', '', 1603, ''),
('the_score_of_one_or_more_answers_is_missing', '0', '1', 'Manca il punteggio di una o più risposte', 'The score of one or more answers is missing', '', '', '', '', '', 1604, ''),
('remove_last_answer', '0', '1', 'Rimuovi l\'ultima risposta', 'Remove the last answer', '', '', '', '', '', 1605, ''),
('a_year_ago', '0', '1', 'Un annetto fa', 'A year ago', '', '', '', '', '', 1611, ''),
('in_a_year', '0', '1', 'Tra un annetto', 'In a year', '', '', '', '', '', 1612, ''),
('by', '0', '1', 'di', 'by', '', '', '', '', '', 1613, ''),
('created_by', '0', '1', 'creato da', 'created by', '', '', '', '', '', 1614, ''),
('te', '0', '1', 'te', 'you', '', '', '', '', '', 1615, ''),
('use_this_scenario_in', '0', '1', 'Usa questo scenario in', 'Use this scenario in', '', '', '', '', '', 1616, ''),
('scenarios', '0', '1', 'Scenari', 'Scenarios', '', '', '', '', '', 1617, ''),
('currently_used_in_the_game', '0', '1', 'Attualmente utilizzato nel game', 'Currently used in the game', '', '', '', '', '', 1618, ''),
('back_to_editor', '0', '1', 'Torna all\'editor', 'Back to editor', '', '', '', '', '', 1619, ''),
('recently_used_PLURAL', '0', '1', 'Usati di recente', 'Recently used', '', '', '', '', '', 1620, ''),
('my_scenarios', '0', '1', 'I miei scenari', 'My scenarios', '', '', '', '', '', 1621, ''),
('make_it_public', '0', '1', 'Rendilo pubblico', 'Make it public', '', '', '', '', '', 1622, ''),
('done', '0', '1', 'Fatto', 'Done', '', '', '', '', '', 1623, ''),
('the_minimum_pixel_size_is', '0', '1', 'le dimensioni minime richieste in pixel sono', 'the minimum pixel size is', '', '', '', '', '', 1624, ''),
('uploaded_image_size', '0', '1', 'Dimensioni dell\'immagine caricata', 'Uploaded image size', '', '', '', '', '', 1625, ''),
('drag_and_resize_the_highlighted_area', '0', '1', 'Trascina e ridimensiona la zona evidenziata', 'Drag and resize the highlighted area', '', '', '', '', '', 1626, ''),
('scenarios_name', '0', '1', 'Nome dello scenario', 'Scenario\'s Name', '', '', '', '', '', 1627, ''),
('it_can_be_used_by_all_editors', '0', '1', 'Potrà essere utilizzato da tutti gli editors', 'it can be used by all editors', '', '', '', '', '', 1628, ''),
('public', '0', '1', 'Pubblico', 'Public', '', '', '', '', '', 1629, ''),
('private', '0', '1', 'Privato', 'Private', '', '', '', '', '', 1630, ''),
('now', '1', '1', 'poco fa', 'just now', '', '', '', '', '', 1631, ''),
('a_minute_ago', '1', '1', 'un minuto fa', 'un minuto fa', '', '', '', '', '', 1632, ''),
('waiting_to_go_public', '0', '1', 'in attesa di divenire pubblico', 'waiting to go public', '', '', '', '', '', 1633, ''),
('are_you_sure_to_delete_this', '1', '1', 'Sei sicuro di voler cancellare questo elemento?', 'Are you sure to delete this?', 'هل أنت واثق؟', '¿Está seguro?', '', 'êtes-vous sûrs?', 'Tem certeza?', 1634, ''),
('non_binary', '0', '1', 'Non binario', 'Non binary', '', '', '', '', '', 1635, ''),
('the_file_size_is_too_large', '0', '1', 'Il file è troppo pesante', 'The file size is too large', '', '', '', '', '', 1636, ''),
('upload_your_avatar', '0', '1', 'Carica il tuo avatar', 'Upload your avatar', '', '', '', '', '', 1637, ''),
('add_feedback', '1', '1', 'Aggiungi feedback', 'Add feedback', '', '', '', '', '', 1638, ''),
('remove_feedback', '0', '1', 'rimuovi feedback', 'Remove feedback', '', '', '', '', '', 1639, ''),
('feedback_after_answer_N', '0', '1', 'Feedback dopo la risposta', 'Feedback dopo la risposta', '', '', '', '', '', 1640, ''),
('EDITOR_0_COVER_CAPTION', '0', '1', 'L\'immagine di copertina si aggiorna automaticamente utilizzando lo scenario e l\'avatar della prima scena (1A) del gioco. Ti basta quindi modificare questi due elementi per cambiarla.', 'The cover image is automatically updated using the scenario and avatar from the first scene (1A) of the game. You just need to edit these two elements to change it.', '', '', '', '', '', 1641, ''),
('CHOICE_VOICE_TEXT', '0', '1', 'Nel Match Movie vuoi che la tua voce sia maschile o femminile?<small>Le voci non binary non sono ancora disponibili</small>', 'In the Match Movie do you want your voice to be male or female?<small>Non-binary voices are not yet available</small>', '', '', '', '', '', 1642, ''),
('balloon_fonts', '0', '0', 'Caratteri del fumetto', 'Balloon fonts', '', '', '', '', '', 1643, ''),
('BALLOON_FONT_TEST_SENTENCE', '0', '0', 'Ecco una frase di test <br />con il carattere <br />selezionato.<br />Non male, eh?', 'Here is a test sentence<br />\r\nwith the<br />selected font.<br />Not bad, huh?', '', '', '', '', '', 1644, ''),
('the_full_movie_of_your_match_will_be_avaible_when_the_game_will_be_playable', '0', '0', 'Il film completo della partita sarà disponibile quando il gioco sarà nello stato \"Playable\"', 'The full movie of your match will be available when the game will be in the status \'Playable\'', '', '', '', '', '', 1645, ''),
('dont_show', '1', '1', 'Non mostrare', 'Don\'t show', '', '', '', '', '', 1646, ''),
('SHOWDONTSHOW_scores_in_the_debrief_page', '1', '1', 'i punteggi finali nella pagina dei risultati', 'final scores in the debrief page', '', '', '', '', '', 1647, ''),
('new_avatar', '1', '1', 'Nuovo avatar', 'New avatar', '', '', '', '', '', 1648, '');

-- --------------------------------------------------------

--
-- Struttura della tabella `scenarios`
--

CREATE TABLE `scenarios` (
  `id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `invisble` tinyint(1) NOT NULL DEFAULT '0',
  `propertyUid` int(11) NOT NULL DEFAULT '0',
  `creatorUid` int(11) NOT NULL DEFAULT '0',
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `publicWannabe` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `scenarios`
--

INSERT INTO `scenarios` (`id`, `name`, `invisble`, `propertyUid`, `creatorUid`, `creationDate`, `publicWannabe`) VALUES
(1, 'Office 1', 0, 0, 0, '2022-10-19 00:22:00', 0),
(2, 'Meeting room 1', 0, 0, 0, '2022-10-19 00:22:00', 0),
(3, 'Waiting room 1', 0, 0, 0, '2022-10-19 00:22:00', 0),
(4, 'Office 2', 0, 0, 0, '2022-10-19 00:22:00', 0),
(5, 'Office in Rome', 0, 0, 0, '2022-10-19 00:22:00', 0),
(6, 'the Desert!', 0, 0, 0, '2022-10-19 00:22:00', 0),
(7, 'The cockpit I', 0, 0, 0, '2022-10-19 00:22:00', 0),
(8, 'Romance I', 0, 0, 0, '2022-10-19 00:22:00', 0),
(9, 'Green I', 0, 0, 0, '2022-10-19 00:22:00', 0),
(10, 'E Corridor', 0, 0, 0, '2022-10-19 00:22:00', 0),
(11, 'E Kitchen', 0, 0, 0, '2022-10-19 00:22:00', 0),
(12, 'E Presentation', 0, 0, 0, '2022-10-19 00:22:00', 0),
(13, 'E PC', 0, 0, 0, '2022-10-19 00:22:00', 0),
(14, 'E Apartament I', 0, 0, 0, '2022-10-19 00:22:00', 0),
(15, 'E Apartament II', 0, 0, 0, '2022-10-19 00:22:00', 0),
(17, 'Apartment III', 0, 0, 4, '2022-10-19 00:22:00', 1),
(18, 'Boxes', 0, 0, 0, '2022-10-19 00:22:00', 1),
(19, 'Cafeteria', 0, 0, 0, '2022-10-19 00:22:00', 0),
(20, 'Library Room', 0, 0, 0, '2022-10-19 00:22:00', 0),
(21, 'meeting room 2', 0, 0, 0, '2022-10-19 00:22:00', 0),
(22, 'Meeting Room 3', 0, 0, 0, '2022-10-19 00:22:00', 0),
(23, 'Office 3', 0, 0, 0, '2022-10-19 00:22:00', 0),
(24, 'PC II', 0, 0, 0, '2022-10-19 00:22:00', 0),
(16, 'Eyes in the dark', 0, 0, 0, '2022-10-19 00:22:00', 0),
(25, 'Newsagent', 0, 0, 0, '2022-10-19 00:22:00', 0),
(27, 'House AR 1', 0, 0, 0, '2022-10-19 00:22:00', 0),
(29, 'Realtor 2', 0, 0, 0, '2022-10-19 00:22:00', 0),
(30, 'House AR 2', 0, 0, 0, '2022-10-19 00:22:00', 0),
(31, 'Handshake', 0, 0, 0, '2022-10-19 00:22:00', 0),
(32, 'Search house 1', 0, 0, 0, '2022-10-19 00:22:00', 0),
(33, 'Search house 2', 0, 0, 0, '2022-10-19 00:22:00', 0),
(38, 'Drawing', 0, 0, 0, '2022-10-19 00:22:00', 0),
(40, 'Plan', 0, 0, 0, '2022-10-19 00:22:00', 0),
(41, 'Typing', 0, 0, 0, '2022-10-19 00:22:00', 0),
(45, 'Friends', 0, 0, 0, '2022-10-19 00:22:00', 0),
(52, 'Old man and dog', 0, 0, 0, '2022-10-19 00:22:00', 0),
(54, 'Police', 0, 0, 0, '2022-10-19 00:22:00', 0),
(57, 'Music', 0, 0, 0, '2022-10-19 00:22:00', 0),
(134, 'impianto allarme', 0, 0, 1, '2022-12-01 09:37:55', 1),
(133, 'uscita di emergenza', 0, 0, 1, '2022-12-01 09:33:00', 1),
(132, 'serratura digitale', 0, 0, 1, '2022-12-01 09:32:36', 1),
(131, 'porte laboratorio', 0, 0, 1, '2022-12-01 09:32:08', 1),
(130, 'provette macro', 0, 0, 1, '2022-12-01 09:29:41', 1),
(129, 'laboratorio dettaglio 1', 0, 0, 1, '2022-12-01 09:29:08', 1),
(128, 'laboratorio sfocato', 0, 0, 1, '2022-12-01 09:27:27', 1),
(127, 'laboratorio completo', 0, 0, 1, '2022-12-01 09:26:43', 1),
(124, 'provette', 0, 0, 1, '2022-11-09 14:38:50', 1),
(125, 'impianto areazione 1', 0, 0, 1, '2022-12-01 09:21:16', 1),
(126, 'impianto areazione 2', 0, 0, 1, '2022-12-01 09:25:31', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `scenarios_used`
--

CREATE TABLE `scenarios_used` (
  `uid` int(11) DEFAULT NULL,
  `scenario_id` int(11) DEFAULT NULL,
  `date_up` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idl` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `TTSvoices`
--

CREATE TABLE `TTSvoices` (
  `language` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `type` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `langCode` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `voiceName` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `gender` varchar(6) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `nick` varchar(64) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `TTSvoices`
--

INSERT INTO `TTSvoices` (`language`, `type`, `langCode`, `voiceName`, `gender`, `nick`, `id`) VALUES
('Afrikaans (South Africa)', 'Standard', 'af-ZA', 'af-ZA-Standard-A', 'FEMALE', NULL, 1),
('Arabic', 'Standard', 'ar-XA', 'ar-XA-Standard-A', 'FEMALE', NULL, 2),
('Arabic', 'Standard', 'ar-XA', 'ar-XA-Standard-B', 'MALE', NULL, 3),
('Arabic', 'Standard', 'ar-XA', 'ar-XA-Standard-C', 'MALE', NULL, 4),
('Arabic', 'Standard', 'ar-XA', 'ar-XA-Standard-D', 'FEMALE', NULL, 5),
('Arabic', 'WaveNet', 'ar-XA', 'ar-XA-Wavenet-A', 'FEMALE', NULL, 6),
('Arabic', 'WaveNet', 'ar-XA', 'ar-XA-Wavenet-B', 'MALE', NULL, 7),
('Arabic', 'WaveNet', 'ar-XA', 'ar-XA-Wavenet-C', 'MALE', NULL, 8),
('Arabic', 'WaveNet', 'ar-XA', 'ar-XA-Wavenet-D', 'FEMALE', NULL, 9),
('Bengali (India)', 'Standard', 'bn-IN', 'bn-IN-Standard-A', 'FEMALE', NULL, 10),
('Bengali (India)', 'Standard', 'bn-IN', 'bn-IN-Standard-B', 'MALE', NULL, 11),
('Bengali (India)', 'WaveNet', 'bn-IN', 'bn-IN-Wavenet-A', 'FEMALE', NULL, 12),
('Bengali (India)', 'WaveNet', 'bn-IN', 'bn-IN-Wavenet-B', 'MALE', NULL, 13),
('Bulgarian (Bulgaria)', 'Standard', 'bg-BG', 'bg-BG-Standard-A', 'FEMALE', NULL, 14),
('Catalan (Spain)', 'Standard', 'ca-ES', 'ca-ES-Standard-A', 'FEMALE', NULL, 15),
('Chinese (Hong Kong)', 'Standard', 'yue-HK', 'yue-HK-Standard-A', 'FEMALE', NULL, 16),
('Chinese (Hong Kong)', 'Standard', 'yue-HK', 'yue-HK-Standard-B', 'MALE', NULL, 17),
('Chinese (Hong Kong)', 'Standard', 'yue-HK', 'yue-HK-Standard-C', 'FEMALE', NULL, 18),
('Chinese (Hong Kong)', 'Standard', 'yue-HK', 'yue-HK-Standard-D', 'MALE', NULL, 19),
('Czech (Czech Republic)', 'Standard', 'cs-CZ', 'cs-CZ-Standard-A', 'FEMALE', NULL, 20),
('Czech (Czech Republic)', 'WaveNet', 'cs-CZ', 'cs-CZ-Wavenet-A', 'FEMALE', NULL, 21),
('Danish (Denmark)', 'Standard', 'da-DK', 'da-DK-Standard-A', 'FEMALE', NULL, 22),
('Danish (Denmark)', 'Standard', 'da-DK', 'da-DK-Standard-C', 'MALE', NULL, 23),
('Danish (Denmark)', 'Standard', 'da-DK', 'da-DK-Standard-D', 'FEMALE', NULL, 24),
('Danish (Denmark)', 'Standard', 'da-DK', 'da-DK-Standard-E', 'FEMALE', NULL, 25),
('Danish (Denmark)', 'WaveNet', 'da-DK', 'da-DK-Wavenet-A', 'FEMALE', NULL, 26),
('Danish (Denmark)', 'WaveNet', 'da-DK', 'da-DK-Wavenet-C', 'MALE', NULL, 27),
('Danish (Denmark)', 'WaveNet', 'da-DK', 'da-DK-Wavenet-D', 'FEMALE', NULL, 28),
('Danish (Denmark)', 'WaveNet', 'da-DK', 'da-DK-Wavenet-E', 'FEMALE', NULL, 29),
('Dutch (Belgium)', 'Standard', 'nl-BE', 'nl-BE-Standard-A', 'FEMALE', NULL, 30),
('Dutch (Belgium)', 'Standard', 'nl-BE', 'nl-BE-Standard-B', 'MALE', NULL, 31),
('Dutch (Belgium)', 'WaveNet', 'nl-BE', 'nl-BE-Wavenet-A', 'FEMALE', NULL, 32),
('Dutch (Belgium)', 'WaveNet', 'nl-BE', 'nl-BE-Wavenet-B', 'MALE', NULL, 33),
('Dutch (Netherlands)', 'Standard', 'nl-NL', 'nl-NL-Standard-A', 'FEMALE', NULL, 34),
('Dutch (Netherlands)', 'Standard', 'nl-NL', 'nl-NL-Standard-B', 'MALE', NULL, 35),
('Dutch (Netherlands)', 'Standard', 'nl-NL', 'nl-NL-Standard-C', 'MALE', NULL, 36),
('Dutch (Netherlands)', 'Standard', 'nl-NL', 'nl-NL-Standard-D', 'FEMALE', NULL, 37),
('Dutch (Netherlands)', 'Standard', 'nl-NL', 'nl-NL-Standard-E', 'FEMALE', NULL, 38),
('Dutch (Netherlands)', 'WaveNet', 'nl-NL', 'nl-NL-Wavenet-A', 'FEMALE', NULL, 39),
('Dutch (Netherlands)', 'WaveNet', 'nl-NL', 'nl-NL-Wavenet-B', 'MALE', NULL, 40),
('Dutch (Netherlands)', 'WaveNet', 'nl-NL', 'nl-NL-Wavenet-C', 'MALE', NULL, 41),
('Dutch (Netherlands)', 'WaveNet', 'nl-NL', 'nl-NL-Wavenet-D', 'FEMALE', NULL, 42),
('Dutch (Netherlands)', 'WaveNet', 'nl-NL', 'nl-NL-Wavenet-E', 'FEMALE', NULL, 43),
('English (Australia)', 'Neural2', 'en-AU', 'en-AU-Neural2-A', 'FEMALE', NULL, 44),
('English (Australia)', 'Neural2', 'en-AU', 'en-AU-Neural2-B', 'MALE', NULL, 45),
('English (Australia)', 'Neural2', 'en-AU', 'en-AU-Neural2-C', 'FEMALE', NULL, 46),
('English (Australia)', 'Neural2', 'en-AU', 'en-AU-Neural2-D', 'MALE', NULL, 47),
('English (Australia)', 'Standard', 'en-AU', 'en-AU-Standard-A', 'FEMALE', NULL, 48),
('English (Australia)', 'Standard', 'en-AU', 'en-AU-Standard-A', 'FEMALE', NULL, 49),
('English (Australia)', 'Standard', 'en-AU', 'en-AU-Standard-B', 'MALE', NULL, 50),
('English (Australia)', 'Standard', 'en-AU', 'en-AU-Standard-B', 'MALE', NULL, 51),
('English (Australia)', 'Standard', 'en-AU', 'en-AU-Standard-C', 'FEMALE', NULL, 52),
('English (Australia)', 'Standard', 'en-AU', 'en-AU-Standard-C', 'FEMALE', NULL, 53),
('English (Australia)', 'Standard', 'en-AU', 'en-AU-Standard-D', 'MALE', NULL, 54),
('English (Australia)', 'Standard', 'en-AU', 'en-AU-Standard-D', 'MALE', NULL, 55),
('English (Australia)', 'WaveNet', 'en-AU', 'en-AU-Wavenet-A', 'FEMALE', NULL, 56),
('English (Australia)', 'WaveNet', 'en-AU', 'en-AU-Wavenet-B', 'MALE', NULL, 57),
('English (Australia)', 'WaveNet', 'en-AU', 'en-AU-Wavenet-C', 'FEMALE', NULL, 58),
('English (Australia)', 'WaveNet', 'en-AU', 'en-AU-Wavenet-D', 'MALE', NULL, 59),
('English (India)', 'Standard', 'en-IN', 'en-IN-Standard-A', 'FEMALE', NULL, 60),
('English (India)', 'Standard', 'en-IN', 'en-IN-Standard-B', 'MALE', NULL, 61),
('English (India)', 'Standard', 'en-IN', 'en-IN-Standard-C', 'MALE', NULL, 62),
('English (India)', 'Standard', 'en-IN', 'en-IN-Standard-D', 'FEMALE', NULL, 63),
('English (India)', 'WaveNet', 'en-IN', 'en-IN-Wavenet-A', 'FEMALE', NULL, 64),
('English (India)', 'WaveNet', 'en-IN', 'en-IN-Wavenet-B', 'MALE', NULL, 65),
('English (India)', 'WaveNet', 'en-IN', 'en-IN-Wavenet-C', 'MALE', NULL, 66),
('English (India)', 'WaveNet', 'en-IN', 'en-IN-Wavenet-D', 'FEMALE', NULL, 67),
('English (UK)', 'Neural2', 'en-GB', 'en-GB-Neural2-A', 'FEMALE', 'Mary', 68),
('English (UK)', 'Neural2', 'en-GB', 'en-GB-Neural2-B', 'MALE', 'William', 69),
('English (UK)', 'Neural2', 'en-GB', 'en-GB-Neural2-C', 'FEMALE', 'Rose', 70),
('English (UK)', 'Neural2', 'en-GB', 'en-GB-Neural2-D', 'MALE', 'John', 71),
('English (UK)', 'Neural2', 'en-GB', 'en-GB-Neural2-F', 'FEMALE', 'Elizabeth', 72),
('English (UK)', 'Standard', 'en-GB', 'en-GB-Standard-A', 'FEMALE', 'Eleanor', 73),
('English (UK)', 'Standard', 'en-GB', 'en-GB-Standard-B', 'MALE', 'Henry', 74),
('English (UK)', 'Standard', 'en-GB', 'en-GB-Standard-C', 'FEMALE', 'Layla', 75),
('English (UK)', 'Standard', 'en-GB', 'en-GB-Standard-D', 'MALE', 'Benjamin', 76),
('English (UK)', 'Standard', 'en-GB', 'en-GB-Standard-F', 'FEMALE', 'Victoria', 77),
('English (UK)', 'WaveNet', 'en-GB', 'en-GB-Wavenet-A', 'FEMALE', 'Violet', 78),
('English (UK)', 'WaveNet', 'en-GB', 'en-GB-Wavenet-B', 'MALE', 'George', 79),
('English (UK)', 'WaveNet', 'en-GB', 'en-GB-Wavenet-C', 'FEMALE', 'Evelyn', 80),
('English (UK)', 'WaveNet', 'en-GB', 'en-GB-Wavenet-D', 'MALE', 'Thomas', 81),
('English (UK)', 'WaveNet', 'en-GB', 'en-GB-Wavenet-F', 'FEMALE', 'Mia', 82),
('English (US)', 'Neural2', 'en-US', 'en-US-Neural2-A', 'MALE', NULL, 83),
('English (US)', 'Neural2', 'en-US', 'en-US-Neural2-C', 'FEMALE', NULL, 84),
('English (US)', 'Neural2', 'en-US', 'en-US-Neural2-D', 'MALE', NULL, 85),
('English (US)', 'Neural2', 'en-US', 'en-US-Neural2-E', 'FEMALE', NULL, 86),
('English (US)', 'Neural2', 'en-US', 'en-US-Neural2-F', 'FEMALE', NULL, 87),
('English (US)', 'Neural2', 'en-US', 'en-US-Neural2-G', 'FEMALE', NULL, 88),
('English (US)', 'Neural2', 'en-US', 'en-US-Neural2-H', 'FEMALE', NULL, 89),
('English (US)', 'Neural2', 'en-US', 'en-US-Neural2-I', 'MALE', NULL, 90),
('English (US)', 'Neural2', 'en-US', 'en-US-Neural2-J', 'MALE', NULL, 91),
('English (US)', 'Standard', 'en-US', 'en-US-Standard-A', 'MALE', NULL, 92),
('English (US)', 'Standard', 'en-US', 'en-US-Standard-B', 'MALE', NULL, 93),
('English (US)', 'Standard', 'en-US', 'en-US-Standard-C', 'FEMALE', NULL, 94),
('English (US)', 'Standard', 'en-US', 'en-US-Standard-D', 'MALE', NULL, 95),
('English (US)', 'Standard', 'en-US', 'en-US-Standard-E', 'FEMALE', NULL, 96),
('English (US)', 'Standard', 'en-US', 'en-US-Standard-F', 'FEMALE', NULL, 97),
('English (US)', 'Standard', 'en-US', 'en-US-Standard-G', 'FEMALE', NULL, 98),
('English (US)', 'Standard', 'en-US', 'en-US-Standard-H', 'FEMALE', NULL, 99),
('English (US)', 'Standard', 'en-US', 'en-US-Standard-I', 'MALE', NULL, 100),
('English (US)', 'Standard', 'en-US', 'en-US-Standard-J', 'MALE', NULL, 101),
('English (US)', 'WaveNet', 'en-US', 'en-US-Wavenet-A', 'MALE', NULL, 102),
('English (US)', 'WaveNet', 'en-US', 'en-US-Wavenet-B', 'MALE', NULL, 103),
('English (US)', 'WaveNet', 'en-US', 'en-US-Wavenet-C', 'FEMALE', NULL, 104),
('English (US)', 'WaveNet', 'en-US', 'en-US-Wavenet-D', 'MALE', NULL, 105),
('English (US)', 'WaveNet', 'en-US', 'en-US-Wavenet-E', 'FEMALE', NULL, 106),
('English (US)', 'WaveNet', 'en-US', 'en-US-Wavenet-F', 'FEMALE', NULL, 107),
('English (US)', 'WaveNet', 'en-US', 'en-US-Wavenet-G', 'FEMALE', NULL, 108),
('English (US)', 'WaveNet', 'en-US', 'en-US-Wavenet-H', 'FEMALE', NULL, 109),
('English (US)', 'WaveNet', 'en-US', 'en-US-Wavenet-I', 'MALE', NULL, 110),
('English (US)', 'WaveNet', 'en-US', 'en-US-Wavenet-J', 'MALE', NULL, 111),
('Filipino (Philippines)', 'Standard', 'fil-PH', 'fil-PH-Standard-A', 'FEMALE', NULL, 112),
('Filipino (Philippines)', 'Standard', 'fil-PH', 'fil-PH-Standard-B', 'FEMALE', NULL, 113),
('Filipino (Philippines)', 'Standard', 'fil-PH', 'fil-PH-Standard-C', 'MALE', NULL, 114),
('Filipino (Philippines)', 'Standard', 'fil-PH', 'fil-PH-Standard-D', 'MALE', NULL, 115),
('Filipino (Philippines)', 'WaveNet', 'fil-PH', 'fil-PH-Wavenet-A', 'FEMALE', NULL, 116),
('Filipino (Philippines)', 'WaveNet', 'fil-PH', 'fil-PH-Wavenet-B', 'FEMALE', NULL, 117),
('Filipino (Philippines)', 'WaveNet', 'fil-PH', 'fil-PH-Wavenet-C', 'MALE', NULL, 118),
('Filipino (Philippines)', 'WaveNet', 'fil-PH', 'fil-PH-Wavenet-D', 'MALE', NULL, 119),
('Finnish (Finland)', 'Standard', 'fi-FI', 'fi-FI-Standard-A', 'FEMALE', NULL, 120),
('Finnish (Finland)', 'WaveNet', 'fi-FI', 'fi-FI-Wavenet-A', 'FEMALE', NULL, 121),
('French (Canada)', 'Neural2', 'fr-CA', 'fr-CA-Neural2-A', 'FEMALE', NULL, 122),
('French (Canada)', 'Neural2', 'fr-CA', 'fr-CA-Neural2-B', 'MALE', NULL, 123),
('French (Canada)', 'Standard', 'fr-CA', 'fr-CA-Standard-A', 'FEMALE', NULL, 124),
('French (Canada)', 'Standard', 'fr-CA', 'fr-CA-Standard-B', 'MALE', NULL, 125),
('French (Canada)', 'Standard', 'fr-CA', 'fr-CA-Standard-C', 'FEMALE', NULL, 126),
('French (Canada)', 'Standard', 'fr-CA', 'fr-CA-Standard-D', 'MALE', NULL, 127),
('French (Canada)', 'WaveNet', 'fr-CA', 'fr-CA-Wavenet-A', 'FEMALE', NULL, 128),
('French (Canada)', 'WaveNet', 'fr-CA', 'fr-CA-Wavenet-B', 'MALE', NULL, 129),
('French (Canada)', 'WaveNet', 'fr-CA', 'fr-CA-Wavenet-C', 'FEMALE', NULL, 130),
('French (Canada)', 'WaveNet', 'fr-CA', 'fr-CA-Wavenet-D', 'MALE', NULL, 131),
('French (France)', 'Neural2', 'fr-FR', 'fr-FR-Neural2-A', 'FEMALE', NULL, 132),
('French (France)', 'Neural2', 'fr-FR', 'fr-FR-Neural2-B', 'MALE', NULL, 133),
('French (France)', 'Neural2', 'fr-FR', 'fr-FR-Neural2-C', 'FEMALE', NULL, 134),
('French (France)', 'Neural2', 'fr-FR', 'fr-FR-Neural2-D', 'MALE', NULL, 135),
('French (France)', 'Neural2', 'fr-FR', 'fr-FR-Neural2-E', 'FEMALE', NULL, 136),
('French (France)', 'Standard', 'fr-FR', 'fr-FR-Standard-A', 'FEMALE', NULL, 137),
('French (France)', 'Standard', 'fr-FR', 'fr-FR-Standard-A', 'FEMALE', NULL, 138),
('French (France)', 'Standard', 'fr-FR', 'fr-FR-Standard-B', 'MALE', NULL, 139),
('French (France)', 'Standard', 'fr-FR', 'fr-FR-Standard-B', 'MALE', NULL, 140),
('French (France)', 'Standard', 'fr-FR', 'fr-FR-Standard-C', 'FEMALE', NULL, 141),
('French (France)', 'Standard', 'fr-FR', 'fr-FR-Standard-C', 'FEMALE', NULL, 142),
('French (France)', 'Standard', 'fr-FR', 'fr-FR-Standard-D', 'MALE', NULL, 143),
('French (France)', 'Standard', 'fr-FR', 'fr-FR-Standard-D', 'MALE', NULL, 144),
('French (France)', 'Standard', 'fr-FR', 'fr-FR-Standard-E', 'FEMALE', NULL, 145),
('French (France)', 'WaveNet', 'fr-FR', 'fr-FR-Wavenet-A', 'FEMALE', NULL, 146),
('French (France)', 'WaveNet', 'fr-FR', 'fr-FR-Wavenet-B', 'MALE', NULL, 147),
('French (France)', 'WaveNet', 'fr-FR', 'fr-FR-Wavenet-C', 'FEMALE', NULL, 148),
('French (France)', 'WaveNet', 'fr-FR', 'fr-FR-Wavenet-D', 'MALE', NULL, 149),
('French (France)', 'WaveNet', 'fr-FR', 'fr-FR-Wavenet-E', 'FEMALE', NULL, 150),
('German (Germany)', 'Neural2', 'de-DE', 'de-DE-Neural2-D', 'MALE', NULL, 151),
('German (Germany)', 'Neural2', 'de-DE', 'de-DE-Neural2-F', 'FEMALE', NULL, 152),
('German (Germany)', 'Standard', 'de-DE', 'de-DE-Standard-A', 'FEMALE', NULL, 153),
('German (Germany)', 'Standard', 'de-DE', 'de-DE-Standard-B', 'MALE', NULL, 154),
('German (Germany)', 'Standard', 'de-DE', 'de-DE-Standard-C', 'FEMALE', NULL, 155),
('German (Germany)', 'Standard', 'de-DE', 'de-DE-Standard-D', 'MALE', NULL, 156),
('German (Germany)', 'Standard', 'de-DE', 'de-DE-Standard-E', 'MALE', NULL, 157),
('German (Germany)', 'Standard', 'de-DE', 'de-DE-Standard-F', 'FEMALE', NULL, 158),
('German (Germany)', 'WaveNet', 'de-DE', 'de-DE-Wavenet-A', 'FEMALE', NULL, 159),
('German (Germany)', 'WaveNet', 'de-DE', 'de-DE-Wavenet-B', 'MALE', NULL, 160),
('German (Germany)', 'WaveNet', 'de-DE', 'de-DE-Wavenet-C', 'FEMALE', NULL, 161),
('German (Germany)', 'WaveNet', 'de-DE', 'de-DE-Wavenet-D', 'MALE', NULL, 162),
('German (Germany)', 'WaveNet', 'de-DE', 'de-DE-Wavenet-E', 'MALE', NULL, 163),
('German (Germany)', 'WaveNet', 'de-DE', 'de-DE-Wavenet-F', 'FEMALE', NULL, 164),
('Greek (Greece)', 'Standard', 'el-GR', 'el-GR-Standard-A', 'FEMALE', NULL, 165),
('Greek (Greece)', 'WaveNet', 'el-GR', 'el-GR-Wavenet-A', 'FEMALE', NULL, 166),
('Gujarati (India)', 'Standard', 'gu-IN', 'gu-IN-Standard-A', 'FEMALE', NULL, 167),
('Gujarati (India)', 'Standard', 'gu-IN', 'gu-IN-Standard-B', 'MALE', NULL, 168),
('Gujarati (India)', 'WaveNet', 'gu-IN', 'gu-IN-Wavenet-A', 'FEMALE', NULL, 169),
('Gujarati (India)', 'WaveNet', 'gu-IN', 'gu-IN-Wavenet-B', 'MALE', NULL, 170),
('Hindi (India)', 'Standard', 'hi-IN', 'hi-IN-Standard-A', 'FEMALE', NULL, 171),
('Hindi (India)', 'Standard', 'hi-IN', 'hi-IN-Standard-B', 'MALE', NULL, 172),
('Hindi (India)', 'Standard', 'hi-IN', 'hi-IN-Standard-C', 'MALE', NULL, 173),
('Hindi (India)', 'Standard', 'hi-IN', 'hi-IN-Standard-D', 'FEMALE', NULL, 174),
('Hindi (India)', 'WaveNet', 'hi-IN', 'hi-IN-Wavenet-A', 'FEMALE', NULL, 175),
('Hindi (India)', 'WaveNet', 'hi-IN', 'hi-IN-Wavenet-B', 'MALE', NULL, 176),
('Hindi (India)', 'WaveNet', 'hi-IN', 'hi-IN-Wavenet-C', 'MALE', NULL, 177),
('Hindi (India)', 'WaveNet', 'hi-IN', 'hi-IN-Wavenet-D', 'FEMALE', NULL, 178),
('Hungarian (Hungary)', 'Standard', 'hu-HU', 'hu-HU-Standard-A', 'FEMALE', NULL, 179),
('Hungarian (Hungary)', 'WaveNet', 'hu-HU', 'hu-HU-Wavenet-A', 'FEMALE', NULL, 180),
('Icelandic (Iceland)', 'Standard', 'is-IS', 'is-IS-Standard-A', 'FEMALE', NULL, 181),
('Indonesian (Indonesia)', 'Standard', 'id-ID', 'id-ID-Standard-A', 'FEMALE', NULL, 182),
('Indonesian (Indonesia)', 'Standard', 'id-ID', 'id-ID-Standard-B', 'MALE', NULL, 183),
('Indonesian (Indonesia)', 'Standard', 'id-ID', 'id-ID-Standard-C', 'MALE', NULL, 184),
('Indonesian (Indonesia)', 'Standard', 'id-ID', 'id-ID-Standard-D', 'FEMALE', NULL, 185),
('Indonesian (Indonesia)', 'WaveNet', 'id-ID', 'id-ID-Wavenet-A', 'FEMALE', NULL, 186),
('Indonesian (Indonesia)', 'WaveNet', 'id-ID', 'id-ID-Wavenet-B', 'MALE', NULL, 187),
('Indonesian (Indonesia)', 'WaveNet', 'id-ID', 'id-ID-Wavenet-C', 'MALE', NULL, 188),
('Indonesian (Indonesia)', 'WaveNet', 'id-ID', 'id-ID-Wavenet-D', 'FEMALE', NULL, 189),
('Italian (Italy)', 'Standard', 'it-IT', 'it-IT-Standard-A', 'FEMALE', 'Maria', 190),
('Italian (Italy)', 'Standard', 'it-IT', 'it-IT-Standard-B', 'FEMALE', 'Rosa', 192),
('Italian (Italy)', 'Standard', 'it-IT', 'it-IT-Standard-C', 'MALE', 'Mario', 194),
('Italian (Italy)', 'Standard', 'it-IT', 'it-IT-Standard-D', 'MALE', 'Giovanni', 196),
('Italian (Italy)', 'WaveNet', 'it-IT', 'it-IT-Wavenet-A', 'FEMALE', 'Marta', 198),
('Italian (Italy)', 'WaveNet', 'it-IT', 'it-IT-Wavenet-B', 'FEMALE', 'Betta', 199),
('Italian (Italy)', 'WaveNet', 'it-IT', 'it-IT-Wavenet-C', 'MALE', 'Rodolfo', 200),
('Italian (Italy)', 'WaveNet', 'it-IT', 'it-IT-Wavenet-D', 'MALE', 'Peppe', 201),
('Japanese (Japan)', 'Standard', 'ja-JP', 'ja-JP-Standard-A', 'FEMALE', NULL, 202),
('Japanese (Japan)', 'Standard', 'ja-JP', 'ja-JP-Standard-B', 'FEMALE', NULL, 203),
('Japanese (Japan)', 'Standard', 'ja-JP', 'ja-JP-Standard-C', 'MALE', NULL, 204),
('Japanese (Japan)', 'Standard', 'ja-JP', 'ja-JP-Standard-D', 'MALE', NULL, 205),
('Japanese (Japan)', 'WaveNet', 'ja-JP', 'ja-JP-Wavenet-A', 'FEMALE', NULL, 206),
('Japanese (Japan)', 'WaveNet', 'ja-JP', 'ja-JP-Wavenet-B', 'FEMALE', NULL, 207),
('Japanese (Japan)', 'WaveNet', 'ja-JP', 'ja-JP-Wavenet-C', 'MALE', NULL, 208),
('Japanese (Japan)', 'WaveNet', 'ja-JP', 'ja-JP-Wavenet-D', 'MALE', NULL, 209),
('Kannada (India)', 'Standard', 'kn-IN', 'kn-IN-Standard-A', 'FEMALE', NULL, 210),
('Kannada (India)', 'Standard', 'kn-IN', 'kn-IN-Standard-B', 'MALE', NULL, 211),
('Kannada (India)', 'WaveNet', 'kn-IN', 'kn-IN-Wavenet-A', 'FEMALE', NULL, 212),
('Kannada (India)', 'WaveNet', 'kn-IN', 'kn-IN-Wavenet-B', 'MALE', NULL, 213),
('Korean (South Korea)', 'Standard', 'ko-KR', 'ko-KR-Standard-A', 'FEMALE', NULL, 214),
('Korean (South Korea)', 'Standard', 'ko-KR', 'ko-KR-Standard-A', 'FEMALE', NULL, 215),
('Korean (South Korea)', 'Standard', 'ko-KR', 'ko-KR-Standard-B', 'FEMALE', NULL, 216),
('Korean (South Korea)', 'Standard', 'ko-KR', 'ko-KR-Standard-B', 'FEMALE', NULL, 217),
('Korean (South Korea)', 'Standard', 'ko-KR', 'ko-KR-Standard-C', 'MALE', NULL, 218),
('Korean (South Korea)', 'Standard', 'ko-KR', 'ko-KR-Standard-C', 'MALE', NULL, 219),
('Korean (South Korea)', 'Standard', 'ko-KR', 'ko-KR-Standard-D', 'MALE', NULL, 220),
('Korean (South Korea)', 'Standard', 'ko-KR', 'ko-KR-Standard-D', 'MALE', NULL, 221),
('Korean (South Korea)', 'WaveNet', 'ko-KR', 'ko-KR-Wavenet-A', 'FEMALE', NULL, 222),
('Korean (South Korea)', 'WaveNet', 'ko-KR', 'ko-KR-Wavenet-B', 'FEMALE', NULL, 223),
('Korean (South Korea)', 'WaveNet', 'ko-KR', 'ko-KR-Wavenet-C', 'MALE', NULL, 224),
('Korean (South Korea)', 'WaveNet', 'ko-KR', 'ko-KR-Wavenet-D', 'MALE', NULL, 225),
('Latvian (Latvia)', 'Standard', 'lv-LV', 'lv-LV-Standard-A', 'MALE', NULL, 226),
('Malay (Malaysia)', 'Standard', 'ms-MY', 'ms-MY-Standard-A', 'FEMALE', NULL, 227),
('Malay (Malaysia)', 'Standard', 'ms-MY', 'ms-MY-Standard-B', 'MALE', NULL, 228),
('Malay (Malaysia)', 'Standard', 'ms-MY', 'ms-MY-Standard-C', 'FEMALE', NULL, 229),
('Malay (Malaysia)', 'Standard', 'ms-MY', 'ms-MY-Standard-D', 'MALE', NULL, 230),
('Malay (Malaysia)', 'WaveNet', 'ms-MY', 'ms-MY-Wavenet-A', 'FEMALE', NULL, 231),
('Malay (Malaysia)', 'WaveNet', 'ms-MY', 'ms-MY-Wavenet-B', 'MALE', NULL, 232),
('Malay (Malaysia)', 'WaveNet', 'ms-MY', 'ms-MY-Wavenet-C', 'FEMALE', NULL, 233),
('Malay (Malaysia)', 'WaveNet', 'ms-MY', 'ms-MY-Wavenet-D', 'MALE', NULL, 234),
('Malayalam (India)', 'Standard', 'ml-IN', 'ml-IN-Standard-A', 'FEMALE', NULL, 235),
('Malayalam (India)', 'Standard', 'ml-IN', 'ml-IN-Standard-B', 'MALE', NULL, 236),
('Malayalam (India)', 'WaveNet', 'ml-IN', 'ml-IN-Wavenet-A', 'FEMALE', NULL, 237),
('Malayalam (India)', 'WaveNet', 'ml-IN', 'ml-IN-Wavenet-B', 'MALE', NULL, 238),
('Mandarin Chinese', 'Standard', 'cmn-CN', 'cmn-CN-Standard-A', 'FEMALE', NULL, 239),
('Mandarin Chinese', 'Standard', 'cmn-CN', 'cmn-CN-Standard-B', 'MALE', NULL, 240),
('Mandarin Chinese', 'Standard', 'cmn-CN', 'cmn-CN-Standard-C', 'MALE', NULL, 241),
('Mandarin Chinese', 'Standard', 'cmn-CN', 'cmn-CN-Standard-D', 'FEMALE', NULL, 242),
('Mandarin Chinese', 'WaveNet', 'cmn-CN', 'cmn-CN-Wavenet-A', 'FEMALE', NULL, 243),
('Mandarin Chinese', 'WaveNet', 'cmn-CN', 'cmn-CN-Wavenet-B', 'MALE', NULL, 244),
('Mandarin Chinese', 'WaveNet', 'cmn-CN', 'cmn-CN-Wavenet-C', 'MALE', NULL, 245),
('Mandarin Chinese', 'WaveNet', 'cmn-CN', 'cmn-CN-Wavenet-D', 'FEMALE', NULL, 246),
('Mandarin Chinese', 'Standard', 'cmn-TW', 'cmn-TW-Standard-A', 'FEMALE', NULL, 247),
('Mandarin Chinese', 'Standard', 'cmn-TW', 'cmn-TW-Standard-B', 'MALE', NULL, 248),
('Mandarin Chinese', 'Standard', 'cmn-TW', 'cmn-TW-Standard-C', 'MALE', NULL, 249),
('Mandarin Chinese', 'WaveNet', 'cmn-TW', 'cmn-TW-Wavenet-A', 'FEMALE', NULL, 250),
('Mandarin Chinese', 'WaveNet', 'cmn-TW', 'cmn-TW-Wavenet-B', 'MALE', NULL, 251),
('Mandarin Chinese', 'WaveNet', 'cmn-TW', 'cmn-TW-Wavenet-C', 'MALE', NULL, 252),
('Norwegian (Norway)', 'Standard', 'nb-NO', 'nb-NO-Standard-A', 'FEMALE', NULL, 253),
('Norwegian (Norway)', 'Standard', 'nb-NO', 'nb-NO-Standard-B', 'MALE', NULL, 254),
('Norwegian (Norway)', 'Standard', 'nb-NO', 'nb-NO-Standard-C', 'FEMALE', NULL, 255),
('Norwegian (Norway)', 'Standard', 'nb-NO', 'nb-NO-Standard-D', 'MALE', NULL, 256),
('Norwegian (Norway)', 'Standard', 'nb-NO', 'nb-NO-Standard-E', 'FEMALE', NULL, 257),
('Norwegian (Norway)', 'WaveNet', 'nb-NO', 'nb-NO-Wavenet-A', 'FEMALE', NULL, 258),
('Norwegian (Norway)', 'WaveNet', 'nb-NO', 'nb-NO-Wavenet-B', 'MALE', NULL, 259),
('Norwegian (Norway)', 'WaveNet', 'nb-NO', 'nb-NO-Wavenet-C', 'FEMALE', NULL, 260),
('Norwegian (Norway)', 'WaveNet', 'nb-NO', 'nb-NO-Wavenet-D', 'MALE', NULL, 261),
('Norwegian (Norway)', 'WaveNet', 'nb-NO', 'nb-NO-Wavenet-E', 'FEMALE', NULL, 262),
('Polish (Poland)', 'Standard', 'pl-PL', 'pl-PL-Standard-A', 'FEMALE', NULL, 263),
('Polish (Poland)', 'Standard', 'pl-PL', 'pl-PL-Standard-B', 'MALE', NULL, 264),
('Polish (Poland)', 'Standard', 'pl-PL', 'pl-PL-Standard-C', 'MALE', NULL, 265),
('Polish (Poland)', 'Standard', 'pl-PL', 'pl-PL-Standard-D', 'FEMALE', NULL, 266),
('Polish (Poland)', 'Standard', 'pl-PL', 'pl-PL-Standard-E', 'FEMALE', NULL, 267),
('Polish (Poland)', 'WaveNet', 'pl-PL', 'pl-PL-Wavenet-A', 'FEMALE', NULL, 268),
('Polish (Poland)', 'WaveNet', 'pl-PL', 'pl-PL-Wavenet-B', 'MALE', NULL, 269),
('Polish (Poland)', 'WaveNet', 'pl-PL', 'pl-PL-Wavenet-C', 'MALE', NULL, 270),
('Polish (Poland)', 'WaveNet', 'pl-PL', 'pl-PL-Wavenet-D', 'FEMALE', NULL, 271),
('Polish (Poland)', 'WaveNet', 'pl-PL', 'pl-PL-Wavenet-E', 'FEMALE', NULL, 272),
('Portuguese (Brazil)', 'Standard', 'pt-BR', 'pt-BR-Standard-A', 'FEMALE', NULL, 273),
('Portuguese (Brazil)', 'Standard', 'pt-BR', 'pt-BR-Standard-B', 'MALE', NULL, 274),
('Portuguese (Brazil)', 'Standard', 'pt-BR', 'pt-BR-Standard-C', 'FEMALE', NULL, 275),
('Portuguese (Brazil)', 'WaveNet', 'pt-BR', 'pt-BR-Wavenet-A', 'FEMALE', NULL, 276),
('Portuguese (Brazil)', 'WaveNet', 'pt-BR', 'pt-BR-Wavenet-B', 'MALE', NULL, 277),
('Portuguese (Brazil)', 'WaveNet', 'pt-BR', 'pt-BR-Wavenet-C', 'FEMALE', NULL, 278),
('Portuguese (Portugal)', 'Standard', 'pt-PT', 'pt-PT-Standard-A', 'FEMALE', NULL, 279),
('Portuguese (Portugal)', 'Standard', 'pt-PT', 'pt-PT-Standard-B', 'MALE', NULL, 280),
('Portuguese (Portugal)', 'Standard', 'pt-PT', 'pt-PT-Standard-C', 'MALE', NULL, 281),
('Portuguese (Portugal)', 'Standard', 'pt-PT', 'pt-PT-Standard-D', 'FEMALE', NULL, 282),
('Portuguese (Portugal)', 'WaveNet', 'pt-PT', 'pt-PT-Wavenet-A', 'FEMALE', NULL, 283),
('Portuguese (Portugal)', 'WaveNet', 'pt-PT', 'pt-PT-Wavenet-B', 'MALE', NULL, 284),
('Portuguese (Portugal)', 'WaveNet', 'pt-PT', 'pt-PT-Wavenet-C', 'MALE', NULL, 285),
('Portuguese (Portugal)', 'WaveNet', 'pt-PT', 'pt-PT-Wavenet-D', 'FEMALE', NULL, 286),
('Punjabi (India)', 'Standard', 'pa-IN', 'pa-IN-Standard-A', 'FEMALE', NULL, 287),
('Punjabi (India)', 'Standard', 'pa-IN', 'pa-IN-Standard-B', 'MALE', NULL, 288),
('Punjabi (India)', 'Standard', 'pa-IN', 'pa-IN-Standard-C', 'FEMALE', NULL, 289),
('Punjabi (India)', 'Standard', 'pa-IN', 'pa-IN-Standard-D', 'MALE', NULL, 290),
('Punjabi (India)', 'WaveNet', 'pa-IN', 'pa-IN-Wavenet-A', 'FEMALE', NULL, 291),
('Punjabi (India)', 'WaveNet', 'pa-IN', 'pa-IN-Wavenet-B', 'MALE', NULL, 292),
('Punjabi (India)', 'WaveNet', 'pa-IN', 'pa-IN-Wavenet-C', 'FEMALE', NULL, 293),
('Punjabi (India)', 'WaveNet', 'pa-IN', 'pa-IN-Wavenet-D', 'MALE', NULL, 294),
('Romanian (Romania)', 'Standard', 'ro-RO', 'ro-RO-Standard-A', 'FEMALE', NULL, 295),
('Romanian (Romania)', 'WaveNet', 'ro-RO', 'ro-RO-Wavenet-A', 'FEMALE', NULL, 296),
('Russian (Russia)', 'Standard', 'ru-RU', 'ru-RU-Standard-A', 'FEMALE', NULL, 297),
('Russian (Russia)', 'Standard', 'ru-RU', 'ru-RU-Standard-B', 'MALE', NULL, 298),
('Russian (Russia)', 'Standard', 'ru-RU', 'ru-RU-Standard-C', 'FEMALE', NULL, 299),
('Russian (Russia)', 'Standard', 'ru-RU', 'ru-RU-Standard-D', 'MALE', NULL, 300),
('Russian (Russia)', 'Standard', 'ru-RU', 'ru-RU-Standard-E', 'FEMALE', NULL, 301),
('Russian (Russia)', 'WaveNet', 'ru-RU', 'ru-RU-Wavenet-A', 'FEMALE', NULL, 302),
('Russian (Russia)', 'WaveNet', 'ru-RU', 'ru-RU-Wavenet-B', 'MALE', NULL, 303),
('Russian (Russia)', 'WaveNet', 'ru-RU', 'ru-RU-Wavenet-C', 'FEMALE', NULL, 304),
('Russian (Russia)', 'WaveNet', 'ru-RU', 'ru-RU-Wavenet-D', 'MALE', NULL, 305),
('Russian (Russia)', 'WaveNet', 'ru-RU', 'ru-RU-Wavenet-E', 'FEMALE', NULL, 306),
('Serbian (Cyrillic)', 'Standard', 'sr-RS', 'sr-rs-Standard-A', 'FEMALE', NULL, 307),
('Slovak (Slovakia)', 'Standard', 'sk-SK', 'sk-SK-Standard-A', 'FEMALE', NULL, 308),
('Slovak (Slovakia)', 'WaveNet', 'sk-SK', 'sk-SK-Wavenet-A', 'FEMALE', NULL, 309),
('Spanish (Spain)', 'Standard', 'es-ES', 'es-ES-Standard-A', 'FEMALE', NULL, 310),
('Spanish (Spain)', 'Standard', 'es-ES', 'es-ES-Standard-B', 'MALE', NULL, 311),
('Spanish (Spain)', 'Standard', 'es-ES', 'es-ES-Standard-C', 'FEMALE', NULL, 312),
('Spanish (Spain)', 'Standard', 'es-ES', 'es-ES-Standard-D', 'FEMALE', NULL, 313),
('Spanish (Spain)', 'WaveNet', 'es-ES', 'es-ES-Wavenet-B', 'MALE', NULL, 314),
('Spanish (Spain)', 'WaveNet', 'es-ES', 'es-ES-Wavenet-C', 'FEMALE', NULL, 315),
('Spanish (Spain)', 'WaveNet', 'es-ES', 'es-ES-Wavenet-D', 'FEMALE', NULL, 316),
('Spanish (US)', 'Neural2', 'es-US', 'es-US-Neural2-A', 'FEMALE', NULL, 317),
('Spanish (US)', 'Neural2', 'es-US', 'es-US-Neural2-B', 'MALE', NULL, 318),
('Spanish (US)', 'Neural2', 'es-US', 'es-US-Neural2-C', 'MALE', NULL, 319),
('Spanish (US)', 'Standard', 'es-US', 'es-US-Standard-A', 'FEMALE', NULL, 320),
('Spanish (US)', 'Standard', 'es-US', 'es-US-Standard-B', 'MALE', NULL, 321),
('Spanish (US)', 'Standard', 'es-US', 'es-US-Standard-C', 'MALE', NULL, 322),
('Spanish (US)', 'WaveNet', 'es-US', 'es-US-Wavenet-A', 'FEMALE', NULL, 323),
('Spanish (US)', 'WaveNet', 'es-US', 'es-US-Wavenet-B', 'MALE', NULL, 324),
('Spanish (US)', 'WaveNet', 'es-US', 'es-US-Wavenet-C', 'MALE', NULL, 325),
('Swedish (Sweden)', 'Standard', 'sv-SE', 'sv-SE-Standard-A', 'FEMALE', NULL, 326),
('Swedish (Sweden)', 'Standard', 'sv-SE', 'sv-SE-Standard-B', 'FEMALE', NULL, 327),
('Swedish (Sweden)', 'Standard', 'sv-SE', 'sv-SE-Standard-C', 'FEMALE', NULL, 328),
('Swedish (Sweden)', 'Standard', 'sv-SE', 'sv-SE-Standard-D', 'MALE', NULL, 329),
('Swedish (Sweden)', 'Standard', 'sv-SE', 'sv-SE-Standard-E', 'MALE', NULL, 330),
('Swedish (Sweden)', 'WaveNet', 'sv-SE', 'sv-SE-Wavenet-A', 'FEMALE', NULL, 331),
('Swedish (Sweden)', 'WaveNet', 'sv-SE', 'sv-SE-Wavenet-B', 'FEMALE', NULL, 332),
('Swedish (Sweden)', 'WaveNet', 'sv-SE', 'sv-SE-Wavenet-C', 'MALE', NULL, 333),
('Swedish (Sweden)', 'WaveNet', 'sv-SE', 'sv-SE-Wavenet-D', 'FEMALE', NULL, 334),
('Swedish (Sweden)', 'WaveNet', 'sv-SE', 'sv-SE-Wavenet-E', 'MALE', NULL, 335),
('Tamil (India)', 'Standard', 'ta-IN', 'ta-IN-Standard-A', 'FEMALE', NULL, 336),
('Tamil (India)', 'Standard', 'ta-IN', 'ta-IN-Standard-B', 'MALE', NULL, 337),
('Tamil (India)', 'Standard', 'ta-IN', 'ta-IN-Standard-C', 'FEMALE', NULL, 338),
('Tamil (India)', 'Standard', 'ta-IN', 'ta-IN-Standard-D', 'MALE', NULL, 339),
('Tamil (India)', 'WaveNet', 'ta-IN', 'ta-IN-Wavenet-A', 'FEMALE', NULL, 340),
('Tamil (India)', 'WaveNet', 'ta-IN', 'ta-IN-Wavenet-B', 'MALE', NULL, 341),
('Tamil (India)', 'WaveNet', 'ta-IN', 'ta-IN-Wavenet-C', 'FEMALE', NULL, 342),
('Tamil (India)', 'WaveNet', 'ta-IN', 'ta-IN-Wavenet-D', 'MALE', NULL, 343),
('Telugu (India)', 'Standard', 'te-IN', 'te-IN-Standard-A', 'FEMALE', NULL, 344),
('Telugu (India)', 'Standard', 'te-IN', 'te-IN-Standard-B', 'MALE', NULL, 345),
('Thai (Thailand)', 'Standard', 'th-TH', 'th-TH-Standard-A', 'FEMALE', NULL, 346),
('Turkish (Turkey)', 'Standard', 'tr-TR', 'tr-TR-Standard-A', 'FEMALE', NULL, 347),
('Turkish (Turkey)', 'Standard', 'tr-TR', 'tr-TR-Standard-B', 'MALE', NULL, 348),
('Turkish (Turkey)', 'Standard', 'tr-TR', 'tr-TR-Standard-C', 'FEMALE', NULL, 349),
('Turkish (Turkey)', 'Standard', 'tr-TR', 'tr-TR-Standard-D', 'FEMALE', NULL, 350),
('Turkish (Turkey)', 'Standard', 'tr-TR', 'tr-TR-Standard-E', 'MALE', NULL, 351),
('Turkish (Turkey)', 'WaveNet', 'tr-TR', 'tr-TR-Wavenet-A', 'FEMALE', NULL, 352),
('Turkish (Turkey)', 'WaveNet', 'tr-TR', 'tr-TR-Wavenet-B', 'MALE', NULL, 353),
('Turkish (Turkey)', 'WaveNet', 'tr-TR', 'tr-TR-Wavenet-C', 'FEMALE', NULL, 354),
('Turkish (Turkey)', 'WaveNet', 'tr-TR', 'tr-TR-Wavenet-D', 'FEMALE', NULL, 355),
('Turkish (Turkey)', 'WaveNet', 'tr-TR', 'tr-TR-Wavenet-E', 'MALE', NULL, 356),
('Ukrainian (Ukraine)', 'Standard', 'uk-UA', 'uk-UA-Standard-A', 'FEMALE', NULL, 357),
('Ukrainian (Ukraine)', 'WaveNet', 'uk-UA', 'uk-UA-Wavenet-A', 'FEMALE', NULL, 358),
('Vietnamese (Vietnam)', 'Standard', 'vi-VN', 'vi-VN-Standard-A', 'FEMALE', NULL, 359),
('Vietnamese (Vietnam)', 'Standard', 'vi-VN', 'vi-VN-Standard-B', 'MALE', NULL, 360),
('Vietnamese (Vietnam)', 'Standard', 'vi-VN', 'vi-VN-Standard-C', 'FEMALE', NULL, 361),
('Vietnamese (Vietnam)', 'Standard', 'vi-VN', 'vi-VN-Standard-D', 'MALE', NULL, 362),
('Vietnamese (Vietnam)', 'WaveNet', 'vi-VN', 'vi-VN-Wavenet-A', 'FEMALE', NULL, 363),
('Vietnamese (Vietnam)', 'WaveNet', 'vi-VN', 'vi-VN-Wavenet-B', 'MALE', NULL, 364),
('Vietnamese (Vietnam)', 'WaveNet', 'vi-VN', 'vi-VN-Wavenet-C', 'FEMALE', NULL, 365),
('Vietnamese (Vietnam)', 'WaveNet', 'vi-VN', 'vi-VN-Wavenet-D', 'MALE', NULL, 366),
('Italian (Italy)', 'Neural2', 'it-IT', 'it-IT-Neural2-A', 'FEMALE', 'MariaNeurale', 367),
('Italian (Italy)', 'Neural2', 'it-IT', 'it-IT-Neural2-C', 'MALE', 'MarioNeurale', 368);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `users_id` int(255) NOT NULL,
  `muser_id` int(11) DEFAULT NULL,
  `user_level` int(1) NOT NULL DEFAULT '0' COMMENT '0 L_user, 1 L_editor, 2 L_administrator, 3 L_super_user',
  `family` varchar(16) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_pass` varchar(255) DEFAULT NULL,
  `user_real_name` varchar(255) DEFAULT NULL,
  `user_real_surname` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `role0` varchar(64) DEFAULT NULL,
  `role1` varchar(64) DEFAULT NULL,
  `role2` varchar(64) DEFAULT NULL,
  `role3` varchar(64) DEFAULT NULL,
  `user_phone` varchar(255) DEFAULT NULL,
  `sex` enum('na','male','female') NOT NULL DEFAULT 'na',
  `birthdate` text,
  `notActiveSince` int(22) NOT NULL DEFAULT '0',
  `created` bigint(20) DEFAULT NULL,
  `updated` bigint(20) DEFAULT NULL,
  `testingUser` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`users_id`, `muser_id`, `user_level`, `family`, `user_name`, `user_pass`, `user_real_name`, `user_real_surname`, `user_email`, `role0`, `role1`, `role2`, `role3`, `user_phone`, `sex`, `birthdate`, `notActiveSince`, `created`, `updated`, `testingUser`) VALUES
(1, NULL, 0, 'entropy', 'user', 'user1', 'User', 'One', 'xxx@xxx', '', NULL, NULL, NULL, NULL, 'na', '0000-00-00', 0, 1615907358, 1615907358, 0),
(2, NULL, 1, 'entropy', 'editor', 'editor1', 'User', 'two', 'xxx@xxx1', '', NULL, NULL, NULL, NULL, 'na', '0000-00-00', 0, 1615907358, 1615907358, 0),
(3, NULL, 3, 'entropy', 'super', 'super1', 'User', 'three', 'xxx@xxx3', '', NULL, NULL, NULL, NULL, 'na', '0000-00-00', 0, 1615907358, 1615907358, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `usersgroups`
--

CREATE TABLE `usersgroups` (
  `idgroup` int(11) NOT NULL,
  `family` varchar(16) DEFAULT NULL,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `orderg` smallint(3) NOT NULL DEFAULT '0',
  `description_it` text,
  `description_en` text,
  `createts` int(11) DEFAULT NULL,
  `editedts` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `usersgroups_insighters`
--

CREATE TABLE `usersgroups_insighters` (
  `uid` int(11) NOT NULL,
  `idgroup` int(11) NOT NULL,
  `addedTs` int(11) NOT NULL,
  `idr` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `user_tracking`
--

CREATE TABLE `user_tracking` (
  `ida` int(11) NOT NULL,
  `idu` int(11) DEFAULT NULL,
  `action` char(33) DEFAULT NULL,
  `actionSecondary` varchar(33) DEFAULT NULL,
  `idu2` int(11) NOT NULL DEFAULT '0',
  `gameId` int(11) NOT NULL DEFAULT '0',
  `step` int(255) NOT NULL DEFAULT '0',
  `data` varchar(255) DEFAULT NULL,
  `timestamp` int(11) NOT NULL DEFAULT '0',
  `privacyLevel` int(3) DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `device_type` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `user_usersgroups`
--

CREATE TABLE `user_usersgroups` (
  `uid` int(11) NOT NULL,
  `idgroup` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `avatars`
--
ALTER TABLE `avatars`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `sex` (`sex`),
  ADD KEY `invisble` (`invisble`),
  ADD KEY `propertyUid` (`propertyUid`),
  ADD KEY `creatorUid` (`creatorUid`),
  ADD KEY `publicWannabe` (`publicWannabe`);

--
-- Indici per le tabelle `email_validation`
--
ALTER TABLE `email_validation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `editedts` (`editedts`),
  ADD KEY `email` (`email`),
  ADD KEY `code` (`code`),
  ADD KEY `validatets` (`validatets`);

--
-- Indici per le tabelle `family`
--
ALTER TABLE `family`
  ADD PRIMARY KEY (`family`),
  ADD UNIQUE KEY `secret` (`secret`);

--
-- Indici per le tabelle `fonts`
--
ALTER TABLE `fonts`
  ADD PRIMARY KEY (`file`);

--
-- Indici per le tabelle `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`gameId`),
  ADD KEY `usr_female_avatar_id` (`usr_female_avatar_id`),
  ADD KEY `usr_male_avatar_id` (`usr_male_avatar_id`),
  ADD KEY `title` (`title`),
  ADD KEY `language` (`language`);

--
-- Indici per le tabelle `games_spread`
--
ALTER TABLE `games_spread`
  ADD PRIMARY KEY (`idSpread`),
  ADD UNIQUE KEY `gameSpread` (`gameId`,`spread`),
  ADD KEY `gameId` (`gameId`);

--
-- Indici per le tabelle `games_steps`
--
ALTER TABLE `games_steps`
  ADD PRIMARY KEY (`idStep`),
  ADD UNIQUE KEY `gameStepScene` (`gameId`,`step`,`scene`) USING BTREE,
  ADD KEY `gameId` (`gameId`),
  ADD KEY `state` (`step`),
  ADD KEY `scenario_id` (`scenario_id`),
  ADD KEY `avatar_id` (`avatar_id`),
  ADD KEY `avatar_pos_id` (`avatar_size`);

--
-- Indici per le tabelle `games_steps_attachments`
--
ALTER TABLE `games_steps_attachments`
  ADD PRIMARY KEY (`idAttachment`),
  ADD KEY `gameId` (`gameId`),
  ADD KEY `state` (`step`),
  ADD KEY `gameIdStep` (`gameId`,`step`),
  ADD KEY `scene` (`scene`);

--
-- Indici per le tabelle `game_family`
--
ALTER TABLE `game_family`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gameId` (`gameId`),
  ADD KEY `family` (`family`);

--
-- Indici per le tabelle `game_usersgroups`
--
ALTER TABLE `game_usersgroups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idgroup` (`idgroup`),
  ADD KEY ` idgym` (`gameId`);

--
-- Indici per le tabelle `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`idm`),
  ADD KEY `gameId` (`gameId`),
  ADD KEY `uid` (`uid`),
  ADD KEY `start` (`start`);

--
-- Indici per le tabelle `matches_step`
--
ALTER TABLE `matches_step`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idm` (`idm`),
  ADD KEY `step` (`step`),
  ADD KEY `scene` (`scene`);

--
-- Indici per le tabelle `plang`
--
ALTER TABLE `plang`
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `name` (`name`) USING BTREE,
  ADD KEY `vis` (`usr`),
  ADD KEY `edt` (`edt`);

--
-- Indici per le tabelle `scenarios`
--
ALTER TABLE `scenarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invisble` (`invisble`),
  ADD KEY `propertyUid` (`propertyUid`),
  ADD KEY `creatorUid` (`creatorUid`),
  ADD KEY `publicWannabe` (`publicWannabe`),
  ADD KEY `name` (`name`) USING BTREE;

--
-- Indici per le tabelle `scenarios_used`
--
ALTER TABLE `scenarios_used`
  ADD PRIMARY KEY (`idl`),
  ADD UNIQUE KEY `unic` (`uid`,`scenario_id`),
  ADD KEY `date_up` (`date_up`);

--
-- Indici per le tabelle `TTSvoices`
--
ALTER TABLE `TTSvoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nick` (`nick`),
  ADD KEY `gender` (`gender`),
  ADD KEY `voiceName` (`voiceName`),
  ADD KEY `langCode` (`langCode`),
  ADD KEY `type` (`type`),
  ADD KEY `language` (`language`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`),
  ADD UNIQUE KEY `emailFamily` (`user_email`,`family`),
  ADD KEY `user_name` (`user_name`),
  ADD KEY `user_pass` (`user_pass`),
  ADD KEY `family` (`family`);

--
-- Indici per le tabelle `usersgroups`
--
ALTER TABLE `usersgroups`
  ADD PRIMARY KEY (`idgroup`),
  ADD KEY `createts` (`createts`),
  ADD KEY `editedts` (`editedts`),
  ADD KEY `name` (`name`);

--
-- Indici per le tabelle `usersgroups_insighters`
--
ALTER TABLE `usersgroups_insighters`
  ADD PRIMARY KEY (`idr`),
  ADD KEY `idgroup` (`idgroup`),
  ADD KEY `uid` (`uid`);

--
-- Indici per le tabelle `user_tracking`
--
ALTER TABLE `user_tracking`
  ADD PRIMARY KEY (`ida`),
  ADD KEY `idu` (`idu`),
  ADD KEY `action` (`action`),
  ADD KEY `actionSecondary` (`actionSecondary`),
  ADD KEY `timestamp` (`timestamp`),
  ADD KEY `gameId` (`gameId`);

--
-- Indici per le tabelle `user_usersgroups`
--
ALTER TABLE `user_usersgroups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idgroup` (`idgroup`),
  ADD KEY `uid` (`uid`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `avatars`
--
ALTER TABLE `avatars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1038;

--
-- AUTO_INCREMENT per la tabella `email_validation`
--
ALTER TABLE `email_validation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `games`
--
ALTER TABLE `games`
  MODIFY `gameId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `games_spread`
--
ALTER TABLE `games_spread`
  MODIFY `idSpread` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `games_steps`
--
ALTER TABLE `games_steps`
  MODIFY `idStep` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `games_steps_attachments`
--
ALTER TABLE `games_steps_attachments`
  MODIFY `idAttachment` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `game_family`
--
ALTER TABLE `game_family`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `game_usersgroups`
--
ALTER TABLE `game_usersgroups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `matches`
--
ALTER TABLE `matches`
  MODIFY `idm` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `matches_step`
--
ALTER TABLE `matches_step`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `plang`
--
ALTER TABLE `plang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1649;

--
-- AUTO_INCREMENT per la tabella `scenarios`
--
ALTER TABLE `scenarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT per la tabella `scenarios_used`
--
ALTER TABLE `scenarios_used`
  MODIFY `idl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `TTSvoices`
--
ALTER TABLE `TTSvoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=369;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `usersgroups`
--
ALTER TABLE `usersgroups`
  MODIFY `idgroup` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `usersgroups_insighters`
--
ALTER TABLE `usersgroups_insighters`
  MODIFY `idr` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `user_tracking`
--
ALTER TABLE `user_tracking`
  MODIFY `ida` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `user_usersgroups`
--
ALTER TABLE `user_usersgroups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
