#!/bin/bash

if [[ $# -ne 1 ]]; then
    echo "Usage: $0 <username>"
    exit 1
fi

USERNAME="$1"

if ! id "$USERNAME" &>/dev/null; then
    echo "User '$USERNAME' does not exist!"
    exit 1
fi

userdel -r "$USERNAME"

echo "User '$USERNAME' has been deleted successfully."
