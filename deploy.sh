#!/usr/bin/env bash
# Dari folder stepup di server: bash deploy.sh
exec "$(cd "$(dirname "$0")" && pwd)/scripts/deploy-hostinger.sh"
