<?php
error_reporting(-1);

require_once('config/app.php');

try {
    $db = new PDO("mysql:host={$config['db']['hostname']};dbname={$config['db']['database']}", $config['db']['username'], $config['db']['password']);
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    error_log('Db Connection failure: ' . $e->getMessage());
}

$ingredient = (isset($_POST['ingredient'])) ? $_POST['ingredient'] : 'Cucumber';

$stm = $db->query("
    SELECT 
        r.name AS recipe_name,
        r.method,
        r.cook_minutes,
        r.prepare_minutes,
        r.serves,
        i.name AS ingredient_name,
        ri.quantity
    FROM  
        `recipe` r, 
        `ingredient` i, 
        `recipe_ingredient` ri
    WHERE 
        r.`id` IN (
            SELECT r.`id`
            FROM `recipe` r, `ingredient` i, `recipe_ingredient` ri
            WHERE i.`name` LIKE '%{$ingredient}%'
            AND r.`id` = ri.`recipe_id`
            AND i.`id` = ri.`ingredient_id`
        )
    AND r.`id` = ri.`recipe_id` 
    AND i.`id` = ri.`ingredient_id`
");

$stm->setFetchMode(PDO::FETCH_ASSOC);

$recipe = $stm->fetchAll();
$recipeDetail = $recipe[0];

echo "<form action='?' method='post'>Showing recipes containing <input type='text' name='ingredient' value='" . $ingredient. "' /></form>";
echo "<em>Showing recipes containing " . $ingredient. "</em>";
echo "<h2>" . $recipeDetail['recipe_name'] . "</h2>";
echo "<ul>"; 
echo "<li>Serves " . $recipeDetail['serves'] . "</li>";
echo "<li>Preparation time: " . $recipeDetail['prepare_minutes'] . " minutes</li>";
echo "<li>Cooking time: " . $recipeDetail['cook_minutes'] . " minutes</li>";
echo "</ul>";

echo "<ul>"; 
foreach ($recipe as $ingredient) {
    echo "<li>" . $ingredient['quantity'] . ' ' . $ingredient['ingredient_name'] . "</li>";
} 
echo "</ul>";

echo "<p>" . nl2br($recipeDetail['method']) . "</p>";
