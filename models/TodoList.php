<?
class TodoList extends HActiveRecordContent{
	public static function model($className = __CLASS__){
		return parent::model($className);
	}

	public function tableName(){
		return 'todo_list';
	}

	public function rules(){
		return array(
			array('title,  created_at, created_by', 'required')
		);
	}

	public function relations(){
		return array(
			'items' => array(self::HAS_MANY, 'TodoItem', $this->id),
			'creator' => array(self::BELONGS_TO, 'User', 'created_by'),
		);
	}

	public function delete(){

		//find all items on this list
		$todoItems = TodoItem::model()->findAllByAttributes(['list_id' => $this->id]);
		foreach ($todoItems as $ti) {
			$tu->delete();
		}
		Notification::remove('Todo', $this->id);
		return parent::delete();
	}

	public function addListItem(){
		
	}

	public function getContentTitle(){}
}
?>
