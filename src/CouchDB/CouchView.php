<?php
/*
 *  Copyright 2016-2017 Grobmeier Solutions GmbH
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing,
 *  software distributed under the License is distributed
 *  on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND,
 *  either express or implied. See the License for the specific
 *  language governing permissions and limitations under the License.
 */
namespace GrobmeierSolutions\CouchDB;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class CouchView
{
    private $client;
    private $url;

    private $params = [];

    public function __construct(Client $client, $documentUrl, $viewName) {
        $this->client = $client;
        $this->url = sprintf($documentUrl. "/_view/%s", $viewName);
    }

    public function key($key) {
        $this->params['key'] = json_encode($key);
        return $this;
    }

    public function limit($limit) {
        $this->params['limit'] = $limit;
        return $this;
    }

    public function skip($skip) {
        $this->params['skip'] = $skip;
        return $this;
    }

    public function reduce($reduce = true) {
        $this->params['reduce'] = $reduce;
        return $this;
    }

    public function group($group = true) {
        $this->params['group'] = $group;
        return $this;
    }

    public function range($startKeys = null, $endKeys = null) {
        $params['startKeys'] = 'startKeys=' . json_encode($startKeys);
        $params['endKeys'] = 'endKeys=' . json_encode($endKeys);
        return $this;
    }

    public function url() {
        return $this->url . '?' . http_build_query($this->params);
    }

    public function get() {
        /** @var ResponseInterface $response */
        $response = $this->client->get($this->url());
        return $response->getBody()->getContents();
    }
}

