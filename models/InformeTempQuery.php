<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[InformeTemp]].
 *
 * @see InformeTemp
 */
class InformeTempQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return InformeTemp[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return InformeTemp|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
