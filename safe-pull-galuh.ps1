# Safe Pull from Galuh Branch
# This script will pull changes from Galuh branch while keeping your changes

Write-Host "=== Safe Pull from Galuh Branch ===" -ForegroundColor Cyan
Write-Host ""

# 1. Stash current changes (if any)
Write-Host "1. Saving your current work..." -ForegroundColor Yellow
git stash push -m "Auto-stash before pulling Galuh"

# 2. Fetch latest from Galuh
Write-Host "2. Fetching latest from Galuh branch..." -ForegroundColor Yellow
git fetch origin Galuh

# 3. Merge with ours strategy (keep our version on conflicts)
Write-Host "3. Merging Galuh changes (keeping your version on conflicts)..." -ForegroundColor Yellow
git merge origin/Galuh -X ours --no-edit

# 4. Restore stashed changes
Write-Host "4. Restoring your work..." -ForegroundColor Yellow
git stash pop

Write-Host ""
Write-Host "=== Pull Complete ===" -ForegroundColor Green
Write-Host "Your changes have been preserved!" -ForegroundColor Green
Write-Host ""
Write-Host "If there are conflicts, your version (rifan) will be kept." -ForegroundColor Cyan
