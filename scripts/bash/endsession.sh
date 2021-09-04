#!/bin/bash

# Data form database
dbdate="2021-02-25 14:13:52"

for d in 1 2 3 4 5
do
    # Must not alter this parameters
    givendate=$(date -d "$dbdate" "+%s")
    currentdate=$(date "+%s")

    # Compare two dates
    if [ $givendate -lt $currentdate ];
    then
        # Update User Access Log if logout_time is null
        echo "Run update"
    fi
done
