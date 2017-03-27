<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[NroSecuenciaProtocolo]].
 *
 * @see NroSecuenciaProtocolo
 */
class NroSecuenciaProtocoloQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return NroSecuenciaProtocolo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return NroSecuenciaProtocolo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
