<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[InformeNomenclador]].
 *
 * @see InformeNomenclador
 */
class InformeNomencladorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return InformeNomenclador[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return InformeNomenclador|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
