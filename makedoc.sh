#!/bin/sh
rm -rf /var/www/html/api/modules/v01/html/*
vendor/bin/apidoc guide modules/v01/doc/ modules/v01/html/ --pageTitle='Полное руководство по RestApi для Petrol+ v: 0.1'
rm -rf /var/www/html/api/modules/v02/html/*
vendor/bin/apidoc guide modules/v02/doc/ modules/v02/html/ --pageTitle='Полное руководство по RestApi для Petrol+ v: 0.2'

rm -rf web/doc_v01/*
rm -rf web/doc_v02/*

cp -a modules/v01/html/* web/doc_v01
cp -a modules/v02/html/* web/doc_v02