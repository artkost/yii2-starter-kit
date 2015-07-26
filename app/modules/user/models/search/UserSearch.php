<?php

namespace app\modules\user\models\search;

use app\modules\user\models\User;
use app\modules\user\models\UserProfile;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;

/**
 * User search model.
 */
class UserSearch extends User
{
    /**
     * @var string Name
     */
    public $name;

    /**
     * @var string Surname
     */
    public $surname;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // String
            [['name', 'surname', 'username', 'email'], 'string'],
            // Role
            // Status
            ['status_id', 'in', 'range' => array_keys(self::statusLabels())],
            // Date
            [['created_at', 'updated_at'], 'date', 'format' => 'd.m.Y']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
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
        $query = self::find()->joinWith(['profile', 'assignments']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy('created_at DESC'),
        ]);

        $dataProvider->sort->attributes['name'] = [
            'asc' => [UserProfile::tableName() . '.name' => SORT_ASC],
            'desc' => [UserProfile::tableName() . '.name' => SORT_DESC]
        ];
        $dataProvider->sort->attributes['surname'] = [
            'asc' => [UserProfile::tableName() . '.surname' => SORT_ASC],
            'desc' => [UserProfile::tableName() . '.surname' => SORT_DESC]
        ];

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

        $query->andFilterWhere(['like', UserProfile::tableName() . '.name', $this->name]);
        $query->andFilterWhere(['like', UserProfile::tableName() . '.surname', $this->surname]);
        $query->andFilterWhere(['like', 'username', $this->username]);
        $query->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
