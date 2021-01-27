<?php
ini_set('display_errors', 1);
//X4YEN
use Magento\Framework\App\Bootstrap;
require __DIR__ . '/../../app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();
$state = $objectManager->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');


require('vendor/autoload.php');

$model = $objectManager->get('Magento\Variable\Model\Variable');

echo "gdfgdf";
