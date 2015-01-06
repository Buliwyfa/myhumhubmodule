<?php

/**
 * ExTopNavEvents is responsible to handle events defined by autostart.php
 *
 * @author luke
 */
class MfmwidgetEvents
{

    /**
     * On build of the TopMenu
     *
     * @param CEvent $event
     */
    public static function onTopMenuInit($event)
    {
        $event->sender->addItem(array(
            'label' => Yii::t('MfmwidgetModule.base', 'Todo List'),
            'url' => Yii::app()->createUrl('/mfmwidget/main/index', array()),
            'icon' => '<i class="fa fa-sun-o"></i>',
            'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'mfmwidget'),
        ));
    }

}
