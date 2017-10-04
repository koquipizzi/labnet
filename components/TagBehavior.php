<?php 

namespace app\components;
use yii\db\ActiveRecord;
use yii\base\Behavior;

class TagBehavior extends Behavior  {
    
        /**
         * @var string
         * The name attribute of the Tag class.
         */
        public $nameAttribute = 'name';
    
        /**
         * @var array|string
         * Table name of the junction table, or array of multiple junction tables
         */
        public $junctionTable = 'informe_tag_assn';
    
        /**
         * @var string
         * The name of the attribute in $junctionTable that holds the primary key of the Tag.
         */
        public $tagKeyAttribute = 'tag_id';
    
        public $modelKeyAttribute = 'informe_id';
    
        /**
         * @var string
         * Route part of the link address returned in getLink().
         */
        public $linkRoute = 'tag/view';
    
        /**
         * @param $options array: link options
         * @return string
         * HTML of link to view of Tag (or any other destination, dependent of $linkRoute).
         */
        public function getLink($options = [])   {
            /**
             * @var $owner ActiveRecord
             */
            $owner = $this->owner;
            $tpk = current($owner::primaryKey());
    
            return Html::a($owner->getAttribute($this->nameAttribute), [ $this->linkRoute, $tpk => $owner->primaryKey], $options);
        }
    

    public function events()
    { 
        return [
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    public function beforeDelete($event)  {
        /**
         * @var $owner ActiveRecord
         */
        $owner = $this->owner;
        $db = $owner->getDb();

        if (is_string($this->junctionTable))    {
            $this->junctionTable = [ $this->junctionTable ];
        }

        foreach ($this->junctionTable as $jt)   {
            $db->createCommand()->delete($this->junctionTable, [
                $this->tagKeyAttribute => $owner->primaryKey
            ])->execute();
        }
    }

}

?>