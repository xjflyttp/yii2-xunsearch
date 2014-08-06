<?php

namespace xj\xunsearch;

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'XS.php';

use Yii;
use yii\base\Component;
use yii\helpers\Inflector;
use yii\db\Exception;

/**
 * Xunsearch Connection
 * @author xjflyttp <xjflyttp@gmail.com>
 */
class Connection extends Component {

    /**
     * @event Event an event that is triggered after a DB connection is established
     */
    const EVENT_AFTER_OPEN = 'afterOpen';

    /**
     * @var string path
     *
     * For example:
     * /var/www/htdocs/common/config/xs
     * @common/config/xs
     */
    public $configDirectory;

    /**
     * @var XS[] list of Xunsearch
     */
    private $_databases = [];

    /**
     * get XS instance
     * @param string $name collection name
     * @param boolean $refresh whether to reestablish the database connection even if it is found in the cache.
     * @return mixed Database|null
     */
    public function getDatabase($name, $refresh = false) {
        try {
            if ($refresh || !array_key_exists($name, $this->_databases)) {
                $this->_databases[$name] = $this->selectDatabase($name);
            }
        } catch (XSException $e) {
            return null;
        }
        return $this->_databases[$name];
    }

    /**
     * Selects the database with given name.
     * @param string $name database name.
     * @return XS database instance.
     * @throws XSException
     */
    protected function selectDatabase($name) {
        $iniPath = $this->getAppIniByName($name);
        return Yii::createObject([
                    'class' => Database::className(),
                    'xs' => new XS($iniPath),
        ]);
    }

    /**
     * get App ini by name
     * @param string $name
     * @return string
     */
    private function getAppIniByName($name) {
        $file = '';
        $baseDirectory = $this->configDirectory;
        if (substr($baseDirectory, 0, 1) === '@') {
            $file .= Yii::getAlias($baseDirectory);
        } else {
            $file .= $this->configDirectory;
        }
        $file .= DIRECTORY_SEPARATOR . $name . '.ini';
        return $file;
    }

}
