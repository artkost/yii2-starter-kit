<?php

namespace app\modules\page\models;

use app\components\helpers\Security;
use yii\data\ActiveDataProvider;

/**
 * Blog search model.
 */
class PagePostSearch extends PagePost
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Integer
            [['id', 'parent_id', 'model_class'], 'integer'],
            // String
            [['snippet', 'content'], 'string'],
            [['title', 'alias'], 'string', 'max' => 255],
            // Status
            ['status_id', 'in', 'range' => array_keys(self::statusLabels())],
            // Date
            [['created_at', 'updated_at'], 'date', 'format' => 'd.m.Y']
        ];
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params Search params
     *
     * @return ActiveDataProvider DataProvider
     */
    public function search($params)
    {
        $query = self::find()->where(['model_class' => Security::crc32(PagePost::className())]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(
            [
                'id' => $this->id,
                'status_id' => $this->status_id,
                'FROM_UNIXTIME(created_at, "%d.%m.%Y")' => $this->created_at,
                'FROM_UNIXTIME(updated_at, "%d.%m.%Y")' => $this->updated_at
            ]
        );

        $query->andFilterWhere(['like', 'alias', $this->alias]);
        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'snippet', $this->snippet]);
        $query->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
