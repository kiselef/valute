<?php

namespace app;

use app\cache\Cache;
use app\models\CurrencyLog;
use app\tools\converter\CurrencyConverter;
use app\tools\converter\ConverterException;
use app\exception\CurrencyException;

class Controller
{
    public function actionIndex()
    {
        $request = App::core()->request;
        $response = App::core()->response;
        $cache = App::core()->cache;

        try {
            $params = array(
                'cost' => $request->get('cost'),
                'currency' => $request->get('currency')
            );
            $cacheConfig = array();
            if ($cache instanceof Cache) {
                $cacheConfig = array(
                    'host' => $cache->getHost(),
                    'port' => $cache->getPort()
                );
            }
            $converter = new CurrencyConverter($params, $cacheConfig);
            $response->set($converter->get());
        } catch (CurrencyException $e) {
            $response->setError($e->getMessage());
        } catch (ConverterException $e) {
            $response->setError($e->getMessage());
        } catch (\Exception $e) {
            $response->setError($e->getMessage());
        }

        $log = new CurrencyLog();
        $log->create($request);

        $response->send();
    }

    protected function beforeAction()
    {

    }

    public function doAction($way)
    {
        $method = 'action' . ucfirst($way);
        if (method_exists($this, $method)) {
            $this->beforeAction();
            $this->{$method}();
        } else {
            throw new \Exception('404');
        }
    }
}