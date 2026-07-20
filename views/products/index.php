<?php include 'views/layout/header.php'; ?>
<main>
    <h1>Menu List</h1>


    <section>
        <h2>Menu</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
            </tr>
            <?php foreach ($items as $item) : ?>
            <tr>
                <td><?php echo $item['name']; ?></td>
                <td><?php echo $item['description']; ?></td>
                <td><?php echo $item['price']; ?></td>
            </a>
            </tr>
            <?php endforeach; ?>
        </table>
    </section>

</main>

<?php include 'views/layout/footer.php' ?>
