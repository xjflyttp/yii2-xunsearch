<?php

namespace xj\xunsearch;

use Yii;
use yii\base\Object;

/**
 * Easp XS instance
 */
class Database extends Object {

    /**
     * XS Instance
     * @var XS
     */
    public $xs;

    public function __call($name, $parameters) {
        // check methods of xs
        if ($this->xs !== null && method_exists($this->xs, $name)) {
            return call_user_func_array(array($this->xs, $name), $parameters);
        }
        // check methods of index object
        if ($this->xs !== null && method_exists(__NAMESPACE__ . '\\XSIndex', $name)) {
            $ret = call_user_func_array(array($this->xs->index, $name), $parameters);
            if ($ret === $this->xs->index) {
                return $this;
            }
            return $ret;
        }
        // check methods of search object
        if ($this->xs !== null && method_exists(__NAMESPACE__ . '\\XSSearch', $name)) {
            $ret = call_user_func_array(array($this->xs->search, $name), $parameters);
            if ($ret === $this->xs->search) {
                return $this;
            }
            return $ret;
        }
        return parent::__call($name, $parameters);
    }

}
