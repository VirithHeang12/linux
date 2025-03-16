#!/bin/bash

if [[ $EUID -ne 0 ]]; then
    echo "This script must be run as root."
    exit 1
fi

if [[ $# -ne 2 ]]; then
    echo "Usage: $0 <username> <password>"
    exit 1
fi

USERNAME="$1"
PASSWORD="$2"

if id "$USERNAME" &>/dev/null; then
    echo "User '$USERNAME' already exists!"
    exit 1
fi

useradd -m -s /bin/bash "$USERNAME"

echo "$USERNAME:$PASSWORD" | chpasswd

echo "User '$USERNAME' created successfully."
