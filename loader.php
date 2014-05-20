<?php

define('DD_CONFIG', 'datastore/dd_config.json');
define('DD_DATA', 'datastore/dd_data.json');

define('DD_VIEWS', 'views/');
define('DD_LIBRARY', 'library/');

define('LINODE_API', 'https://api.linode.com/api/?');

require_once(DD_LIBRARY . 'Helper.php');
require_once(DD_LIBRARY . 'DataStore.php');
require_once(DD_LIBRARY . 'Receptor.php');
require_once(DD_LIBRARY . 'Viewer.php');