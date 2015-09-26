<?php

namespace app\modules\page\models;

/**
 * Class BlogQuery
 */
trait PostQueryTrait
{
    /**
     * Select sticky posts.
     *
     * @return $this
     */
    public function sticky()
    {
        $this->andWhere(['status_id' => PostBase::STATUS_STICKY]);

        return $this;
    }

    /**
     * Select published posts.
     *
     * @return $this
     */
    public function published()
    {
        $this->andWhere(['status_id' => PostBase::STATUS_PUBLISHED]);

        return $this;
    }

    /**
     * Select unpublished posts.
     *
     * @return $this
     */
    public function unpublished()
    {
        $this->andWhere(['status_id' => PostBase::STATUS_UNPUBLISHED]);

        return $this;
    }
}
