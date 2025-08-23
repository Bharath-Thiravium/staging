# 🧨 Git LFS Issue - Complete Fix Guide

## 🔍 Problem Identified
Your `.wpress` file (291 MB) exists in Git history as a regular blob, even though it's now tracked by LFS. GitHub detects this and blocks the push with:

```
remote: error: File wp-content/ai1wm-backups/test2-athenas-co-in-20240811-172254-tp5thr.wpress is 291.00 MB; this exceeds GitHub's file size limit of 100.00 MB
```

## ✅ Solution: Use BFG Repo-Cleaner

I've already downloaded BFG for you (`bfg.jar` is in your staging directory). Now follow these steps:

### 🔹 Step 1: Install Java (Required for BFG)

**Option A: Download Java from Oracle**
1. Go to: https://www.oracle.com/java/technologies/downloads/
2. Download Java 11 or higher for Windows
3. Install and restart your terminal

**Option B: Use Chocolatey (if installed)**
```powershell
choco install openjdk11
```

**Option C: Use winget**
```powershell
winget install Microsoft.OpenJDK.11
```

### 🔹 Step 2: Verify Java Installation
```powershell
java -version
```
You should see something like: `openjdk version "11.0.x"`

### 🔹 Step 3: Run BFG to Clean Git History

**Navigate to your staging directory:**
```powershell
cd C:\Users\bhara\Downloads\staging
```

**Remove .wpress files from Git history:**
```powershell
java -jar bfg.jar --delete-files *.wpress .
```

Expected output:
```
Using repo : .
Found 17729 objects to protect
Found 4 commit-pointing refs : HEAD, refs/heads/main, ...
Protected commits
These are your protected commits, and so their contents will NOT be altered:
 * commit 45655377 (HEAD -> main) - contains 1 dirty file:
   - wp-content/ai1wm-backups/test2-athenas-co-in-20240811-172254-tp5thr.wpress (291.0 MB)

Found 3 commits
Cleaned commits
These are the commits that were dirty:
 * commit 1a305f50 - removed 1 file
 * commit 7a48903f - removed 1 file
 * commit f8a32265 - removed 1 file

BFG run is complete!
```

### 🔹 Step 4: Clean Git Objects and Force Push

**Clean up Git objects:**
```powershell
git reflog expire --expire=now --all
git gc --prune=now --aggressive
```

**Remove the current .wpress file (we'll re-add it with LFS):**
```powershell
git rm wp-content/ai1wm-backups/test2-athenas-co-in-20240811-172254-tp5thr.wpress
git commit -m "Remove .wpress file before LFS re-add"
```

**Force push the cleaned history:**
```powershell
git push --force origin main
```

### 🔹 Step 5: Re-add File with Git LFS

**Ensure LFS is tracking .wpress files:**
```powershell
git lfs track "*.wpress"
git add .gitattributes
```

**Re-add the .wpress file:**
```powershell
git add wp-content/ai1wm-backups/test2-athenas-co-in-20240811-172254-tp5thr.wpress
git commit -m "Re-add .wpress file using Git LFS"
git push origin main
```

## 🎯 Expected Results

After completing these steps:
- ✅ Git history will be clean (no large blobs)
- ✅ GitHub will accept the push
- ✅ The .wpress file will be stored via LFS
- ✅ Repository size will be dramatically reduced

## 🚨 Important Notes

1. **Backup**: I've already attempted to create a backup, but since the remote is empty, your local repo is the only copy
2. **Team Coordination**: After force pushing, anyone else with clones should delete them and re-clone
3. **File Safety**: The .wpress file will be temporarily removed and then re-added with LFS

## 🔧 Alternative: Manual Git Filter-Branch (if BFG doesn't work)

If Java installation is problematic, you can use Git's built-in filter-branch:

```powershell
git filter-branch --force --index-filter "git rm --cached --ignore-unmatch wp-content/ai1wm-backups/test2-athenas-co-in-20240811-172254-tp5thr.wpress" --prune-empty --tag-name-filter cat -- --all
```

Then continue with steps 4 and 5 above.

## 📞 Need Help?

If you encounter any issues:
1. Check Java installation: `java -version`
2. Ensure you're in the correct directory: `pwd` should show `C:\Users\bhara\Downloads\staging`
3. Verify BFG file exists: `Test-Path bfg.jar` should return `True`

## 🛡️ Prevent Future Issues: Pre-Commit Hook

After fixing the current issue, add this pre-commit hook to prevent oversized files from ever being committed again:

**Create the hook file:**
```powershell
# Create the pre-commit hook
$hookContent = @'
#!/bin/sh
# Pre-commit hook to prevent large files without LFS

maxsize=100000000  # 100 MB
for file in $(git diff --cached --name-only); do
  if [ -f "$file" ] && [ $(stat -c%s "$file") -gt $maxsize ]; then
    echo "❌ File $file exceeds 100MB. Use Git LFS: git lfs track '$file'"
    exit 1
  fi
done

# Check if large files are properly tracked by LFS
git lfs pre-push origin main 2>/dev/null || {
  echo "⚠️  Warning: Some large files may not be tracked by LFS"
  echo "Run: git lfs track '*.wpress' '*.zip' '*.sql' etc."
}
'@

# Write to pre-commit hook
$hookContent | Out-File -FilePath ".git/hooks/pre-commit" -Encoding UTF8
```

**Make it executable (Git Bash):**
```bash
chmod +x .git/hooks/pre-commit
```

## ✅ Quick Execution Checklist

- [ ] Install Java (`java -version` works)
- [ ] Verify BFG downloaded (`Test-Path bfg.jar` = True)
- [ ] Run BFG: `java -jar bfg.jar --delete-files *.wpress .`
- [ ] Clean objects: `git reflog expire --expire=now --all && git gc --prune=now --aggressive`
- [ ] Remove file: `git rm wp-content/ai1wm-backups/test2-athenas-co-in-20240811-172254-tp5thr.wpress`
- [ ] Commit removal: `git commit -m "Remove .wpress file before LFS re-add"`
- [ ] Force push: `git push --force origin main`
- [ ] Re-add with LFS: `git add wp-content/ai1wm-backups/test2-athenas-co-in-20240811-172254-tp5thr.wpress`
- [ ] Commit LFS: `git commit -m "Re-add .wpress file using Git LFS"`
- [ ] Final push: `git push origin main`
- [ ] Install pre-commit hook (prevention)

## 🧹 Cleanup After Success

Once everything works, you can delete these files:
- `bfg.jar`
- `GIT_LFS_FIX_GUIDE.md`
- `check_blog_public.php`
- `seo_fix.html`
