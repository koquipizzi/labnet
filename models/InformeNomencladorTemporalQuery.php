<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[InformeNomencladorTemporal]].
 *
 * @see InformeNomencladorTemporal
 */
class InformeNomencladorTemporalQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return InformeNomencladorTemporal[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return InformeNomencladorTemporal|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
