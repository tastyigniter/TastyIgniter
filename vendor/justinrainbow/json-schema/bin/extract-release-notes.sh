#!/usr/bin/env bash
set -e

# Script to extract release notes for a specific version from CHANGELOG.md
# Usage: ./bin/extract-release-notes.sh "6.7.0"
#
# Arguments:
#   $1 - Version number (e.g., "6.7.0")
#
# This script extracts all the content between the specified version header
# and the next version header

if [ $# -lt 1 ]; then
  echo "Usage: $0 <version>"
  echo ""
  echo "Example: $0 '6.7.0'"
  exit 1
fi

VERSION="$1"

if ! [[ "$VERSION" =~ ^[0-9]+\.[0-9]+\.[0-9]+$ ]]; then
    echo "Error: Version must be in format X.Y.Z (e.g., 6.7.0)"
    exit 1
fi

# Check if CHANGELOG.md exists
if [ ! -f CHANGELOG.md ]; then
  echo "Error: CHANGELOG.md not found in current directory"
  exit 1
fi

# Use awk to extract the release notes for the specified version
awk -v version="$VERSION" '
BEGIN { in_version = 0; found = 0 }

# Match the version header
$0 ~ "^## \\[" version "\\]" {
  in_version = 1
  found = 1
  next
}

# Match any other version header
/^## \[/ {
  if (in_version) {
    exit
  }
  next
}

# Print content when in the correct version section
in_version {
  print
}

END {
  if (!found) {
    print "Error: Version " version " not found in CHANGELOG.md" > "/dev/stderr"
    exit 1
  }
}
' CHANGELOG.md
