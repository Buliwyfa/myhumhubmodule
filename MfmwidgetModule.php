<?php

/**
 * ExTopNavModule Base Module Class
 *
 * @author luke
 */
class MfmwidgetModule extends HWebModule
{
    public function init()
    {
        $this->setImport(array(
            'mfmwidget.models.*',
            'mfmwidget.behaviors.*',
        ));
    }

    public function behaviors()
    {
        return array(
            'SpaceModuleBehavior' => array(
                'class' => 'application.modules_core.space.behaviors.SpaceModuleBehavior',
            ),
        );
    }

    /**
    * On global module disable, delete all created content
    */
    public function disable()
    {
        if (parent::disable()) {
            foreach (Content::model()->findAllByAttributes(array('object_model' => 'TodoList')) as $content) {
                $content->delete();
            }
            return true;
        }
        return false;
    }
    /**
    * On disabling this module on a space, deleted all module -> space related content/data.
    * Method stub is provided by "SpaceModuleBehavior"
    *
    * @param Space $space
    */
    public function disableSpaceModule(Space $space)
    {
        foreach (Content::model()->findAllByAttributes(array('space_id' => $space->id, 'object_model' => 'TodoList')) as $content) {
            $content->delete();
        }
    }
    /**
    * On build of a Space Navigation, check if this module is enabled.
    * When enabled add a menu item
    *
    * @param type $event
    */
    public static function onSpaceMenuInit($event)
    {
        $space = Yii::app()->getController()->getSpace();
        // Is Module enabled on this workspace?
        if ($space->isModuleEnabled('mfmwidget')) {
            $event->sender->addItem(array(
                'label' => Yii::t('MfmwidgetModule.base', 'Todo Lists'),
                'group' => 'modules',
                'url' => Yii::app()->createUrl('//mfmwidget/main/show', array('sguid' => $space->guid)),
                'icon' => '<i class="fa fa-question-circle"></i>',
                'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'mfmwidget'),
            ));
        }
    }
    /**
    * On User delete, delete all todo lists by this user
    *
    * @param type $event
    */
    public static function onUserDelete($event)
    {
        foreach (TodoList::model()->findAllByAttributes(array('created_by' => $event->sender->id)) as $list) {
            $list->delete();
        }
        foreach (TodoItem::model()->findAllByAttributes(array('created_by' => $event->sender->id)) as $list) {
            $list->delete();
        }
        return true;
    }

}
