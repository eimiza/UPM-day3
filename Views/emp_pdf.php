<h2>HTML Table</h2>
<?php //print_r($data); ?>
<table>
  <tr>
    <th>Name</th>
    <th>IC</th>
    <th>Email</th>
  </tr>
  <?php foreach($data as $d){ ?>
  <tr>
    <td><?=$d['name']?></td>
    <td><?=$d['icno']?></td>
    <td><?=$d['email']?></td>
  </tr>
  <?php } ?>
</table>
