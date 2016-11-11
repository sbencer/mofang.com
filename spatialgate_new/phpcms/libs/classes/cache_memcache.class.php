<?php
class cache_memcache {

    private $memcache = null;

    public function __construct() {
        $this->memcache = new Memcached;
        $this->memcache->addServer(MEMCACHE_HOST, MEMCACHE_PORT);
    }

    public function memcache() {
        $this->__construct();
    }

    public function get($name) {
        $value = $this->memcache->get($name);
        return $value;
    }

    public function set($name, $value, $ttl = 0, $ext1='', $ext2='') {
        return $this->memcache->set($name, $value, $ttl);
    }

    public function delete($name) {
        return $this->memcache->delete($name);
    }

    public function flush() {
        return $this->memcache->flush();
    }
}
?>
