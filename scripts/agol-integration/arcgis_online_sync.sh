#!/bin/bash
here=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
cd "$here"
python agol_integration/agol_integration.py
