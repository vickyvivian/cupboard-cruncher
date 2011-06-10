<?php

$requestedIngredients = (isset($_POST['ingredient'])) ? $_POST['ingredient'] : '';

// Convert comma string into array
$ingredients = explode(',', $requestedIngredients); 
$ingredients = array_map('trim', $ingredients);
$ingredients = array_filter($ingredients);

require_once('searchForm.php');

if (!empty($ingredients)) {
    // preserve requested ingredient array
    $requiredIngredients = $ingredients;

    $ingredientFilter = " `name` LIKE '%" . array_shift($ingredients) . "%' ";
    foreach ($ingredients as $ingredient) {
        $ingredientFilter .= " OR `name` LIKE '%" . $ingredient . "%' ";
    }

    $query = "
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
                WHERE i.id IN (
 		    SELECT id 
                    FROM ingredient 
                    WHERE {$ingredientFilter}
                )     

                AND r.`id` = ri.`recipe_id`
                AND i.`id` = ri.`ingredient_id`
            )
        AND r.`id` = ri.`recipe_id` 
        AND i.`id` = ri.`ingredient_id`
    ";

    $stm = $db->query($query);

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
        
        $recipes[$row['recipe_id']]['ingredient-check'][] = $row['ingredient_name'];
    }
    
    // Score recipes based on ingredient match
    $requiredIngredientNumber = count($requiredIngredients);
    foreach ($recipes as $recipeId => $recipe) {
        $matchedIngredientNumber = count(array_uintersect($requiredIngredients, $recipe['ingredient-check'], 'strcasecmp'));
 
        $matchDistance = abs($requiredIngredientNumber - $matchedIngredientNumber);
        // if we failed to exactly match any ingredient 
        if ($matchDistance == $requiredIngredientNumber) {
            // We don't want to show 0% so default to 10
            $matchPercent = 10;
        } else {
            // We matched some ingredients so show percentage matched
            $matchPercent  = floor((($requiredIngredientNumber - $matchDistance) / $requiredIngredientNumber) * 100);
        }
        $recipes[$recipeId]['match-percent']  = $matchPercent;
    }

    uasort($recipes, 'compare_match_percent');

    require_once('recipeList.php');
}

function compare_match_percent($a, $b) {
    if ($a['match-percent'] == $b['match-percent']) {
        return 0;
    }
    return ($a['match-percent'] > $b['match-percent']) ? -1 : 1;
}

