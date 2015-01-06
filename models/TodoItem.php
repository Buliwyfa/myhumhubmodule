<?php
class TodoItem extends HActiveRecord{
	public $preassignedUsers;
	const STATUS_OPEN = 1;
	const STATUS_FINISHED = 5;
	public $autoAddToWall = true;
	public static function model($className = __CLASS__){ return parent::model($className); }
	public function tableName(){ return 'todo_item'; }
	public function rules(){
		return [
			['title,  created_at, created_by', 'required']
		];
	}
	public function relations(){
		return [
			'list'=>[self::BELONGS_TO,'TodoList','list_id'],
			'users'=>[self::HAS_MANY,'TodoUser','todo_id'],
			'creator'=>[self::BELONGS_TO,'User','created_by']
		];
	}
	public function delete(){
		//delete all the users assigned to this task
		$todoUser = TodoUser::model()->findAllByAttributes(['todo_id' => $this->id]);
		foreach ($todoUser as $tu) { $tu->delete(); }
		Notification::remove('Todo', $this->id);
		return parent::delete();
	}
	public function getWallOut(){
		return Yii::app()->getController()->widget('application.modules.mfm-widget.widgets.TodoWallEntryWidget', array('item' => $this), true);
	}

	public function assignItemToUser(){
		$user = new TodoUser;
		$user->user_id = $user->id;
		$user->todo_id = $this->id;
		$user->list_id = $this->list_id;
		return ($user->save())?true:false;
	}

	public function getContentTitle(){ return "\"" . Helpers::truncateText($this->title, 25) . "\""; }
}
