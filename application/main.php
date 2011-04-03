<?php
error_reporting(-1);
ini_set('display_errors', 1);

require_once('config/app.php');

try {
    $db = new PDO("mysql:host={$config['db']['hostname']};dbname={$config['db']['database']}", $config['db']['username'], $config['db']['password']);
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    error_log('Db Connection failure: ' . $e->getMessage());
}

$ingredient = (isset($_POST['ingredient'])) ? $_POST['ingredient'] : '';
require_once('searchForm.php');

if (!empty($ingredient)) {

    $stm = $db->query("
        SELECT 
            r.id as recipe_id,
            r.name AS recipe_name,
            r.method,
            r.cook_minutes,
            r.prepare_minutes,
            r.serves,
            i.name AS ingredient_name,
            i.id as ingredient_id,
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

    $recipes = array();
    while ($row = $stm->fetch()) {
        $recipes[$row['recipe_id']]['name']             = $row['recipe_name'];
        $recipes[$row['recipe_id']]['cook_minutes']     = $row['cook_minutes'];
        $recipes[$row['recipe_id']]['prepare_minutes']  = $row['prepare_minutes'];
        $recipes[$row['recipe_id']]['serves']           = $row['serves'];
        $recipes[$row['recipe_id']]['method']           = $row['method'];

        $recipes[$row['recipe_id']]['ingredients'][$row['ingredient_id']]['name'] = $row['ingredient_name'];
        $recipes[$row['recipe_id']]['ingredients'][$row['ingredient_id']]['quantity'] = $row['quantity'];
    }

    require_once('recipeList.php');
}
