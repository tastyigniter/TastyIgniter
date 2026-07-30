#!/usr/bin/env bash
set -e

# Script to prepare a release by updating CHANGELOG.md
# Usage: ./bin/prepare-release.sh "6.7.0"
#
# Arguments:
#   $1 - Version number (e.g., "6.7.0")
#
# This script:
#   1. Moves all entries from [Unreleased] to a new version section
#   2. Adds the release date
#   3. Leaves an empty [Unreleased] section

if [ $# -lt 1 ]; then
  echo "Usage: $0 <version>"
  echo ""
  echo "Example: $0 '6.7.0'"
  exit 1
fi

VERSION="$1"
RELEASE_DATE=$(date +%Y-%m-%d)

if ! [[ "$VERSION" =~ ^[0-9]+\.[0-9]+\.[0-9]+$ ]]; then
    echo "Error: Version must be in format X.Y.Z (e.g., 6.7.0)"
    exit 1
fi

echo "Preparing release for version: $VERSION"
echo "Release date: $RELEASE_DATE"

# Check if CHANGELOG.md exists
if [ ! -f CHANGELOG.md ]; then
  echo "Error: CHANGELOG.md not found in current directory"
  exit 1
fi

# Check if there is content in the Unreleased section
# Extract content between [Unreleased] and the next version header
UNRELEASED_CONTENT=$(awk '/^## \[Unreleased\]/ {flag=1; next} /^## \[/ {flag=0} flag' CHANGELOG.md)
if ! echo "$UNRELEASED_CONTENT" | grep -q "^### "; then
  echo "Error: No changes found in [Unreleased] section"
  exit 1
fi

# Use awk to process the changelog
awk -v version="$VERSION" -v date="$RELEASE_DATE" '
BEGIN {
  in_unreleased = 0
  buf = ""
}

/^## \[Unreleased\]/ {
  print
  print ""
  print "## [" version "] - " date
  in_unreleased = 1
  next
}

/^## \[/ {
  if (in_unreleased) {
    print buf
    in_unreleased = 0
  }
  print
  next
}

in_unreleased {
  buf = buf $0 "\n"
  next
}

{ print }

END {
  if (in_unreleased) {
    print buf
  }
}
' CHANGELOG.md > CHANGELOG.md.tmp

if [ ! -s CHANGELOG.md.tmp ]; then
  echo "Error: Failed to update CHANGELOG.md"
  rm -f CHANGELOG.md.tmp
  exit 1
fi

mv CHANGELOG.md.tmp CHANGELOG.md

echo "CHANGELOG.md updated successfully"
echo "Created release section for version $VERSION"
