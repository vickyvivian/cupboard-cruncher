<?php

$formSubmitted = isset($_POST['add']);
$recipeAdded   = false;
$errors = array();

if ($formSubmitted) {
    // Validate recipe input
    if (empty($_POST['name']) || strlen($_POST['name']) > 190) {
        $errors['name'] = 'Please supply a valid recipe name.';
    }
    
    if (empty($_POST['serves']) || !ctype_digit($_POST['serves'])) {
        $errors['serves'] = 'How many people does this recipe serve?';
    }
 
    if (!empty($_POST['prepare']) && !ctype_digit($_POST['prepare'])) {
        $errors['prepare'] = 'How many minutes does this recipe take to prepare?';
    }
 
    if (!empty($_POST['cook']) && !ctype_digit($_POST['cook'])) {
        $errors['cook'] = 'How many minutes does this recipe take to cook?';
    }

    if (empty($_POST['method'])) {
        $errors['method'] = 'Please provide a method for this recipe.';
    }
    
    if (empty($_POST['ingredients'])) {
        $errors['ingredients'] = 'Please provide the ingredients for this recipe.';
    }
    
    $ingredients = array_map('trim', explode("\n", $_POST['ingredients']));    
    // check that each row contains a quantity
    foreach ($ingredients as $ingredient) {
        if (strpos($ingredient, ',') === false) {
            $errors['ingredients'] = 'Please provide a quantity for each ingredient.';
            break;
        }
    }
 
    if (empty($errors)) {
        $clean['name']    = $_POST['name'];
        $clean['serves']  = $_POST['serves'];
        $clean['prepare'] = (empty($_POST['prepare'])) ? 0 : $_POST['prepare'];
        $clean['cook']    = (empty($_POST['cook'])) ? 0 : $_POST['cook'];
        $clean['method']  = $_POST['method'];
        foreach ($ingredients as $ingredient) {
            list($name, $quantity) =  array_map('trim', explode(",", $ingredient));
            $clean['ingredients'][] = array('name' => $name, 'quantity' => $quantity);
        }

        // Insert recipe
        $sql = "INSERT INTO recipe (`name`, `method`, `serves`, `prepare_minutes`, `cook_minutes`) 
                VALUES (:name, :method, :serves, :prepare, :cook)";
        $stm = $db->prepare($sql);
        $stm->execute(
            array(
                ':name'    => $clean['name'],
                ':method'  => $clean['method'],
                ':serves'  => $clean['serves'],
                ':prepare' => $clean['prepare'],
                ':cook'    => $clean['cook'],
            )
        );
        $recipeId = $db->lastinsertid();
        
        foreach ($clean['ingredients'] as $ingredient) {
            // Check whether ingredient exists
            $query = "
                SELECT id
                  FROM `ingredient` i 
                 WHERE i.`name` = :name;
            ";

            $stm = $db->prepare($query);
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            $stm->execute(array(':name' => $ingredient['name']));
            $ingredientId = $stm->fetchColumn();
            
            // if ingredient does not already exist
            if (!$ingredientId) {
                // insert new ingredient
                $sql = "INSERT INTO ingredient (`name`) VALUES (:name)";
                $stm = $db->prepare($sql);
                $stm->execute(array(':name' => $ingredient['name']));
                $ingredientId = $db->lastinsertid();
            }

            // Link recipe to ingredient
            $sql = "INSERT INTO recipe_ingredient (`recipe_id`, `ingredient_id`, `quantity`) VALUES (:recipeId, :ingredientId, :quantity)";
            $stm = $db->prepare($sql);
            $stm->execute(array(':recipeId' => $recipeId, ':ingredientId' => $ingredientId, ':quantity' => $ingredient['quantity']));
        }
        $recipeAdded = true;
    }
}
?>

<?php if ($recipeAdded) : ?>
<div class="bright-box shadow rounded center standard-border">
  <h1>Recipe Saved</h1>
  <p>Your recipe was successfully added, thank you.</p>
</div>
<?php else : ?>

<form id='add-form' class="bright-box shadow rounded center standard-border" action='/add' method='post'>
  <h1>Add your recipe</h1>
  <?php 
      if (!empty($errors)) {
          echo '<p class="error">There are issues with your submission</p>';
          echo '<ul class="error">';
          foreach ($errors as $field => $error) {
              echo "<li>{$error}</li>";
          }
          echo '</ul>';
      }
  ?>
  <table>
    <tr>
      <td><label for='name'>Recipe Name</label></td>
      <td><input type='text' id="name" name='name' value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>" /></td>
    </tr>
    <tr>
      <td><label for='serves'>Serves</label></td>
      <td><input type='text' id="serves" name='serves' value='<?php if (isset($_POST['serves'])) echo $_POST['serves']; ?>' /></td>
    </tr>
    <tr>
      <td><label for='prepare'>Prepare Minutes</label></td>
      <td><input type='text' id="prepare" name='prepare' value='<?php if (isset($_POST['prepare'])) echo $_POST['prepare']; ?>' /></td>
    </tr>
    <tr>
      <td><label for='cook'>Cook Minutes</label></td>
      <td><input type='text' id="cook" name='cook' value='<?php if (isset($_POST['cook'])) echo $_POST['cook']; ?>' /></td>
    </tr>
    <tr>
      <td><label for='method'>Method</label></td>
      <td><textarea  id="method" name='method' rows="5" cols="30"><?php if (isset($_POST['method'])) echo $_POST['method']; ?></textarea></td>
    </tr>
    <tr>
      <td><label for='ingredients'>Ingredients</label><br />(One per line: Ingredient, quantity)</td>
      <td><textarea  id="ingredients" name='ingredients' rows="5" cols="30"><?php if (isset($_POST['ingredients'])) echo $_POST['ingredients']; ?></textarea></td>
    </tr>
    <tr>
      <td colspan="2"><input type='submit' name="add" value='Add' /></td>
    </tr>
  </table>
</form>
<?php endif ?>
