<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Leyenda]].
 *
 * @see Leyenda
 */
class LeyendaQuery extends \yii\db\ActiveQuery
{
    public $texto;
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Leyenda[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Leyenda|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
