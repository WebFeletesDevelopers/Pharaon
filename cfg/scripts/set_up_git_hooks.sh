#!/usr/bin/env bash

PRE_PUSH_FILE='pre-push'
HOOKS="${PWD}/.git/hooks/"

if [ ! -f "${HOOKS}${PRE_PUSH_FILE}" ]; then
  echo "Linkeando pre-push"
  ln -s "${PWD}/${PRE_PUSH_FILE}" "${HOOKS}${PRE_PUSH_FILE}"
else
  echo "El archivo ya existe"
fi