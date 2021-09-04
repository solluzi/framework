#!/bin/bash -e

# Exceutes testes 
if [ $ENVIRONMENT = "development" ]; then
    vendor/bin/codecept run api
else
    vendor/bin/codecept run api
fi