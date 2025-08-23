# Git LFS Fix Automation Script
# Run this after installing Java

param(
    [switch]$DryRun,
    [switch]$SkipBackup
)

Write-Host "🧨 Git LFS Fix Script" -ForegroundColor Yellow
Write-Host "=====================" -ForegroundColor Yellow

# Check if Java is available
try {
    $javaVersion = java -version 2>&1
    Write-Host "✅ Java found: $($javaVersion[0])" -ForegroundColor Green
} catch {
    Write-Host "❌ Java not found. Please install Java first:" -ForegroundColor Red
    Write-Host "   winget install Microsoft.OpenJDK.11" -ForegroundColor Cyan
    exit 1
}

# Check if BFG exists
if (-not (Test-Path "bfg.jar")) {
    Write-Host "❌ bfg.jar not found in current directory" -ForegroundColor Red
    exit 1
}

# Check current directory is a git repo
if (-not (Test-Path ".git")) {
    Write-Host "❌ Not in a Git repository" -ForegroundColor Red
    exit 1
}

Write-Host "🔍 Current repository status:" -ForegroundColor Cyan
git status --porcelain

if ($DryRun) {
    Write-Host "🧪 DRY RUN MODE - No changes will be made" -ForegroundColor Yellow
    Write-Host "Commands that would be executed:" -ForegroundColor Yellow
    Write-Host "1. java -jar bfg.jar --delete-files *.wpress ." -ForegroundColor Gray
    Write-Host "2. git reflog expire --expire=now --all" -ForegroundColor Gray
    Write-Host "3. git gc --prune=now --aggressive" -ForegroundColor Gray
    Write-Host "4. git rm wp-content/ai1wm-backups/test2-athenas-co-in-20240811-172254-tp5thr.wpress" -ForegroundColor Gray
    Write-Host "5. git commit -m 'Remove .wpress file before LFS re-add'" -ForegroundColor Gray
    Write-Host "6. git push --force origin main" -ForegroundColor Gray
    Write-Host "7. git add wp-content/ai1wm-backups/test2-athenas-co-in-20240811-172254-tp5thr.wpress" -ForegroundColor Gray
    Write-Host "8. git commit -m 'Re-add .wpress file using Git LFS'" -ForegroundColor Gray
    Write-Host "9. git push origin main" -ForegroundColor Gray
    exit 0
}

# Confirm before proceeding
$confirm = Read-Host "⚠️  This will rewrite Git history. Continue? (y/N)"
if ($confirm -ne 'y' -and $confirm -ne 'Y') {
    Write-Host "❌ Aborted by user" -ForegroundColor Red
    exit 1
}

Write-Host "🚀 Starting Git LFS fix process..." -ForegroundColor Green

# Step 1: Run BFG
Write-Host "📝 Step 1: Running BFG to clean history..." -ForegroundColor Cyan
try {
    java -jar bfg.jar --delete-files *.wpress .
    Write-Host "✅ BFG completed successfully" -ForegroundColor Green
} catch {
    Write-Host "❌ BFG failed: $($_.Exception.Message)" -ForegroundColor Red
    exit 1
}

# Step 2: Clean Git objects
Write-Host "📝 Step 2: Cleaning Git objects..." -ForegroundColor Cyan
git reflog expire --expire=now --all
git gc --prune=now --aggressive
Write-Host "✅ Git objects cleaned" -ForegroundColor Green

# Step 3: Remove current file
Write-Host "📝 Step 3: Removing current .wpress file..." -ForegroundColor Cyan
$wpressFile = "wp-content/ai1wm-backups/test2-athenas-co-in-20240811-172254-tp5thr.wpress"
if (Test-Path $wpressFile) {
    git rm $wpressFile
    git commit -m "Remove .wpress file before LFS re-add"
    Write-Host "✅ File removed and committed" -ForegroundColor Green
} else {
    Write-Host "⚠️  .wpress file not found in working directory" -ForegroundColor Yellow
}

# Step 4: Force push
Write-Host "📝 Step 4: Force pushing cleaned history..." -ForegroundColor Cyan
try {
    git push --force origin main
    Write-Host "✅ Cleaned history pushed successfully" -ForegroundColor Green
} catch {
    Write-Host "❌ Force push failed: $($_.Exception.Message)" -ForegroundColor Red
    Write-Host "You may need to run: git push --force origin main" -ForegroundColor Yellow
}

# Step 5: Re-add with LFS
Write-Host "📝 Step 5: Re-adding file with Git LFS..." -ForegroundColor Cyan
if (Test-Path $wpressFile) {
    # Ensure LFS tracking
    git lfs track "*.wpress"
    git add .gitattributes
    
    # Add the file
    git add $wpressFile
    git commit -m "Re-add .wpress file using Git LFS"
    
    # Final push
    git push origin main
    Write-Host "✅ File re-added with LFS and pushed" -ForegroundColor Green
} else {
    Write-Host "⚠️  .wpress file not found for re-adding" -ForegroundColor Yellow
}

Write-Host "🎉 Git LFS fix completed!" -ForegroundColor Green
Write-Host "📊 Repository status:" -ForegroundColor Cyan
git lfs ls-files
git status

Write-Host "🛡️  Consider installing the pre-commit hook to prevent future issues:" -ForegroundColor Yellow
Write-Host "   See GIT_LFS_FIX_GUIDE.md for instructions" -ForegroundColor Cyan
