
<?php if (!empty($ingredient)) { ?>
    <em>Showing recipes containing <?php echo $ingredient; ?></em>
<?php } ?>

<?php foreach ($recipes as $recipe) { ?>
    <h2><?php echo $recipe['name'] ?></h2>
    <ul> 
        <li>Serves <?php echo $recipe['serves'] ?> </li>
        <li>Preparation time: <?php echo $recipe['prepare_minutes'] ?> minutes</li>
        <li>Cooking time: <?php echo $recipe['cook_minutes'] ?> minutes</li>
    </ul>

    <ul> 
    <?php foreach ($recipe['ingredients'] as $ingredient) { ?>
        <li> <?php echo $ingredient['quantity'] . ' ' . $ingredient['name'] ?> </li>
    <?php } ?>
    </ul>

    <p><?php echo nl2br($recipe['method']) ?></p>
<?php } ?>

