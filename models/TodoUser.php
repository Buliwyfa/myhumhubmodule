<?
class TodoUser extends HActiveRecordContent{
	public static function model($className = __CLASS__){
		return parent::model($className);
	}

	public function tableName(){
		return 'todo_user';
	}

	public function rules(){
		return array(array('user_id,  todo_id, list_id', 'required'));
	}

	public function relations(){
		return array();
	}

}
?>
