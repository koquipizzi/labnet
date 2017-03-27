<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Multimedia]].
 *
 * @see Multimedia
 */
class MultimediaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Multimedia[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Multimedia|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
