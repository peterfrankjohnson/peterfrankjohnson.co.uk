<?php   $results = $database->query('SELECT * FROM request'); ?>
<?php   if($results instanceof SQLite3Result): ?>
<table>
    <tr>
        <th>ID</th>
        <th>Method</th>
        <th>Uri</th>
        <th>Query</th>
        <th>Protocol</th>
        <th>Time</th>
        <th>Headers</th>
    </tr>
<?php       while ($row = $results->fetchArray()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['method'] ?></td>
        <td><?= $row['uri']?></td>
        <td><?= $row['query']?></td>
        <td><?= $row['protocol']?></td>
        <td><?= $row['time']?></td>
        <td>
            <table>
<?php           $statement = $database->prepare( 'SELECT * FROM request_header WHERE request_id=:id' ); ?>
<?php           $statement->bindValue(':id', $row['id']); ?>
<?php           $result = $statement->execute(); ?>
<?php           while ($row = $result->fetchArray()): ?>
                <tr>
                    <td>
                        <pre><?= $row['name'] . ":" . $row['header'] ?></pre>
                    </td>
                </tr>
<?php           endwhile; ?>
            </table>
        </td>
    </tr>
<?php       endwhile; ?>
</table>
<?php   endif; ?>