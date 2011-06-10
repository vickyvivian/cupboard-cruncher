<div id="recipe-panel" class="rounded center standard-border">
  <?php if (empty($recipes)) { ?>
    <em>No matching recipes could be found.</em>
  <?php } ?>

  <?php foreach ($recipes as $recipe) { ?>
    <div class="recipe">
      <h3>Match score <?php echo $recipe['match-percent'] ?>%</h3>
      <h2><?php echo $recipe['name'] ?></h2>
      <ul class="highlight-box shadow center"> 
        <li>Serves <?php echo $recipe['serves'] ?> </li>
        <li>Preparation time: <?php echo $recipe['prepare_minutes'] ?> minutes</li>
        <li>Cooking time: <?php echo $recipe['cook_minutes'] ?> minutes</li>
      </ul>

      <ul class="highlight-box shadow center"> 
      <?php foreach ($recipe['ingredients'] as $ingredient) { ?>
        <li> <?php echo $ingredient['quantity'] . ' ' . $ingredient['name'] ?> </li>
      <?php } ?>
      </ul>

      <p><?php echo nl2br($recipe['method']) ?></p>
    </div>
  <?php } ?>
</div>
