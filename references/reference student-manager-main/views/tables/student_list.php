<?php require_once(__DIR__.'/../../Config/paths.php'); ?>
<?php include VIEWS_PATH.'/layout/header.php'; ?>
<main>
    <h1>Students List</h1>


    <section>
        <h2>Students</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>Email</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($students as $student) : ?>
            <tr>
                <td><?php echo $student['studentid']; ?></td>
                <td><?php echo $student['firstname']; echo ' '; echo $student['lastname']?></td>
                <td class="center"><?php echo $student['dob']; ?></td>
                <td class="center"><?php echo $student['email']; ?></td>
                <td><a href="?action=show_edit_form&studentid=<?php echo $student['studentid']; ?>">edit</a></td>
                <td><a href="?action=delete_student&studentid=<?php echo $student['studentid']; ?>">delete</a></td>
            </a>
            </tr>
            <?php endforeach; ?>
        </table>
    </section>

</main>

<?php include VIEWS_PATH.'/layout/footer.php' ?>
