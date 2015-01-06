<?php

Yii::app()->moduleManager->register(array(
    'id' => 'mfmwidget',
    'class' => 'application.modules.mfmwidget.MfmwidgetModule',
    'import' => array(
        'application.modules.mfmwidget.*',
    ),
    'events' => array(
        array('class' => 'TopMenuWidget', 'event' => 'onInit', 'callback' => array('MfmwidgetEvents', 'onTopMenuInit')),
    ),
));
?>
