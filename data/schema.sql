CREATE DATABASE `cupboard-cruncher` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `cupboard-cruncher`;

CREATE TABLE IF NOT EXISTS `ingredient` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique ingredient ID',
  `name` varchar(100) NOT NULL COMMENT 'Ingredient name',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Contains all ingredients' AUTO_INCREMENT=12 ;

INSERT INTO `ingredient` (`id`, `name`) VALUES(1, 'Cucumber');
INSERT INTO `ingredient` (`id`, `name`) VALUES(2, 'Salad onion');
INSERT INTO `ingredient` (`id`, `name`) VALUES(3, 'Coriander leaves');
INSERT INTO `ingredient` (`id`, `name`) VALUES(4, 'Mango');
INSERT INTO `ingredient` (`id`, `name`) VALUES(5, 'Lime');
INSERT INTO `ingredient` (`id`, `name`) VALUES(6, 'Sunflower oil');
INSERT INTO `ingredient` (`id`, `name`) VALUES(7, 'Crusty white bread');
INSERT INTO `ingredient` (`id`, `name`) VALUES(8, 'Cooked chicken');
INSERT INTO `ingredient` (`id`, `name`) VALUES(9, 'Chicken stock');
INSERT INTO `ingredient` (`id`, `name`) VALUES(10, 'Sour cream');
INSERT INTO `ingredient` (`id`, `name`) VALUES(11, 'Mild curry powder');

CREATE TABLE IF NOT EXISTS `recipe` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique recipe ID',
  `name` varchar(200) NOT NULL COMMENT 'Recipe name',
  `method` text NOT NULL COMMENT 'How to execute the recipe',
  `serves` int(10) unsigned NOT NULL COMMENT 'Number of people served by this recipe',
  `prepare_minutes` int(10) unsigned NOT NULL COMMENT 'Preparation time in minutes',
  `cook_minutes` int(10) unsigned NOT NULL COMMENT 'Cooking time in minutes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Contains all recipes' AUTO_INCREMENT=3 ;

INSERT INTO `recipe` (`id`, `name`, `method`, `serves`, `prepare_minutes`, `cook_minutes`) VALUES(1, 'Mango and Lime Chicken Salad', 'Cut the skinless breast fillets into bite-sized pieces and place in a large bowl.\r\n\r\nCut the cucumber in half lengthways, run a teaspoon down the centre to scoop out the seeds, then thinly slice the flesh into crescents.\r\n\r\nTrim and finely slice a bunch salad onions. Add the cucumber and salad onions to the bowl with 10g coriander leaves (chopped) and season generously.\r\n\r\nPeel the mangoes, cut the flesh away from the stones and cut into large chunks, purée in a blender or food processor with the juice of 2 limes and 1 tbsp sunflower oil, until smooth.\r\n\r\nDrizzle the salad with the mango dressing. Gently stir, so everything is coated. Serve with crusty white bread.', 4, 15, 0);
INSERT INTO `recipe` (`id`, `name`, `method`, `serves`, `prepare_minutes`, `cook_minutes`) VALUES(2, 'Chicken with Mango Sauce', 'Blend the mangoes, chicken stock, sour cream and curry powder together in a food processor for 30 seconds or until mixture is smooth.\r\n\r\nArrange the chicken pieces on individual serving plates, and pour over the mango sauce. (If desired cook some fresh pasta, mix with the chicken then pour the mango sauce over).', 4, 7, 0);

CREATE TABLE IF NOT EXISTS `recipe_ingredient` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for this ingredient/recipe relation',
  `recipe_id` int(10) unsigned NOT NULL COMMENT 'Related recipe ID',
  `ingredient_id` int(10) unsigned NOT NULL COMMENT 'Related ingredient ID',
  `quantity` varchar(50) NOT NULL COMMENT 'Quantity of ingredient for this ingredient/recipe relation',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Represents the relationship between recipes and ingredient' AUTO_INCREMENT=14 ;

INSERT INTO `recipe_ingredient` (`id`, `recipe_id`, `ingredient_id`, `quantity`) VALUES(1, 1, 8, '400g');
INSERT INTO `recipe_ingredient` (`id`, `recipe_id`, `ingredient_id`, `quantity`) VALUES(2, 1, 1, '1');
INSERT INTO `recipe_ingredient` (`id`, `recipe_id`, `ingredient_id`, `quantity`) VALUES(3, 1, 2, '1 bunch');
INSERT INTO `recipe_ingredient` (`id`, `recipe_id`, `ingredient_id`, `quantity`) VALUES(4, 1, 3, '10g');
INSERT INTO `recipe_ingredient` (`id`, `recipe_id`, `ingredient_id`, `quantity`) VALUES(5, 1, 4, '2');
INSERT INTO `recipe_ingredient` (`id`, `recipe_id`, `ingredient_id`, `quantity`) VALUES(6, 1, 5, '2');
INSERT INTO `recipe_ingredient` (`id`, `recipe_id`, `ingredient_id`, `quantity`) VALUES(7, 1, 6, '1 tablespoon');
INSERT INTO `recipe_ingredient` (`id`, `recipe_id`, `ingredient_id`, `quantity`) VALUES(8, 1, 7, '1 loaf');
INSERT INTO `recipe_ingredient` (`id`, `recipe_id`, `ingredient_id`, `quantity`) VALUES(9, 2, 8, '1 (small)');
INSERT INTO `recipe_ingredient` (`id`, `recipe_id`, `ingredient_id`, `quantity`) VALUES(10, 2, 4, '425g chopped');
INSERT INTO `recipe_ingredient` (`id`, `recipe_id`, `ingredient_id`, `quantity`) VALUES(11, 2, 9, '1/3 cup');
INSERT INTO `recipe_ingredient` (`id`, `recipe_id`, `ingredient_id`, `quantity`) VALUES(12, 2, 10, '1/3 cup');
INSERT INTO `recipe_ingredient` (`id`, `recipe_id`, `ingredient_id`, `quantity`) VALUES(13, 2, 11, '1 tsp');
