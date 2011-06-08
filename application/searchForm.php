
<form id='search-form' class="shadow rounded center standard-border" action='?' method='post'>
    <h1 id="logo">Cupboard Cruncher</h1>
    <p><em>Find recipes containing...</em></p> 
    <input type='text' id="ingredient" name='ingredient' value='<?php echo $requestedIngredients; ?>' />
    <input type='submit' name="search" value='Search' />
</form>

