<?php
include_once 'makeDB.php';

?>
    <form action="." method="post">
        <input type="hidden" name="action" value="init_DB">
        <input type="submit" name="createDB" value="Generate tables">
    </form>
