<?php
    /**
     * DEMO PAGE
     *
     * This page is only use to load the demo on Heroku!
     * This page requires PHP >= 7
     *
     * Please use the `cache.php` file directly for your own deployments.
     */
    class CacheDemoClass {
        public $hello = 'world';
    }

    define('INIT', !preg_match('#herokuapp.com|localhost|127.0.0.1#', $_SERVER['HTTP_REFERER'] ?? ''));

    if (INIT) {
        apcu_store('type.bool.true', true);
        apcu_store('type.bool.false', true);
        apcu_store('type.numeric.10', 10);
        apcu_store('type.numeric.10000', 10000);
        apcu_store('type.numeric.666666', 666666);
        apcu_store('type.string', 'Hello World');
        apcu_store('type.string.expires', 'Hello World', 3600 * 12);
        apcu_store('type.array', array('hello', 'world'));
        apcu_store('type.array', array('hello' => 'world'));
        apcu_store('type.array.assoc', array('hello' => 'world'), 3600 * 24);
        apcu_store('type.object', (object)array('hello' => 'world'), 3600 * 24);
        apcu_store('type.class-instance', new CacheDemoClass(), 3600);
    }

    if (INIT) {
        $memcache = new \Memcached();
        $memcache->addServer('127.0.0.1', 11211);

        $memcache->add('type.array', ['abc', 'def']);
        $memcache->add('type.string', 'hello-world');
        $memcache->add('type.ttl.string', 'hello-world', time() + 3600);
    }

    require_once('../cache.php');
