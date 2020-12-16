#!/usr/bin/env bash
#
# elliotjon/weather-module
#
# Copy all weather module files into existing anax project.
# The last two is not required, uncomment if wanted.

# Copy config
rsync -av vendor/elliotjon/weather-module/config ./

# Copy view
rsync -av vendor/elliotjon/weather-module/view ./

# Copy src
# rsync -av vendor/elliotjon/weather-module/src ./

# Copy test
# rsync -av vendor/elliotjon/weather-module/test ./