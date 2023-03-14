<?php

use TomasVotruba\PunchCard\Proposal\Generator\Lib\DatabaseConfig;

return (new DatabaseConfig)->use(MysqlMagicInterface::class)->toArray();

?>
======
<?php

$mysql = new MysqlMagic(); //Implement DatabaseInterface MysqlMagicInterface

$mysql->setDatabase('maki10');

return (new DatabaseConfig)->use($mysql)->toArray();
