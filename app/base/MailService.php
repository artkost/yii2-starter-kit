<?php

namespace app\base;

use Yii;
use yii\base\Component;

class MailService extends Component {

    public function init()
    {
        parent::init();

        if ($this->_mail === null) {
            $this->_mail = Yii::$app->getMailer();
            //$this->_mail->htmlLayout = Yii::getAlias($this->id . '/mails/layouts/html');
            //$this->_mail->textLayout = Yii::getAlias($this->id . '/mails/layouts/text');
            $this->_mail->viewPath = '@app/modules/' . $module->id . '/mails/views';

            if (isset(Yii::$app->params['robotEmail']) && Yii::$app->params['robotEmail'] !== null) {
                $this->_mail->messageConfig['from'] = !isset(Yii::$app->params['robotName']) ? Yii::$app->params['robotEmail'] : [Yii::$app->params['robotEmail'] => Yii::$app->params['robotName']];
            }
        }
        return $this->_mail;
    }
}
