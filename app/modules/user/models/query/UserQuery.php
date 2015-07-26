<?php

namespace app\modules\user\models\query;

use app\modules\user\models\User;
use yii\db\ActiveQuery;

/**
 * Class UserQuery
 */
class UserQuery extends ActiveQuery
{

    /**
     * Select active users.
     *
     * @return $this
     */
	public function active()
	{
		$this->andWhere(['status_id' => User::STATUS_ACTIVE]);
		return $this;
	}

    /**
     * Select inactive users.
     *
     * @return $this
     */
	public function inactive()
	{
		$this->andWhere(['status_id' => User::STATUS_INACTIVE]);
		return $this;
	}

    /**
     * Select banned users.
     *
     * @return $this
     */
	public function banned()
	{
		$this->andWhere(['status_id' => User::STATUS_BANNED]);
		return $this;
	}

    /**
     * Select deleted users.
     *
     * @return $this
     */
	public function deleted()
	{
		$this->andWhere(['status_id' => User::STATUS_DELETED]);
		return $this;
	}

	/**
	 * Select users with role "user".
	 *
	 */
	public function registered()
	{
		$this->andWhere(['role' => User::ROLE_DEFAULT]);
		return $this;
	}
}
