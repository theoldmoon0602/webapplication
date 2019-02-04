#!/bin/bash

rm -f database.db
sqlite3 database.db < schema.sql
