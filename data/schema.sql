CREATE DATABASE `cupboard-cruncher` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE `cupboard-cruncher`;

CREATE TABLE IF NOT EXISTS `ingredient` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique ingredient ID',
  `name` varchar(100) NOT NULL COMMENT 'Ingredient name',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contains all ingredients' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `recipe` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique recipe ID',
  `name` varchar(200) NOT NULL COMMENT 'Recipe name',
  `method` text NOT NULL COMMENT 'How to execute the recipe',
  `prepare_minutes` int(10) unsigned NOT NULL COMMENT 'Preparation time in minutes',
  `cook_minutes` int(10) unsigned NOT NULL COMMENT 'Cooking time in minutes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contains all recipes' AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `recipe_ingredient` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for this ingredient/recipe relation',
  `recipe_id` int(10) unsigned NOT NULL COMMENT 'Related recipe ID',
  `ingredient_id` int(10) unsigned NOT NULL COMMENT 'Related ingredient ID',
  `quantity` varchar(50) NOT NULL COMMENT 'Quantity of ingredient for this ingredient/recipe relation',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='REpresents the relationship between recipes and ingredient' AUTO_INCREMENT=1 ;
