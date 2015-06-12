#!/bin/sh
/cygdrive/c/memcached/memcached.exe -d stop
/cygdrive/c/memcached/memcached.exe -m 64m -d start
