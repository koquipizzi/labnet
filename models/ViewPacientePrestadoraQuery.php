<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ViewPacientePrestadora]].
 *
 * @see ViewPacientePrestadora
 */
class ViewPacientePrestadoraQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ViewPacientePrestadora[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ViewPacientePrestadora|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
