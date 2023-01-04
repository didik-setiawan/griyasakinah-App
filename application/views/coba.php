<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php foreach($menu as $m){ ?>
        <h5><?= $m->title ?></h5>
        <ul>
            <?php $submenu = $this->db->get_where('db_module', ['parent' => $m->id, 'aktif' => 1])->result(); 
                foreach($submenu as $s){
            ?>
                <li><?= $s->title; ?></li>
            <?php } ?>
        </ul>
        <?php } ?>
</body>
</html>