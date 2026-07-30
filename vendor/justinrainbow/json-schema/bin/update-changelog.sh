#!/usr/bin/env bash
set -e

# Script to update CHANGELOG.md with a new entry
# Usage: ./bin/update-changelog.sh "PR Title" "123" "Fixed"
#
# Arguments:
#   $1 - PR title (the changelog entry text)
#   $2 - PR number
#   $3 - Category (Added, Changed, Fixed, Deprecated, Removed, Security)
#
# Example:
#   ./bin/update-changelog.sh "Fix bug in validation" "456" "Fixed"

if [ $# -lt 3 ]; then
  echo "Usage: $0 <pr_title> <pr_number> <category>"
  echo ""
  echo "Categories: Added, Changed, Fixed, Deprecated, Removed, Security"
  echo ""
  echo "Example: $0 'Fix bug in validation' '456' 'Fixed'"
  exit 1
fi

PR_TITLE="$1"
PR_NUMBER="$2"
CATEGORY="$3"
REPO_URL="${GITHUB_REPOSITORY_URL:-https://github.com/jsonrainbow/json-schema}"

# Remove trailing .git if present
REPO_URL="${REPO_URL%.git}"

# Create the changelog entry
ENTRY="- ${PR_TITLE} ([#${PR_NUMBER}](${REPO_URL}/pull/${PR_NUMBER}))"

echo "Adding entry: $ENTRY"
echo "Under category: ### $CATEGORY"

# Check if CHANGELOG.md exists
if [ ! -f CHANGELOG.md ]; then
  echo "Error: CHANGELOG.md not found in current directory"
  exit 1
fi

# Use awk to insert the entry under the correct category in the Unreleased section
if ! awk -v entry="$ENTRY" -v category="### $CATEGORY" '
BEGIN { in_unreleased=0; found_category=0; added=0 }

# Detect Unreleased section
/^## \[Unreleased\]/ { in_unreleased=1; print; next }

# Detect next version section (end of Unreleased)
/^## \[/ {
  if (in_unreleased && !added) {
    # If we are leaving Unreleased and haven'\''t added entry yet
    # Add category and entry before this line
    if (!found_category) {
      print category
    }
    print entry
    print ""
    added=1
  }
  in_unreleased=0
  found_category=0
  print
  next
}

# If in Unreleased section, look for matching category
in_unreleased && $0 == category {
  found_category=1
  print
  # Add entry right after category header
  print entry
  added=1
  next
}

# Always print the current line
{ print }

# At end of file, if still in unreleased and not added
END {
  if (in_unreleased && !added) {
    if (!found_category) {
      print category
    }
    print entry
  }
}
' CHANGELOG.md > CHANGELOG.md.tmp; then
  echo "Error: Failed to update CHANGELOG.md"
  rm -f CHANGELOG.md.tmp
  exit 1
fi

mv CHANGELOG.md.tmp CHANGELOG.md

echo "CHANGELOG.md updated successfully"
