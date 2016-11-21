# LOG
CREATE TABLE `log` (
    `log_id` INT(11) NOT NULL,
    `log_user` INT(11) NOT NULL COMMENT 'user ID',
    `log_action` ENUM('INSERT', 'UPDATE', 'DELETE', 'SELECT') NOT NULL,
    `log_effect` INT(11) DEFAULT NULL,
    `log_type` ENUM('foreigner', 'user', 'visits', 'status', 'category') NOT NULL,
    `log_date` DATETIME NOT NULL
)  ENGINE=MYISAM DEFAULT CHARSET=LATIN1;

# Users
CREATE TABLE `users` (
    `id` TINYINT(4) NOT NULL,
    `username` VARCHAR(100) NOT NULL,
    `password` VARCHAR(100) NOT NULL,
    `loc_id` INT(11) NOT NULL
)  ENGINE=MYISAM DEFAULT CHARSET=LATIN1;

# Visits
CREATE TABLE `visits` (
    `vis_id` INT(11) NOT NULL,
    `vis_foreigner` INT(11) NOT NULL,
    `vis_date` DATE NOT NULL,
    `vis_publisher` VARCHAR(255) DEFAULT NULL,
    `vis_description` VARCHAR(500) DEFAULT NULL
)  ENGINE=MYISAM DEFAULT CHARSET=LATIN1;

# Status
CREATE TABLE `status` (
    `sta_id` INT(11) NOT NULL,
    `sta_name` VARCHAR(255) NOT NULL
)  ENGINE=MYISAM DEFAULT CHARSET=LATIN1;

# Backups
CREATE TABLE `backup` (
    `bac_id` INT(11) NOT NULL,
    `bac_date` DATETIME NOT NULL
)  ENGINE=MYISAM DEFAULT CHARSET=LATIN1;

# Country
CREATE TABLE `country` (
    `id` INT(11) NOT NULL,
    `name` VARCHAR(255) NOT NULL
)  ENGINE=MYISAM DEFAULT CHARSET=LATIN1;

# Category
CREATE TABLE `category` (
    `cat_id` INT(11) NOT NULL,
    `cat_name` VARCHAR(45) NOT NULL,
    `cat_color` VARCHAR(45) NOT NULL
)  ENGINE=MYISAM DEFAULT CHARSET=LATIN1;

# Contry on HTML
CREATE TABLE `countryp` (
    `id` INT(11) NOT NULL,
    `name` VARCHAR(255) NOT NULL
)  ENGINE=MYISAM DEFAULT CHARSET=LATIN1;

# Location
CREATE TABLE `location` (
    `loc_id` INT(11) NOT NULL COMMENT 'Foreign Ident. for the group or congregation',
    `loc_name` VARCHAR(255) NOT NULL COMMENT 'Name of the group or congregation',
    `loc_type` TINYINT(4) NOT NULL COMMENT '0 for Group
        1 for Congregation',
    `loc_place` VARCHAR(255) NOT NULL COMMENT 'Place of the Group or Congregation',
    `loc_coord` VARCHAR(255) NOT NULL
)  ENGINE=MYISAM DEFAULT CHARSET=LATIN1;

# Foreigner (Main table)
CREATE TABLE `foreigner` (
    `for_id` INT(11) NOT NULL,
    `for_name` VARCHAR(255)CHARACTER SET LATIN1 DEFAULT NULL,
    `for_nationality` INT(11) DEFAULT NULL,
    `for_route` VARCHAR(255)CHARACTER SET LATIN1 DEFAULT NULL,
    `for_street_number` INT(5) DEFAULT NULL,
    `for_sublocality` VARCHAR(255)CHARACTER SET LATIN1 DEFAULT NULL,
    `for_complement` VARCHAR(255)CHARACTER SET LATIN1 DEFAULT NULL,
    `for_telephone` VARCHAR(255)CHARACTER SET LATIN1 DEFAULT NULL,
    `for_locality` VARCHAR(255)CHARACTER SET LATIN1 DEFAULT NULL,
    `for_location` VARCHAR(255)CHARACTER SET LATIN1 NOT NULL,
    `for_bitly` VARCHAR(255) DEFAULT NULL,
    `sta_id` INT(11) NOT NULL,
    `cat_id` INT(11) NOT NULL
)  ENGINE=MYISAM DEFAULT CHARSET=UTF8;

# Publishers
CREATE TABLE `publishers` (
    `pub_iden` INT(11) NOT NULL,
    `pub_name` VARCHAR(255) NOT NULL
)  ENGINE=MYISAM DEFAULT CHARSET=LATIN1;

# FieldSearch
CREATE TABLE `fieldsearch` (
    `fie_id` INT(11) NOT NULL,
    `fie_foreigner` INT(11) NOT NULL,
    `fie_group` INT(11) NOT NULL,
    `fie_date` DATETIME NOT NULL,
    `fie_conductor` VARCHAR(255) NOT NULL
)  ENGINE=MYISAM DEFAULT CHARSET=LATIN1;

# FieldService
CREATE TABLE `fieldservice` (
    `fis_iden` INT(11) NOT NULL,
    `fis_name` VARCHAR(255) NOT NULL
)  ENGINE=MYISAM DEFAULT CHARSET=LATIN1;

# Persinal Users
CREATE TABLE `personal_users` (
    `pus_iden` INT(11) NOT NULL,
    `pus_stts` INT(1) NOT NULL,
    `pus_mail` VARCHAR(255) NOT NULL,
    `pus_name` VARCHAR(255) NOT NULL,
    `pus_pass` VARCHAR(255) NOT NULL
)  ENGINE=MYISAM DEFAULT CHARSET=LATIN1;

# Personal reserved (Return Visits)
CREATE TABLE `personal_reserved` (
    `per_iden` INT(11) NOT NULL,
    `per_chck` DATETIME DEFAULT NULL,
    `pub_iden` INT(11) NOT NULL,
    `for_id` INT(11) NOT NULL
)  ENGINE=MYISAM DEFAULT CHARSET=LATIN1;

# Personal Territories
CREATE TABLE `personal_territories` (
    `pet_iden` INT(11) NOT NULL,
    `pet_user` INT(11) NOT NULL,
    `pet_fore` INT(11) NOT NULL,
    `pet_desc` TEXT,
    `pet_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `pet_rnew` VARCHAR(3) NOT NULL DEFAULT 'No'
)  ENGINE=MYISAM DEFAULT CHARSET=LATIN1;

# FieldSerice Foreigners
CREATE TABLE `fieldservice_foreigner` (
    `fif_iden` INT(11) NOT NULL,
    `fif_fieldservice` INT(11) NOT NULL,
    `fif_foreigner` INT(11) NOT NULL
)  ENGINE=MYISAM DEFAULT CHARSET=LATIN1;

# FieldSerice Assignments
CREATE TABLE `fieldservice_assignments` (
    `fia_iden` INT(11) NOT NULL,
    `fis_iden` INT(11) NOT NULL,
    `fia_date` DATETIME NOT NULL,
    `fia_cond` VARCHAR(255) NOT NULL,
    `fia_fore` VARCHAR(255) NOT NULL
)  ENGINE=MYISAM DEFAULT CHARSET=LATIN1;

# Primary Key Mappings
ALTER TABLE `log` ADD PRIMARY KEY (`log_id`);
ALTER TABLE `users` ADD PRIMARY KEY (`id`);
ALTER TABLE `visits` ADD PRIMARY KEY (`vis_id`);
ALTER TABLE `status` ADD PRIMARY KEY (`sta_id`);
ALTER TABLE `backup` ADD PRIMARY KEY (`bac_id`);
ALTER TABLE `country` ADD PRIMARY KEY (`id`);
ALTER TABLE `category` ADD PRIMARY KEY (`cat_id`);
ALTER TABLE `location` ADD PRIMARY KEY (`loc_id`);
ALTER TABLE `countryp` ADD PRIMARY KEY (`id`);
ALTER TABLE `foreigner` ADD PRIMARY KEY (`for_id`);
ALTER TABLE `publishers` ADD PRIMARY KEY (`pub_iden`);
ALTER TABLE `fieldsearch` ADD PRIMARY KEY (`fie_id`);
ALTER TABLE `fieldservice` ADD PRIMARY KEY (`fis_iden`);
ALTER TABLE `personal_users` ADD PRIMARY KEY (`pus_iden`), ADD UNIQUE KEY `pus_iden_UNIQUE` (`pus_iden`);
ALTER TABLE `personal_reserved` ADD PRIMARY KEY (`per_iden`);
ALTER TABLE `personal_territories` ADD PRIMARY KEY (`pet_iden`), ADD UNIQUE KEY `pet_iden_UNIQUE` (`pet_iden`);
ALTER TABLE `fieldservice_foreigner` ADD PRIMARY KEY (`fif_iden`);
ALTER TABLE `fieldservice_assignments` ADD PRIMARY KEY (`fia_iden`);

# Counties insertions
INSERT INTO `country` (`id`, `name`) VALUES(1, 'Afghanistan'),(2, 'South Africa'),(3, 'Akrotiri'),(4, 'Albania'),(5, 'Germany'),(6, 'Andorra'),(7, 'Angola'),(8, 'Anguilla'),(9, 'Antarctica'),(10, 'Antigua and Barbuda'),(11, 'Netherlands Antilles'),(12, 'Saudi Arabia'),(13, 'Arctic Ocean'),(14, 'Algeria'),(15, 'Argentina'),(16, 'Armenia'),(17, 'Aruba'),(18, 'Ashmore and Cartier Islands'),(19, 'Atlantic Ocean'),(20, 'Australia'),(21, 'Austria'),(22, 'Azerbaijan'),(23, 'Bahamas'),(24, 'Bangladesh'),(25, 'Barbados'),(26, 'Bahrain'),(27, 'Belgium'),(28, 'Belize'),(29, 'Benin'),(30, 'Bermuda'),(31, 'Belarus'),(32, 'Burma'),(33, 'Bolivia'),(34, 'BiH'),(35, 'Botswana'),(36, 'Brazil'),(37, 'Brunei'),(38, 'Bulgaria'),(39, 'Burkina Faso'),(40, 'Burundi'),(41, 'Bhutan'),(42, 'Cape Verde'),(43, 'Cameroon'),(44, 'Cambodia'),(45, 'Canada'),(46, 'Qatar'),(47, 'Kazakhstan'),(48, 'Chad'),(49, 'Chilean'),(50, 'Chinese'),(51, 'Cyprus'),(52, 'Clipperton Island'),(53, 'Colombia'),(54, 'the Comoros'),(55, 'Congo'),(56, 'Congo-Kinshasa'),(57, 'Coral Sea Islands'),(58, 'North Korea'),(59, 'South Korea'),(60, 'Ivory Coast'),(61, 'Costa Rica'),(62, 'Croatia'),(63, 'Cuba'),(64, 'Dhekelia'),(65, 'Denmark'),(66, 'Dominica'),(67, 'Egypt'),(68, 'UAE'),(69, 'Ecuador'),(70, 'Eritrea'),(71, 'Slovakia'),(72, 'Slovenia'),(73, 'Spain'),(74, 'US'),(75, 'Estonia'),(76, 'Ethiopia'),(77, 'Faroe'),(78, 'Fiji'),(79, 'Philippines'),(80, 'Finland'),(81, 'France'),(82, 'Gabon'),(83, 'Gambia'),(84, 'Ghana'),(85, 'Gaza Strip'),(86, 'Georgia'),(87, 'South Georgia and South Sandwich'),(88, 'Gibraltar'),(89, 'Granada'),(90, 'Greek'),(91, 'Greenland'),(92, 'Guam'),(93, 'Guatemala'),(94, 'Guernsey'),(95, 'Guiana'),(96, 'Guinea'),(97, 'Equatorial Guinea'),(98, 'Guinea-Bissau'),(99, 'Haiti'),(100, 'Honduras'),(101, 'Hong Kong'),(102, 'Hungary'),(103, 'Yemen'),(104, 'Bouvet Island'),(105, 'Christmas Island'),(106, 'Norfolk Island'),(107, 'Cayman Islands'),(108, 'Cook Islands'),(109, 'Cocos'),(110, 'Falkland Islands'),(111, 'Heard and McDonald Islands'),(112, 'Marshall Islands'),(113, 'Solomon Islands'),(114, 'Turks and Caicos'),(115, 'Virgin Islands'),(116, 'BVI'),(117, 'India'),(118, 'Indian Ocean'),(119, 'Indonesia'),(120, 'Iran'),(121, 'Iraq'),(122, 'Ireland'),(123, 'Iceland'),(124, 'Israel'),(125, 'Italy'),(126, 'Jamaica'),(127, 'Jan Mayen'),(128, 'Japan'),(129, 'Jersey'),(130, 'Djibouti'),(131, 'Jordan'),(132, 'Kuwait'),(133, 'Lao'),(134, 'Lesotho'),(135, 'Latvia'),(136, 'Lebanon'),(137, 'Liberia'),(138, 'Libyan'),(139, 'Liechtenstein'),(140, 'Lithuania'),(141, 'Luxembourg'),(142, 'Macau'),(143, 'Macedonia'),(144, 'Madagascar'),(145, 'Malaysia'),(146, 'Malawi'),(147, 'Maldives'),(148, 'Mali'),(149, 'Malta'),(150, 'Man, Isle of'),(151, 'Marian North'),(152, 'Morocco'),(153, 'Mauritius'),(154, 'Mauritania'),(155, 'Mayotte'),(156, 'Mexico'),(157, 'Micronesia'),(158, 'Mozambique'),(159, 'Moldova'),(160, 'Monaco'),(161, 'Mongolia'),(162, 'Montserrat'),(163, 'Montenegro'),(164, 'World'),(165, 'Namibia'),(166, 'Nauru'),(167, 'Navassa Island'),(168, 'Nepal'),(169, 'Nicaragua'),(170, 'Niger'),(171, 'Nigeria'),(172, 'Niue'),(173, 'Norwegian'),(174, 'New Caledonia'),(175, 'New Zealand'),(176, 'Oman'),(177, 'Pacific Ocean'),(178, 'Netherlands'),(179, 'Palau'),(180, 'Panama'),(181, 'Papua New Guinea'),(182, 'Pakistan'),(183, 'Paracel Islands'),(184, 'America'),(185, 'Peru'),(186, 'Pitcairn'),(187, 'French Polynesia'),(188, 'Poland'),(189, 'Puerto Rico'),(190, 'Portugal'),(191, 'Kenya'),(192, 'Kyrgyz'),(193, 'Kiribati'),(194, 'UK'),(195, 'Central African Republic'),(196, 'Czech Republic'),(197, 'Dominican Republic'),(198, 'Romania'),(199, 'Rwanda'),(200, 'Russia'),(201, 'Savior'),(202, 'Samoa'),(203, 'American Samoa'),(204, 'St. Helena'),(205, 'Santa Lucia'),(206, 'Saint Kitts and Nevis'),(207, 'San Marino'),(208, 'Saint Pierre and Miquelon'),(209, 'Sao Tome and Principe'),(210, 'St. Vincent and the Grenadines'),(211, 'Sahara'),(212, 'Seychelles'),(213, 'Senegal'),(214, 'Sierra Leone'),(215, 'Serbia'),(216, 'Singapore'),(217, 'Syria'),(218, 'Somalia'),(219, 'Southern Ocean'),(220, 'Spratly Islands'),(221, 'Sri Lanka'),(222, 'Swaziland'),(223, 'Sudan'),(224, 'Sweden'),(225, 'Switzerland'),(226, 'Suriname'),(227, 'Svalbard and Jan Mayen'),(228, 'Thailand'),(229, 'Taiwan'),(230, 'Tajikistan'),(231, 'Tanzania'),(232, 'British Indian Ocean Territory'),(233, 'French Southern Territories'),(234, 'East Timor'),(235, 'Togo'),(236, 'Tokelau'),(237, 'Tonga'),(238, 'Trinidad and Tobago'),(239, 'Tunisia'),(240, 'Turkmenistan'),(241, 'Turkey'),(242, 'Tuvalu'),(243, 'Ukraine'),(244, 'Uganda'),(245, 'EU'),(246, 'Uruguay'),(247, 'Uzbekistan'),(248, 'Vanuatu'),(249, 'Vatican'),(250, 'Venezuela'),(251, 'Vietnam'),(252, 'Wake Island'),(253, 'Wallis and Futuna'),(254, 'West Bank'),(255, 'Zambia'),(256, 'Zimbabwe');
INSERT INTO `countryp` (`id`, `name`) VALUES(1, 'Afeganist&atilde;o'),(2, '&Aacute;frica do Sul'),(3, 'Akrotiri'),(4, 'Alb&acirc;nia'),(5, 'Alemanha'),(6, 'Andorra'),(7, 'Angola'),(8, 'Anguila'),(9, 'Ant&aacute;rctida'),(10, 'Ant&iacute;gua e Barbuda'),(11, 'Antilhas Neerlandesas'),(12, 'Ar&aacute;bia Saudita'),(13, 'Arctic Ocean'),(14, 'Arg&eacute;lia'),(15, 'Argentina'),(16, 'Arm&eacute;nia'),(17, 'Aruba'),(18, 'Ashmore and Cartier Islands'),(19, 'Atlantic Ocean'),(20, 'Austr&aacute;lia'),(21, '&Aacute;ustria'),(22, 'Azerbaij&atilde;o'),(23, 'Baamas'),(24, 'Bangladeche'),(25, 'Barbados'),(26, 'Bar&eacute;m'),(27, 'B&eacute;lgica'),(28, 'Belize'),(29, 'Benim'),(30, 'Bermudas'),(31, 'Bielorr&uacute;ssia'),(32, 'Birm&acirc;nia'),(33, 'Bol&iacute;via'),(34, 'B&oacute;snia e Herzegovina'),(35, 'Botsuana'),(36, 'Brasil'),(37, 'Brunei'),(38, 'Bulg&aacute;ria'),(39, 'Burquina Faso'),(40, 'Bur&uacute;ndi'),(41, 'But&atilde;o'),(42, 'Cabo Verde'),(43, 'Camar&otilde;es'),(44, 'Camboja'),(45, 'Canad&aacute;'),(46, 'Catar'),(47, 'Cazaquist&atilde;o'),(48, 'Chade'),(49, 'Chile'),(50, 'China'),(51, 'Chipre'),(52, 'Clipperton Island'),(53, 'Col&ocirc;mbia'),(54, 'Comores'),(55, 'Congo-Brazzaville'),(56, 'Congo-Kinshasa'),(57, 'Coral Sea Islands'),(58, 'Coreia do Norte'),(59, 'Coreia do Sul'),(60, 'Costa do Marfim'),(61, 'Costa Rica'),(62, 'Cro&aacute;cia'),(63, 'Cuba'),(64, 'Dhekelia'),(65, 'Dinamarca'),(66, 'Dom&iacute;nica'),(67, 'Egipto'),(68, 'Emiratos &Aacute;rabes Unidos'),(69, 'Equador'),(70, 'Eritreia'),(71, 'Eslov&aacute;quia'),(72, 'Eslov&eacute;nia'),(73, 'Espanha'),(74, 'Estados Unidos'),(75, 'Est&oacute;nia'),(76, 'Eti&oacute;pia'),(77, 'Faro&eacute;'),(78, 'Fiji'),(79, 'Filipinas'),(80, 'Finl&acirc;ndia'),(81, 'Fran&ccedil;a'),(82, 'Gab&atilde;o'),(83, 'G&acirc;mbia'),(84, 'Gana'),(85, 'Gaza Strip'),(86, 'Ge&oacute;rgia'),(87, 'Ge&oacute;rgia do Sul e Sandwich do Sul'),(88, 'Gibraltar'),(89, 'Granada'),(90, 'Gr&eacute;cia'),(91, 'Gronel&acirc;ndia'),(92, 'Guame'),(93, 'Guatemala'),(94, 'Guernsey'),(95, 'Guiana'),(96, 'Guin&eacute;'),(97, 'Guin&eacute; Equatorial'),(98, 'Guin&eacute;-Bissau'),(99, 'Haiti'),(100, 'Honduras'),(101, 'Hong Kong'),(102, 'Hungria'),(103, 'I&eacute;men'),(104, 'Ilha Bouvet'),(105, 'Ilha do Natal'),(106, 'Ilha Norfolk'),(107, 'Ilhas Caim&atilde;o'),(108, 'Ilhas Cook'),(109, 'Ilhas dos Cocos'),(110, 'Ilhas Falkland'),(111, 'Ilhas Heard e McDonald'),(112, 'Ilhas Marshall'),(113, 'Ilhas Salom&atilde;o'),(114, 'Ilhas Turcas e Caicos'),(115, 'Ilhas Virgens Americanas'),(116, 'Ilhas Virgens Brit&acirc;nicas'),(117, '&Iacute;ndia'),(118, 'Indian Ocean'),(119, 'Indon&eacute;sia'),(120, 'Ir&atilde;o'),(121, 'Iraque'),(122, 'Irlanda'),(123, 'Isl&acirc;ndia'),(124, 'Israel'),(125, 'It&aacute;lia'),(126, 'Jamaica'),(127, 'Jan Mayen'),(128, 'Jap&atilde;o'),(129, 'Jersey'),(130, 'Jibuti'),(131, 'Jord&acirc;nia'),(132, 'Kuwait'),(133, 'Laos'),(134, 'Lesoto'),(135, 'Let&oacute;nia'),(136, 'L&iacute;bano'),(137, 'Lib&eacute;ria'),(138, 'L&iacute;bia'),(139, 'Listenstaine'),(140, 'Litu&acirc;nia'),(141, 'Luxemburgo'),(142, 'Macau'),(143, 'Maced&oacute;nia'),(144, 'Madag&aacute;scar'),(145, 'Mal&aacute;sia'),(146, 'Mal&aacute;vi'),(147, 'Maldivas'),(148, 'Mali'),(149, 'Malta'),(150, 'Man, Isle of'),(151, 'Marianas do Norte'),(152, 'Marrocos'),(153, 'Maur&iacute;cia'),(154, 'Maurit&acirc;nia'),(155, 'Mayotte'),(156, 'M&eacute;xico'),(157, 'Micron&eacute;sia'),(158, 'Mo&ccedil;ambique'),(159, 'Mold&aacute;via'),(160, 'M&oacute;naco'),(161, 'Mong&oacute;lia'),(162, 'Monserrate'),(163, 'Montenegro'),(164, 'Mundo'),(165, 'Nam&iacute;bia'),(166, 'Nauru'),(167, 'Navassa Island'),(168, 'Nepal'),(169, 'Nicar&aacute;gua'),(170, 'N&iacute;ger'),(171, 'Nig&eacute;ria'),(172, 'Niue'),(173, 'Noruega'),(174, 'Nova Caled&oacute;nia'),(175, 'Nova Zel&acirc;ndia'),(176, 'Om&atilde;'),(177, 'Pacific Ocean'),(178, 'Pa&iacute;ses Baixos'),(179, 'Palau'),(180, 'Panam&aacute;'),(181, 'Papua-Nova Guin&eacute;'),(182, 'Paquist&atilde;o'),(183, 'Paracel Islands'),(184, 'Paraguai'),(185, 'Peru'),(186, 'Pitcairn'),(187, 'Polin&eacute;sia Francesa'),(188, 'Pol&oacute;nia'),(189, 'Porto Rico'),(190, 'Portugal'),(191, 'Qu&eacute;nia'),(192, 'Quirguizist&atilde;o'),(193, 'Quirib&aacute;ti'),(194, 'Reino Unido'),(195, 'Rep&uacute;blica Centro-Africana'),(196, 'Rep&uacute;blica Checa'),(197, 'Rep&uacute;blica Dominicana'),(198, 'Rom&eacute;nia'),(199, 'Ruanda'),(200, 'R&uacute;ssia'),(201, 'Salvador'),(202, 'Samoa'),(203, 'Samoa Americana'),(204, 'Santa Helena'),(205, 'Santa L&uacute;cia'),(206, 'S&atilde;o Crist&oacute;v&atilde;o e Neves'),(207, 'S&atilde;o Marinho'),(208, 'S&atilde;o Pedro e Miquelon'),(209, 'S&atilde;o Tom&eacute; e Pr&iacute;ncipe'),(210, 'S&atilde;o Vicente e Granadinas'),(211, 'Sara Ocidental'),(212, 'Seicheles'),(213, 'Senegal'),(214, 'Serra Leoa'),(215, 'S&eacute;rvia'),(216, 'Singapura'),(217, 'S&iacute;ria'),(218, 'Som&aacute;lia'),(219, 'Southern Ocean'),(220, 'Spratly Islands'),(221, 'Sri Lanca'),(222, 'Suazil&acirc;ndia'),(223, 'Sud&atilde;o'),(224, 'Su&eacute;cia'),(225, 'Su&iacute;&ccedil;a'),(226, 'Suriname'),(227, 'Svalbard e Jan Mayen'),(228, 'Tail&acirc;ndia'),(229, 'Taiwan'),(230, 'Tajiquist&atilde;o'),(231, 'Tanz&acirc;nia'),(232, 'Territ&oacute;rio Brit&acirc;nico do Oceano &Iacute;ndico'),(233, 'Territ&oacute;rios Austrais Franceses'),(234, 'Timor Leste'),(235, 'Togo'),(236, 'Tokelau'),(237, 'Tonga'),(238, 'Trindade e Tobago'),(239, 'Tun&iacute;sia'),(240, 'Turquemenist&atilde;o'),(241, 'Turquia'),(242, 'Tuvalu'),(243, 'Ucr&acirc;nia'),(244, 'Uganda'),(245, 'Uni&atilde;o Europeia'),(246, 'Uruguai'),(247, 'Usbequist&atilde;o'),(248, 'Vanuatu'),(249, 'Vaticano'),(250, 'Venezuela'),(251, 'Vietname'),(252, 'Wake Island'),(253, 'Wallis e Futuna'),(254, 'West Bank'),(255, 'Z&acirc;mbia'),(256, 'Zimbabu&eacute;');