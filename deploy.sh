#!/usr/bin/env bash

set -euo pipefail

THEME_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
CONFIG_FILE="${THEME_DIR}/.deploy-config"
EXPECTED_BRANCH="main"
EXPECTED_REMOTE_PATH_SUFFIX="/wp-content/themes/acf-module-workbench/"
MODE="preview"

usage() {
	cat <<'EOF'
Usage:
  ./deploy.sh           Preview the files that would be uploaded
  ./deploy.sh --apply   Preview, confirm, and upload the files

The local .deploy-config file must define SG_HOST, SG_USER, SG_PORT,
and SG_REMOTE_PATH. Copy .deploy-config.example to begin.
EOF
}

case "${1:-}" in
	"") ;;
	--apply) MODE="apply" ;;
	-h|--help) usage; exit 0 ;;
	*) usage >&2; exit 2 ;;
esac

if [[ ! -f "${CONFIG_FILE}" ]]; then
	echo "Missing ${CONFIG_FILE}"
	echo "Copy .deploy-config.example to .deploy-config and add the SiteGround details."
	exit 1
fi

# This file is intentionally excluded from Git.
# shellcheck source=/dev/null
source "${CONFIG_FILE}"

for variable in SG_HOST SG_USER SG_PORT SG_REMOTE_PATH; do
	if [[ -z "${!variable:-}" ]]; then
		echo "${variable} is missing from .deploy-config"
		exit 1
	fi
done

if [[ ! "${SG_PORT}" =~ ^[0-9]+$ ]]; then
	echo "SG_PORT must be a number."
	exit 1
fi

if [[ ! "${SG_HOST}" =~ ^[A-Za-z0-9.-]+$ || ! "${SG_USER}" =~ ^[A-Za-z0-9._-]+$ ]]; then
	echo "The SiteGround hostname or username contains unexpected characters."
	exit 1
fi

if [[ ! "${SG_REMOTE_PATH}" =~ ^/[A-Za-z0-9._/-]+${EXPECTED_REMOTE_PATH_SUFFIX}$ ]]; then
	echo "SG_REMOTE_PATH must be an absolute path ending in ${EXPECTED_REMOTE_PATH_SUFFIX}"
	exit 1
fi

for command_name in git rsync ssh; do
	if ! command -v "${command_name}" >/dev/null 2>&1; then
		echo "Required command not found: ${command_name}"
		exit 1
	fi
done

cd "${THEME_DIR}"

if [[ "$(git branch --show-current)" != "${EXPECTED_BRANCH}" ]]; then
	echo "Deployment is allowed only from the ${EXPECTED_BRANCH} branch."
	exit 1
fi

if [[ -n "$(git status --porcelain)" ]]; then
	if [[ "${MODE}" == "apply" ]]; then
		echo "Deployment stopped: the theme has uncommitted files."
		echo "Commit or discard all changes before deploying."
		exit 1
	fi
	echo "Warning: this preview includes uncommitted files."
fi

echo "Checking GitHub ${EXPECTED_BRANCH}..."
git fetch --quiet origin "${EXPECTED_BRANCH}"

if [[ "$(git rev-parse HEAD)" != "$(git rev-parse "origin/${EXPECTED_BRANCH}")" ]]; then
	if [[ "${MODE}" == "apply" ]]; then
		echo "Deployment stopped: local ${EXPECTED_BRANCH} does not match GitHub ${EXPECTED_BRANCH}."
		exit 1
	fi
	echo "Warning: local ${EXPECTED_BRANCH} does not match GitHub ${EXPECTED_BRANCH}."
fi

SSH_COMMAND="ssh -p ${SG_PORT}"
REMOTE_TARGET="${SG_USER}@${SG_HOST}:${SG_REMOTE_PATH}"
RSYNC_OPTIONS=(
	--archive
	--no-times
	--verbose
	--compress
	--checksum
	--itemize-changes
	--delete
	--filter="merge .rsync-filter"
	--rsh="${SSH_COMMAND}"
)

echo
echo "Previewing deployment to ${SG_HOST}:${SG_REMOTE_PATH}"
rsync "${RSYNC_OPTIONS[@]}" --dry-run ./ "${REMOTE_TARGET}"

if [[ "${MODE}" != "apply" ]]; then
	echo
	echo "Preview only. No files were uploaded."
	echo "Run ./deploy.sh --apply from ${EXPECTED_BRANCH} when the listed changes are approved."
	exit 0
fi

echo
read -r -p "Type DEPLOY to upload exactly these changes: " confirmation
if [[ "${confirmation}" != "DEPLOY" ]]; then
	echo "Deployment cancelled."
	exit 1
fi

rsync "${RSYNC_OPTIONS[@]}" ./ "${REMOTE_TARGET}"

echo "Deployment complete."
